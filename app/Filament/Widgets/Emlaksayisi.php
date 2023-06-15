<?php

namespace App\Filament\Widgets;

use App\Models\Emlaklar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Emlaksayisi extends BaseWidget
{
	protected function getCards(): array
	{
		return [
			Card::make(__('widget.emlaksayisi'), Emlaklar::count()),
		];
	}
}
