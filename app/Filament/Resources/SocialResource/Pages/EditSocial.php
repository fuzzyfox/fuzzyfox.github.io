<?php

namespace App\Filament\Resources\SocialResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\SocialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocial extends EditRecord
{
    protected static string $resource = SocialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
