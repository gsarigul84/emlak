<?php

namespace App\Filament\Resources\OzelliklerResource\Pages;

use App\Filament\Resources\OzelliklerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageOzelliklers extends ManageRecords
{
    protected static string $resource = OzelliklerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make() 
            ->mutateFormDataUsing(function (array $data): array {
              $data['ozellikadi'] = reset($data['ozellikadlari']);
              return $data;
            })
            ->using(function (array $data): Model {
              $grup = static::getModel()::create($data);
                LanguageLine::create([
                  'group' => 'ozellik',
                  'key' => $grup->id,
                  'text' => $data['ozellikadlari']
                ]);
              return $grup;
            }),
        ];
    }
}
