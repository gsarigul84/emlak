<?php

namespace App\Filament\Resources\EmlaktipleriResource\Pages;

use App\Filament\Resources\EmlaktipleriResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageEmlaktipleris extends ManageRecords
{
    protected static string $resource = EmlaktipleriResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
              $data['emlaktipi'] = reset($data['emlaktipleri']);
              return $data;
            })
            ->using(function (array $data): Model {
              $yeniil = static::getModel()::create($data);
                LanguageLine::create([
                  'group' => 'emlaktipleri',
                  'key' => $yeniil->id,
                  'text' => $data['emlaktipleri']
                ]);
              return $yeniil;
            }),
        ];
    }
}
