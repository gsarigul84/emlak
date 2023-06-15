<?php

namespace App\Filament\Resources\IlcelerResource\Pages;

use App\Filament\Resources\IlcelerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageIlcelers extends ManageRecords
{
	protected static string $resource = IlcelerResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make()
				->modalHeading(__('form.yeni_ekle'))
				->label(__('form.yeni_ekle'))
				->mutateFormDataUsing(function (array $data): array {
					$data['ilceadi'] = reset($data['ilceadlari']);

					return $data;
				})
				->using(function (array $data): Model {
					$yeniilce = static::getModel()::create($data);
					LanguageLine::create([
						'group' => 'ilceler',
						'key' => $yeniilce->id,
						'text' => $data['ilceadlari'],
					]);

					return $yeniilce;
				}),
		];
	}
}
