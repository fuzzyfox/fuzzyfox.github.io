<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\Skill;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $slug = 'projects';

    protected static ?string $navigationIcon = 'lucide-clipboard-list';

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
                                    ->live(onBlur: true)
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

                                Select::make('company')
                                    ->relationship('company', 'name'),

                                MarkdownEditor::make('description')
                                    ->columnSpanFull()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('projects'),
                            ]),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Feature')
                            ->icon('lucide-image')
                            ->collapsed()
                            ->schema([
                                FileUpload::make('feature_image')
                                    ->hiddenLabel()
                                    ->disk('public')
                                    ->directory('projects/features')
                                    ->image(),
                            ]),

                        Section::make('Dates')
                            ->icon('lucide-calendar')
                            ->collapsed()
                            ->schema([
                                DatePicker::make('start_date'),

                                DatePicker::make('end_date'),
                            ]),

                        Section::make('Styling')
                            ->icon('lucide-brush')
                            ->collapsed()
                            ->schema([
                                ColorPicker::make('header_color'),

                                FileUpload::make('header_image')
                                    ->disk('public')
                                    ->directory('projects/headers')
                                    ->image(),
                            ]),

                        Section::make(SkillResource::getTitleCasePluralModelLabel())
                            ->icon(SkillResource::getNavigationIcon())
                            ->collapsed()
                            ->schema([
                                Select::make('skills')
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
                                    ->multiple()
                                    ->allowHtml()
                                    ->columnSpanFull(),
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
                    ->toggleable(),

                TextColumn::make('description')
                    ->words(25)
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('url')
                    ->url(fn ($state) => $state)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('company.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('start_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('end_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('skills')
                    ->limitList(5)
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->name)
                    ->icon(fn ($state) => $state->icon)
                    ->color(fn (Project $record, $state) => when(
                        $state->color,
                        fn ($color) => FilamentColor::processColor($color)
                    ))
                    ->toggleable(),
            ])
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }
}
