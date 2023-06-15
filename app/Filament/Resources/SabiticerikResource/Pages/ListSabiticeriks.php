<?php

namespace App\Filament\Resources\SabiticerikResource\Pages;

use App\Filament\Resources\SabiticerikResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSabiticeriks extends ListRecords
{
	protected static string $resource = SabiticerikResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make()
				->modalHeading(__('form.yeni_ekle'))
				->label(__('form.yeni_ekle')),
		];
	}
}
