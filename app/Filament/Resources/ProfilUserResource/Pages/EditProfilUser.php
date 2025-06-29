<?php

namespace App\Filament\Resources\ProfilUserResource\Pages;

use App\Filament\Resources\ProfilUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilUser extends EditRecord
{
    protected static string $resource = ProfilUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
