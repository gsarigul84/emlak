<?php

namespace App\Filament\Resources\NiteliklerResource\Pages;

use App\Filament\Resources\NiteliklerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageNiteliklers extends ManageRecords
{
    protected static string $resource = NiteliklerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
