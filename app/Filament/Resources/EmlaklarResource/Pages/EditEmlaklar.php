<?php

namespace App\Filament\Resources\EmlaklarResource\Pages;

use App\Filament\Resources\EmlaklarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmlaklar extends EditRecord
{
    protected static string $resource = EmlaklarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
