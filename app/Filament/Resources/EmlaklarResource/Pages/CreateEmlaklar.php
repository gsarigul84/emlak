<?php

namespace App\Filament\Resources\EmlaklarResource\Pages;

use App\Filament\Resources\EmlaklarResource;
use App\Models\Diller;
use App\Models\Emlakdetay;
use App\Models\Emlakfiyatlari;
use App\Models\Emlaknitelikleri;
use App\Models\Emlakozellikleri;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateEmlaklar extends CreateRecord
{
    protected static string $resource = EmlaklarResource::class;

    protected function handleRecordCreation(array $data): Model
    {
      $emlak = static::getModel()::create($data);
      $nitelikler = array_map(fn($deger, $nitelik_id) => ['emlak_id' => $emlak->id, 'nitelik_id' => $nitelik_id, 'deger' => $deger], $data['nitelikler'], array_keys($data['nitelikler']));
      $fiyatlar = array_map(fn($fiyat, $sembol) => ['emlak_id' => $emlak->id, 'fiyat' => $fiyat, 'sembol' => $sembol], $data['fiyatlar'], array_keys($data['fiyatlar']));
      $ozellikler = [];
      foreach($data['ozellikler'] as $ozellikgruplari){
        foreach($ozellikgruplari as $ozellik){
          $ozellikler[] = [
            'emlak_id' => $emlak->id, 'ozellik_id' => $ozellik
          ];
        }
      }
      DB::table('emlakozellikleri')->insert($ozellikler);
      DB::table('emlaknitelikleri')->insert($nitelikler);
      DB::table('emlakfiyatlari')->insert($fiyatlar);
      
      $diller = Diller::all();
      foreach($diller as $dil){
        Emlakdetay::create([
          'emlak_id' => $emlak->id,
          'dilkodu' => $dil->dilkodu,
          'sef' => $data['sef'][$dil->dilkodu],
          'aciklama' => $data['aciklama'][$dil->dilkodu],
          'baslik' => $data['baslik'][$dil->dilkodu],
          'detay' => $data['detay'][$dil->dilkodu],
        ]);
      }
      return $emlak;
    }
}
