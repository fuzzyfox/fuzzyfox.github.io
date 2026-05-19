<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\PositionResource\Pages\ListPositions;
use App\Filament\Resources\PositionResource\Pages\CreatePosition;
use App\Filament\Resources\PositionResource\Pages\ViewPosition;
use App\Filament\Resources\PositionResource\Pages\EditPosition;
use App\Enums\PositionType;
use App\Filament\Resources\PositionResource\Pages;
use App\Models\Position;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Symfony\Component\Intl\Countries;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static string | \BackedEnum | null $navigationIcon = 'lucide-briefcase';

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make(static::getTitleCaseModelLabel())
                            ->icon(static::getNavigationIcon())
                            ->collapsible()
                            ->columns()
                            ->schema([
                                TextInput::make('title')
                                    ->required(),

                                TextInput::make('company')
                                    ->required(),

                                MarkdownEditor::make('description')
                                    ->columnSpanFull(),
                            ]),

                        Section::make(SkillResource::getTitleCasePluralModelLabel())
                            ->icon(SkillResource::getNavigationIcon())
                            ->collapsed()
                            ->schema([
                                Select::make('skills')
                                    ->hiddenLabel()
                                    ->relationship('skills', 'name')
                                    ->createOptionForm(fn (Schema $schema) => SkillResource::form($schema))
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

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make(static::getTitleCaseModelLabel().' type')
                            ->icon(static::getNavigationIcon())
                            ->collapsed()
                            ->schema([
                                Select::make('type')
                                    ->hiddenLabel()
                                    ->options(PositionType::class)
                                    ->required(),
                            ]),

                        Section::make('Location')
                            ->icon('lucide-map')
                            ->collapsed()
                            ->schema([
                                TextInput::make('locality')
                                    ->label('City')
                                    ->datalist(Position::distinct()->pluck('locality')->all()),

                                Select::make('region')
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

                        Section::make('Dates')
                            ->icon('lucide-calendar')
                            ->collapsed()
                            ->schema([
                                DatePicker::make('start_date')
                                    ->required(),

                                DatePicker::make('end_date'),
                            ]),

                        Section::make('Logo')
                            ->icon('lucide-image')
                            ->collapsed()
                            ->schema([
                                FileUpload::make('logo')
                                    ->hiddenLabel()
                                    ->disk('public')
                                    ->directory('positions/logos')
                                    ->image(),
                            ]),

                        Section::make('Styling')
                            ->icon('lucide-brush')
                            ->collapsed()
                            ->schema([
                                ColorPicker::make('header_color'),

                                FileUpload::make('header_image')
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
                TextColumn::make('title')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('company')
                    ->toggleable()
                    ->searchable(),

                ImageColumn::make('logo')
                    ->toggleable()
                    ->square(),

                TextColumn::make('type')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('locality')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('region')
                    ->formatStateUsing(fn (?string $state) => $state
                        ? country2emoji($state).' '.Countries::getName($state)
                        : null)
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('start_date')
                    ->date('M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->date('M Y')
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
            ->defaultSort('start_date', 'desc')
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPositions::route('/'),
            'create' => CreatePosition::route('/create'),
            'view' => ViewPosition::route('/{record}'),
            'edit' => EditPosition::route('/{record}/edit'),
        ];
    }
}
