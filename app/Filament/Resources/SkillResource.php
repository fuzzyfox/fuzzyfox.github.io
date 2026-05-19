<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\SkillResource\RelationManagers\PositionsRelationManager;
use App\Filament\Resources\SkillResource\Pages\ListSkills;
use App\Filament\Resources\SkillResource\Pages\CreateSkill;
use App\Filament\Resources\SkillResource\Pages\ViewSkill;
use App\Filament\Resources\SkillResource\Pages\EditSkill;
use App\Enums\SkillLevel;
use App\Filament\Forms\Components\IconSelect;
use App\Filament\Resources\SkillResource\Pages;
use App\Filament\Resources\SkillResource\RelationManagers;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
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

    protected static string | \BackedEnum | null $navigationIcon = 'lucide-tags';

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('slug')
                    ->alphaDash()
                    ->required(),

                TextInput::make('url')
                    ->url(),

                Select::make('parent_id')
                    ->relationship(name: 'parent', titleAttribute: 'name')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(function (Skill $record): string {
                        if (! $record->icon) {
                            return $record->name;
                        }

                        return svg($record->icon, attributes: ['style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block; color: '.($record->color ?: 'currentColor').';'])->toHtml().' '.$record->name;
                    })
                    ->allowHtml(),

                Textarea::make('description')
                    ->columnSpanFull(),

                TextInput::make('start_year')
                    ->numeric()
                    ->integer()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $experience = (int) $get('years_of_experience');

                        if (! $experience) {
                            return;
                        }

                        $set('years_of_experience', Number::clamp($experience, 0, today()->year - (int) $state));
                    }),

                TextInput::make('years_of_experience')
                    ->placeholder(fn (Get $get) => when($get('start_year'), fn ($year) => today()->year - (int) $year))
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->maxValue(fn (Get $get) => when($get('start_year'), fn ($year) => today()->year - (int) $year))
                    ->live(),

                Select::make('level')
                    ->options(SkillLevel::class),

                Select::make('is_promoted')
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
                TextColumn::make('name')
                    ->icon(fn (Skill $record) => $record->icon)
                    ->iconColor(fn (Skill $record) => $record->color ? FilamentColor::processColor($record->color) : null)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('url')
                    ->url(fn (?string $state) => $state, shouldOpenInNewTab: true)
                    ->toggleable(),

                TextColumn::make('description')
                    ->formatStateUsing(fn ($state) => new HtmlString(Str::inlineMarkdown($state)))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                TextColumn::make('parent.name')
                    ->icon(fn (Skill $record) => $record->parent?->icon)
                    ->iconColor(fn (Skill $record) => $record->parent?->color ? FilamentColor::processColor($record->parent?->color) : null)
                    ->extraAttributes(['style' => 'opacity: 0.4;'])
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('start_year')
                    ->placeholder('Not specified')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('level')
                    ->placeholder('Not specified')
                    ->toggleable(),

                TextColumn::make('years_of_experience')
                    ->label('Exp.')
                    ->placeholder('Not specified')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                ToggleColumn::make('is_promoted')
                    ->label('Promoted')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->reorderable('sort')
            ->filters([
                TernaryFilter::make('has_icon')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('icon'),
                        false: fn ($query) => $query->whereNull('icon'),
                    ),

                TernaryFilter::make('has_url')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('url'),
                        false: fn ($query) => $query->whereNull('url'),
                    ),

                TernaryFilter::make('has_parent')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('parent'),
                        false: fn ($query) => $query->whereNull('parent'),
                    ),

                TernaryFilter::make('has_start_year')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('start_year'),
                        false: fn ($query) => $query->whereNull('start_year'),
                    ),

                TernaryFilter::make('has_level')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('level'),
                        false: fn ($query) => $query->whereNull('level'),
                    ),

                TernaryFilter::make('has_years_of_experience')
                    ->label('Has experience')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('years_of_experience'),
                        false: fn ($query) => $query->whereNull('years_of_experience'),
                    ),

                SelectFilter::make('parent_id')
                    ->relationship('parent', 'name')
                    ->getOptionLabelFromRecordUsing(function (Skill $record): string {
                        if (! $record->icon) {
                            return $record->name;
                        }

                        return svg($record->icon, attributes: ['style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block; color: '.($record->color ?: 'currentColor').';'])->toHtml().' '.$record->name;
                    })
                    ->searchable()
                    ->multiple()
                    ->modifyFormFieldUsing(fn (Select $field) => $field->allowHtml()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PositionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkills::route('/'),
            'create' => CreateSkill::route('/create'),
            'view' => ViewSkill::route('/{record}'),
            'edit' => EditSkill::route('/{record}/edit'),
        ];
    }
}
