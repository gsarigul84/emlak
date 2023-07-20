<?php

namespace App\Filament\Resources\SabiticerikResource\Pages;

use App\Filament\Resources\SabiticerikResource;
use App\Models\Diller;
use App\Models\SabiticerikDetay;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

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

  protected function handleRecordUpdate(Model $record, array $data): Model
  {
    $record->update($data);
    $diller = Diller::all();
    foreach($diller as $dil){
      $varmi = SabiticerikDetay::where('icerik_id', $record->id)
        ->where('dilkodu', $dil->dilkodu)
        ->first();
      if(!$varmi){
        SabiticerikDetay::create([
          'icerik_id' => $record->id,
          'dilkodu' => $dil->dilkodu,
          'sef' =>  $data['sef'][$dil->dilkodu],
          'aciklama' =>  $data['aciklama'][$dil->dilkodu],
          'baslik' => $data['baslik'][$dil->dilkodu] ,
          'icerik' => $data['detay'][$dil->dilkodu]
        ]);
      }else{
        $varmi->fill([
          'sef' =>  $data['sef'][$dil->dilkodu],
          'aciklama' =>  $data['aciklama'][$dil->dilkodu],
          'baslik' => $data['baslik'][$dil->dilkodu] ,
          'icerik' => $data['detay'][$dil->dilkodu]
        ])->save();
      }
    }
    return $record;
  }
}
