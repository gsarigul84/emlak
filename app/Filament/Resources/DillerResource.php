<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DillerResource\Pages;
use App\Models\Diller;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DillerResource extends Resource
{
	protected static ?string $model = Diller::class;

	protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

	protected static ?int $navigationSort = 99;

	protected static function getNavigationGroup(): string
	{
		return __('menu.ayarlar');
	}

	protected static function getNavigationLabel(): string
	{
		return __('menu.diller');
	}

	public function __construct()
	{
		parent::__construct();
		$this->modelLabel = __('form.yeni_ekle');
	}

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\TextInput::make('diladi')
					->label(__('form.diladi'))
					->required()
					->maxLength(255),
				Forms\Components\TextInput::make('dilkodu')
					->label(__('form.dilkodu'))
					->required()
					->maxLength(255),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('diladi')->label(__('form.diladi')),
				Tables\Columns\TextColumn::make('dilkodu')->label(__('form.dilkodu')),
				// Tables\Columns\TextColumn::make('created_at')->label(__('form.olusturulma_tarihi'))
				//     ->dateTime(),
				// Tables\Columns\TextColumn::make('updated_at')->label(__('form.guncelleme_tarihi'))
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

	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageDillers::route('/'),
		];
	}
}
