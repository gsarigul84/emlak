<?php

namespace App\Filament\Resources\DillerResource\Pages;

use App\Filament\Resources\DillerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDillers extends ManageRecords
{
    protected static string $resource = DillerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
