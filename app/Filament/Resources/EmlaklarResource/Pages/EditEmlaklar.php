<?php

namespace App\Filament\Resources\EmlaklarResource\Pages;

use App\Filament\Resources\EmlaklarResource;
use App\Models\Diller;
use App\Models\Emlakdetay;
use App\Models\Emlakfiyatlari;
use App\Models\Emlaknitelikleri;
use App\Models\Emlakozellikleri;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditEmlaklar extends EditRecord
{
  protected static string $resource = EmlaklarResource::class;

  protected function getActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function mutateFormDataBeforeFill(array $data): array
  {
    $ozellikler = Emlakozellikleri::where('emlak_id', $data['id'])->get();
    $nitelikler = Emlaknitelikleri::where('emlak_id', $data['id'])->get();
    $fiyatlar = Emlakfiyatlari::where('emlak_id', $data['id'])->get();
    $icerikler = Emlakdetay::where('emlak_id', $data['id'])->get();
    foreach ($icerikler as $icerik) {
      $data['sef'][$icerik['dilkodu']] = $icerik['sef'];
      $data['aciklama'][$icerik['dilkodu']] = $icerik['aciklama'];
      $data['baslik'][$icerik['dilkodu']] = $icerik['baslik'];
      $data['detay'][$icerik['dilkodu']] = $icerik['detay'];
    }
    foreach ($fiyatlar as $f) {
      $data['fiyatlar'][$f['sembol']] = $f['fiyat'];
    }
    foreach ($ozellikler as $o) {
      $data['ozellikler'][$o['ozellik_id']] = true;
    }
    foreach ($nitelikler as $n) {
      $data['nitelikler'][$n['nitelik_id']] = $n['deger'];
    }
    return $data;
  }

  protected function handleRecordUpdate(Model $record, array $data): Model
  {
    $record->update($data);
    $nitelikler = array_map(fn($deger, $nitelik_id) => ['emlak_id' => $record->id, 'nitelik_id' => $nitelik_id, 'deger' => $deger], $data['nitelikler'], array_keys($data['nitelikler']));
    $fiyatlar = array_map(fn($fiyat, $sembol) => ['emlak_id' => $record->id, 'fiyat' => $fiyat, 'sembol' => $sembol], $data['fiyatlar'], array_keys($data['fiyatlar']));
    $ozellikler = [];
    foreach($data['ozellikler'] as $ozellikgruplari){
      foreach($ozellikgruplari as $ozellik){
        $ozellikler[] = [
          'emlak_id' => $record->id, 'ozellik_id' => $ozellik
        ];
      }
    }
    Emlakdetay::where('emlak_id', $record->id)->delete();
    Emlaknitelikleri::where('emlak_id', $record->id)->delete();
    Emlakfiyatlari::where('emlak_id', $record->id)->delete();
    Emlakozellikleri::where('emlak_id', $record->id)->delete();

    DB::table('emlakozellikleri')->insert($ozellikler);
    DB::table('emlaknitelikleri')->insert($nitelikler);
    DB::table('emlakfiyatlari')->insert($fiyatlar);
    
    $diller = Diller::all();
    foreach($diller as $dil){
      Emlakdetay::create([
        'emlak_id' => $record->id,
        'dilkodu' => $dil->dilkodu,
        'sef' => $data['sef'][$dil->dilkodu],
        'aciklama' => $data['aciklama'][$dil->dilkodu],
        'baslik' => $data['baslik'][$dil->dilkodu],
        'detay' => $data['detay'][$dil->dilkodu],
      ]);
    }
    return $record;
  }
}
