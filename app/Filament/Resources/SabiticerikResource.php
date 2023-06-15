<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SabiticerikResource\Pages;
use App\Models\Diller;
use App\Models\Sabiticerik;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SabiticerikResource extends Resource
{
	protected static ?string $model = Sabiticerik::class;

	protected static ?string $navigationIcon = 'heroicon-o-collection';

	protected static ?int $navigationSort = 2;

	protected static function getNavigationLabel(): string
	{
		return __('menu.sabiticerik');
	}

	public static function getIcerikBilgileri(): array
	{
		return [Forms\Components\TextInput::make('icerikadi')
			->label(__('form.icerikadi'))
			->required()
			->maxLength(255), ];
	}

	public static function getIcerikRow(): array
	{
		$schema = [];
		$diller = Diller::all();
		foreach ($diller as $dil) {
			$schema[] = Forms\Components\Tabs\Tab::make('tab_'.$dil->id)
				->label($dil->diladi)
				->schema([
					Forms\Components\TextInput::make('sef.'.$dil->dilkodu)
						->label(__('form.sefurl')),
					Forms\Components\TextInput::make('aciklama.'.$dil->dilkodu)
						->label(__('form.aciklama')),
					Forms\Components\TextInput::make('baslik.'.$dil->dilkodu)
						->label(__('form.baslik')),
					Forms\Components\RichEditor::make('detay.'.$dil->dilkodu)
						->label(__('form.icerik'))
						->required(),
				]);
		}

		return [
			Grid::make('icerikler')
				->columns(1)
				->schema([
					Forms\Components\Tabs::make('icerikler')
						->tabs($schema),
				]),

		];
	}

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				...self::getIcerikBilgileri(),
				...self::getIcerikRow(),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('icerikadi')
					->label(__('form.icerikadi')),
				Tables\Columns\TextColumn::make('created_at')
					->label(__('form.olusturulma_tarihi'))
					->dateTime(),
				// Tables\Columns\TextColumn::make('updated_at')
				//     ->dateTime(),
			])
			->filters([
				//
			])
			->actions([
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
			])
			->bulkActions([
				// Tables\Actions\DeleteBulkAction::make(),
			]);
	}

	public static function getRelations(): array
	{
		return [
			//
		];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListSabiticeriks::route('/'),
			'create' => Pages\CreateSabiticerik::route('/create'),
			'edit' => Pages\EditSabiticerik::route('/{record}/edit'),
		];
	}
}
