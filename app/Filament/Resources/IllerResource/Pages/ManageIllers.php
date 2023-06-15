<?php

namespace App\Filament\Resources\IllerResource\Pages;

use App\Filament\Resources\IllerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageIllers extends ManageRecords
{
	protected static string $resource = IllerResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make()
				->modalHeading(__('form.yeni_ekle'))
				->label(__('form.yeni_ekle'))
				->mutateFormDataUsing(function (array $data): array {
					$data['iladi'] = reset($data['iladlari']);

					return $data;
				})
				->using(function (array $data): Model {
					$yeniil = static::getModel()::create($data);
					LanguageLine::create([
						'group' => 'iller',
						'key' => $yeniil->id,
						'text' => $data['iladlari'],
					]);

					return $yeniil;
				}),
		];
	}
}
