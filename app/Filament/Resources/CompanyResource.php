<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers\PositionsRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\ProjectsRelationManager;
use App\Models\Company;
use App\Models\Project;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Intl\Countries;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $slug = 'companies';

    protected static ?string $navigationIcon = 'lucide-building-2';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make(static::getTitleCaseModelLabel())
                            ->icon(static::getNavigationIcon())
                            ->columns()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live()
                                    ->unique(ignoreRecord: true)
                                    ->afterStateUpdated(function (?string $state, Get $get, Set $set) {
                                        if ($state && ! $get('slug')) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                TextInput::make('url')
                                    ->url(),
                            ]),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Location')
                            ->icon('lucide-map')
                            ->collapsed()
                            ->schema([
                                TextInput::make('locality')
                                    ->label('City')
                                    ->datalist(static::getModel()::distinct()->pluck('locality')->all()),

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

                        Section::make('Logo')
                            ->icon('lucide-image')
                            ->collapsed()
                            ->schema([
                                FileUpload::make('logo')
                                    ->hiddenLabel()
                                    ->disk('public')
                                    ->directory('companies/logos')
                                    ->image(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('logo')
                    ->alignCenter()
                    ->square()
                    ->toggleable(),

                TextColumn::make('url')
                    ->url(fn (?string $state) => $state)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('locality')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('region')
                    ->formatStateUsing(fn (?string $state) => $state
                        ? country2emoji($state).' '.Countries::getName($state)
                        : null)
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

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
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            PositionsRelationManager::class,
            ProjectsRelationManager::class,
        ];
    }
}
