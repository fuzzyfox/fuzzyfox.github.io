<?php

namespace App\Filament\Resources;

use App\Enums\PositionType;
use App\Filament\Resources\PositionResource\Pages;
use App\Models\Position;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Symfony\Component\Intl\Countries;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'lucide-briefcase';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'company', 'locality', 'skills.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return array_filter([
            'Company' => $record->company,
            'Locality' => $record->locality,
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\Section::make(static::getTitleCaseModelLabel())
                            ->icon(static::getNavigationIcon())
                            ->collapsible()
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required(),

                                Forms\Components\TextInput::make('company')
                                    ->required(),

                                Forms\Components\MarkdownEditor::make('description')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make(SkillResource::getTitleCasePluralModelLabel())
                            ->icon(SkillResource::getNavigationIcon())
                            ->collapsed()
                            ->schema([
                                Forms\Components\Select::make('skills')
                                    ->hiddenLabel()
                                    ->relationship('skills', 'name')
                                    ->createOptionForm(fn (Form $form) => SkillResource::form($form))
                                    ->getOptionLabelFromRecordUsing(function (Skill $record): string {
                                        if (! $record->icon) {
                                            return $record->name;
                                        }

                                        return svg(
                                            name: $record->icon,
                                            attributes: [
                                                'style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block; color: '.($record->color ?: 'currentColor').';',
                                            ]
                                        )->toHtml().' '.$record->name;
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(Skill::count() + 100)
                                    ->multiple()
                                    ->allowHtml()
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Forms\Components\Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Section::make(static::getTitleCaseModelLabel().' type')
                            ->icon(static::getNavigationIcon())
                            ->collapsed()
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->hiddenLabel()
                                    ->options(PositionType::class)
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Location')
                            ->icon('lucide-map')
                            ->collapsed()
                            ->schema([
                                Forms\Components\TextInput::make('locality')
                                    ->label('City')
                                    ->datalist(Position::distinct()->pluck('locality')->all()),

                                Forms\Components\Select::make('region')
                                    ->label('Country')
                                    ->options(fn () => Arr::map(
                                        Arr::sort(
                                            Arr::mapWithKeys(
                                                Countries::getCountryCodes(),
                                                fn (string $countryCode
                                                ) => [$countryCode => Countries::getName($countryCode)]
                                            ),
                                        ),
                                        fn ($country, $code) => country2emoji($code).' '.$country
                                    ))
                                    ->searchable()
                                    ->preload()
                                    ->live(onBlur: true),
                            ]),

                        Forms\Components\Section::make('Dates')
                            ->icon('lucide-calendar')
                            ->collapsed()
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->required(),

                                Forms\Components\DatePicker::make('end_date'),
                            ]),

                        Forms\Components\Section::make('Logo')
                            ->icon('lucide-image')
                            ->collapsed()
                            ->schema([
                                FileUpload::make('logo')
                                    ->hiddenLabel()
                                    ->disk('public')
                                    ->directory('positions/logos')
                                    ->image(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('company')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                Tables\Columns\TextColumn::make('locality')
                    ->searchable(),

                Tables\Columns\TextColumn::make('region')
                    ->formatStateUsing(fn (?string $state) => $state
                        ? country2emoji($state).' '.Countries::getName($state)
                        : null)
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->date('M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->date('M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'view' => Pages\ViewPosition::route('/{record}'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
