<?php

namespace App\Filament\Resources\NiteliklerResource\Pages;

use App\Filament\Resources\NiteliklerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageNiteliklers extends ManageRecords
{
    protected static string $resource = NiteliklerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalHeading(__('form.yeni_ekle'))
            ->label(__('form.yeni_ekle'))
            ->mutateFormDataUsing(function (array $data): array {
              $data['nitelikadi'] = reset($data['nitelikadlari']);
              if($data['tip'] == 'coktansecmeli' || $data['tip'] == 'coklusecmeli'){
                $data['degerler'] = array_map(function ($deger) {
                  return $deger['anahtar'];
                }, $data['degerler_raw']);
              }
              return $data;
            })

            ->using(function (array $data): Model {
              $nitelik = static::getModel()::create($data);
                LanguageLine::create([
                  'group' => 'nitelik',
                  'key' => $nitelik->id,
                  'text' => $data['nitelikadlari']
                ]);
                if($data['tip'] == 'coktansecmeli' || $data['tip'] == 'coklusecmeli'){
                  foreach ($data['degerler_raw'] as $deger) {
                    LanguageLine::create([
                      'group' => 'nitelikdegeri',
                      'key' => $nitelik->id . '-deger-' . $deger['anahtar'],
                      'text' => array_filter($deger, fn ($item, $key) => $key != 'anahtar', ARRAY_FILTER_USE_BOTH)
                    ]);
                  }
                }
              return $nitelik;
            }),
        ];
    }
}
