<?php

namespace App\Filament\Resources\FiyatlandirmaResource\Pages;

use App\Filament\Resources\FiyatlandirmaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageFiyatlandirmas extends ManageRecords
{
    protected static string $resource = FiyatlandirmaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalHeading(__('form.yeni_ekle'))
            ->label(__('form.yeni_ekle'))
            ->mutateFormDataUsing(function (array $data): array {
              $data['sembol'] = reset($data['semboladlari']);
              return $data;
            })
            ->using(function (array $data): Model {
              $sembol = static::getModel()::create($data);
                LanguageLine::create([
                  'group' => 'fiyatlandirma',
                  'key' => $sembol->id,
                  'text' => $data['semboladlari']
                ]);
              return $sembol;
            }),
        ];
    }
}
