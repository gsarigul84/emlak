<?php

namespace App\Filament\Resources\EmlaklarResource\Pages;

use App\Filament\Resources\EmlaklarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEmlaklar extends CreateRecord
{
    protected static string $resource = EmlaklarResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }
}
