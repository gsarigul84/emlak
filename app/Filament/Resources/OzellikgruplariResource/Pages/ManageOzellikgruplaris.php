<?php

namespace App\Filament\Resources\OzellikgruplariResource\Pages;

use App\Filament\Resources\OzellikgruplariResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageOzellikgruplaris extends ManageRecords
{
    protected static string $resource = OzellikgruplariResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalHeading(__('form.yeni_ekle'))
            ->label(__('form.yeni_ekle'))
            ->mutateFormDataUsing(function (array $data): array {
              $data['grupadi'] = reset($data['grupadlari']);
              return $data;
            })
            ->using(function (array $data): Model {
              $yeniozellikgrubu = static::getModel()::create($data);
                LanguageLine::create([
                  'group' => 'ozellikgruplari',
                  'key' => $yeniozellikgrubu->id,
                  'text' => $data['grupadlari']
                ]);
              return $yeniozellikgrubu;
            }),
        ];
    }
}
