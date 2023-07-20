<?php

namespace App\Filament\Resources\SabiticerikResource\Pages;

use App\Filament\Resources\SabiticerikResource;
use App\Models\Diller;
use App\Models\SabiticerikDetay;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateSabiticerik extends CreateRecord
{
	protected static string $resource = SabiticerikResource::class;

	protected function handleRecordCreation(array $data): Model
	{
    $data['anahtar'] = Str::slug($data['icerikadi']);
		$icerik = static::getModel()::create($data);
		$diller = Diller::all();
		foreach ($diller as $dil) {
			SabiticerikDetay::create([
				'icerik_id' => $icerik->id,
				'dilkodu' => $dil->dilkodu,
				'sef' => $data['sef'][$dil->dilkodu],
				'aciklama' => $data['aciklama'][$dil->dilkodu],
				'baslik' => $data['baslik'][$dil->dilkodu],
				'icerik' => $data['detay'][$dil->dilkodu],
			]);
		}

		return $icerik;
	}
}
