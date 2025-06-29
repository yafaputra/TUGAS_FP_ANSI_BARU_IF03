<?php

namespace App\Filament\Resources\SparringResource\Pages;

use App\Filament\Resources\SparringResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSparring extends EditRecord
{
    protected static string $resource = SparringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
