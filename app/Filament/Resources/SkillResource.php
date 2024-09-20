<?php

namespace App\Filament\Resources;

use App\Enums\SkillLevel;
use App\Filament\Forms\Components\IconSelect;
use App\Filament\Resources\SkillResource\Pages;
use App\Filament\Resources\SkillResource\RelationManagers;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'lucide-tags';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return array_filter([
            'Slug' => $record->slug,
            'Level' => $record->level?->getLabel(),
            'Parent' => $record->parent?->name,
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->alphaDash()
                    ->required(),

                Forms\Components\Select::make('parent_id')
                    ->relationship(name: 'parent', titleAttribute: 'name')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(function (Skill $record): string {
                        if (! $record->icon) {
                            return $record->name;
                        }

                        return svg($record->icon, attributes: ['style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block; color: '.($record->color ?: 'currentColor').';'])->toHtml().' '.$record->name;
                    })
                    ->allowHtml(),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('start_year')
                    ->numeric()
                    ->integer()
                    ->live()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state) {
                        $experience = (int) $get('years_of_experience');

                        if (! $experience) {
                            return;
                        }

                        $set('years_of_experience', Number::clamp($experience, 0, today()->year - (int) $state));
                    }),

                Forms\Components\TextInput::make('years_of_experience')
                    ->placeholder(fn (Forms\Get $get) => when($get('start_year'), fn ($year) => today()->year - (int) $year))
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->maxValue(fn (Forms\Get $get) => when($get('start_year'), fn ($year) => today()->year - (int) $year))
                    ->live(),

                Forms\Components\Select::make('level')
                    ->options(SkillLevel::class),

                Forms\Components\Select::make('is_promoted')
                    ->dehydrateStateUsing(fn ($state) => (bool) $state)
                    ->options([
                        false => 'Not promoted',
                        true => 'Promoted',
                    ])
                    ->selectablePlaceholder(false),

                IconSelect::make('icon'),

                ColorPicker::make('color'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->icon(fn (Skill $record) => $record->icon)
                    ->iconColor(fn (Skill $record) => $record->color ? FilamentColor::processColor($record->color) : null)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->formatStateUsing(fn ($state) => new HtmlString(Str::inlineMarkdown($state)))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                Tables\Columns\TextColumn::make('parent.name')
                    ->icon(fn (Skill $record) => $record->parent?->icon)
                    ->iconColor(fn (Skill $record) => $record->parent?->color ? FilamentColor::processColor($record->parent?->color) : null)
                    ->extraAttributes(['style' => 'opacity: 0.4;'])
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('start_year')
                    ->placeholder('Not specified')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('level')
                    ->placeholder('Not specified')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('years_of_experience')
                    ->label('Exp.')
                    ->placeholder('Not specified')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\ToggleColumn::make('is_promoted')
                    ->label('Promoted')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->reorderable('sort')
            ->filters([
                Tables\Filters\TernaryFilter::make('icon')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('icon'),
                        false: fn ($query) => $query->whereNull('icon'),
                    ),

                Tables\Filters\SelectFilter::make('parent_id')
                    ->relationship('parent', 'name')
                    ->getOptionLabelFromRecordUsing(function (Skill $record): string {
                        if (! $record->icon) {
                            return $record->name;
                        }

                        return svg($record->icon, attributes: ['style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block; color: '.($record->color ?: 'currentColor').';'])->toHtml().' '.$record->name;
                    })
                    ->searchable()
                    ->preload()
                    ->modifyFormFieldUsing(fn (Forms\Components\Select $field) => $field->allowHtml()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PositionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'view' => Pages\ViewSkill::route('/{record}'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
