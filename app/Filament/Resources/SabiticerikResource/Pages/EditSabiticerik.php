<?php

namespace App\Filament\Resources\SabiticerikResource\Pages;

use App\Filament\Resources\SabiticerikResource;
use App\Models\SabiticerikDetay;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSabiticerik extends EditRecord
{
    protected static string $resource = SabiticerikResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->label(__('form.sil')),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
  {
    $icerikler = SabiticerikDetay::where('icerik_id', $data['id'])->get();
    foreach ($icerikler as $icerik) {
      $data['sef'][$icerik['dilkodu']] = $icerik['sef'];
      $data['aciklama'][$icerik['dilkodu']] = $icerik['aciklama'];
      $data['baslik'][$icerik['dilkodu']] = $icerik['baslik'];
      $data['detay'][$icerik['dilkodu']] = $icerik['icerik'];
    }
    return $data;
  }

}
