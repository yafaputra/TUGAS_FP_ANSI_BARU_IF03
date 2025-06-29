<?php

namespace App\Filament\Resources\SparringResource\Pages;

use App\Filament\Resources\SparringResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSparrings extends ListRecords
{
    protected static string $resource = SparringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
