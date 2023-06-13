<?php

namespace App\Filament\Resources\EmlakgruplariResource\Pages;

use App\Filament\Resources\EmlakgruplariResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageEmlakgruplaris extends ManageRecords
{
    protected static string $resource = EmlakgruplariResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label(__('form.yeni_ekle'))
            ->modalHeading(__('form.yeni_ekle'))
            ->mutateFormDataUsing(function (array $data): array {
              $data['grupadi'] = reset($data['emlakgruplari']);
              return $data;
            })
            ->using(function (array $data): Model {
              $grup = static::getModel()::create($data);
                LanguageLine::create([
                  'group' => 'emlakgrubu',
                  'key' => $grup->id,
                  'text' => $data['emlakgruplari']
                ]);
              return $grup;
            }),
        ];
    }
}
