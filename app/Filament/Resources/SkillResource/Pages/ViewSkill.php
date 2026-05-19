<?php

namespace App\Filament\Resources\SkillResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\SkillResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSkill extends ViewRecord
{
    protected static string $resource = SkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
