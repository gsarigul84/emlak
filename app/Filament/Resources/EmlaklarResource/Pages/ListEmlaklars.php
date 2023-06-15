<?php

namespace App\Filament\Resources\EmlaklarResource\Pages;

use App\Filament\Resources\EmlaklarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmlaklars extends ListRecords
{
	protected static string $resource = EmlaklarResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make()
				->modalHeading(__('form.yeni_ekle'))
				->label(__('form.yeni_ekle')),
		];
	}
}
