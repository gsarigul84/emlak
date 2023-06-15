<?php

namespace App\Filament\Resources\SemtlerResource\Pages;

use App\Filament\Resources\SemtlerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class ManageSemtlers extends ManageRecords
{
	protected static string $resource = SemtlerResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make()
				->modalHeading(__('form.yeni_ekle'))
				->label(__('form.yeni_ekle'))
				->mutateFormDataUsing(function (array $data): array {
					$data['semtadi'] = reset($data['semtadlari']);

					return $data;
				})
				->using(function (array $data): Model {
					$yemsemt = static::getModel()::create($data);
					LanguageLine::create([
						'group' => 'semtler',
						'key' => $yemsemt->id,
						'text' => $data['semtadlari'],
					]);

					return $yemsemt;
				}),
		];
	}
}
