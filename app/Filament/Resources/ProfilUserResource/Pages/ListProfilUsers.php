<?php

namespace App\Filament\Resources\ProfilUserResource\Pages;

use App\Filament\Resources\ProfilUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilUsers extends ListRecords
{
    protected static string $resource = ProfilUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
