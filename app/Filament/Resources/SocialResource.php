<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\SocialResource\Pages\ListSocials;
use App\Filament\Resources\SocialResource\Pages\CreateSocial;
use App\Filament\Resources\SocialResource\Pages\ViewSocial;
use App\Filament\Resources\SocialResource\Pages\EditSocial;
use App\Filament\Forms\Components\IconSelect;
use App\Filament\Resources\SocialResource\Pages;
use App\Models\Social;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables;
use Filament\Tables\Table;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static string | \BackedEnum | null $navigationIcon = 'lucide-radio-tower';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('platform')
                    ->required(),

                TextInput::make('url')
                    ->required(),

                IconSelect::make('icon')
                    ->required(),

                ColorPicker::make('color'),

                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('platform')
                    ->icon(fn (Social $record) => $record->icon)
                    ->iconColor(fn (Social $record) => $record->color ? FilamentColor::processColor($record->color) : null)
                    ->searchable(),

                TextColumn::make('url')
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
            ->reorderable('sort')
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
            'index' => ListSocials::route('/'),
            'create' => CreateSocial::route('/create'),
            'view' => ViewSocial::route('/{record}'),
            'edit' => EditSocial::route('/{record}/edit'),
        ];
    }
}
