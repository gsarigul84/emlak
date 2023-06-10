<?php

namespace App\Filament\Resources\SabiticerikResource\Pages;

use App\Filament\Resources\SabiticerikResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSabiticerik extends EditRecord
{
    protected static string $resource = SabiticerikResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
