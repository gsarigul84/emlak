<?php

namespace App\Filament\Resources\MahallelerResource\Pages;

use App\Filament\Resources\MahallelerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageMahallelers extends ManageRecords
{
	protected static string $resource = MahallelerResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make()
				->modalHeading(__('form.yeni_ekle'))
				->label(__('form.yeni_ekle'))
				->mutateFormDataUsing(function (array $data): array {
					$data['mahalleadi'] = reset($data['mahalleadlari']);

					return $data;
				})
				->using(function (array $data): Model {
					$yenimahalle = static::getModel()::create($data);
					LanguageLine::create([
						'group' => 'mahalleler',
						'key' => $yenimahalle->id,
						'text' => $data['mahalleadlari'],
					]);

					return $yenimahalle;
				}),
		];
	}
}
