<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmlaktipleriResource\Pages;
use App\Models\Emlakgruplari;
use App\Models\Emlaktipleri;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class EmlaktipleriResource extends Resource
{
	protected static ?string $model = Emlaktipleri::class;

	protected static ?string $navigationIcon = 'heroicon-o-collection';

	protected static ?int $navigationSort = 97;

	protected static function getNavigationGroup(): string
	{
		return __('menu.ayarlar');
	}

	protected static function getNavigationLabel(): string
	{
		return __('menu.emlaktipleri');
	}

	public static function form(Form $form): Form
	{
		$schema = [];
		$diller = \App\Models\Diller::all();
		foreach ($diller as $dil) {
			$schema[] = Forms\Components\TextInput::make('emlaktipleri.'.$dil->dilkodu)
				->required()
				->maxLength(255)
				->label(__('form.emlaktipiadi').' - '.$dil->diladi);
		}

		return $form
			->schema(
				array_merge(
					[
						Forms\Components\Select::make('grup_id')
							->options(function () {
								$options = [];
								$emlaktipleri = Emlakgruplari::all();
								foreach ($emlaktipleri as $emlaktipi) {
									$options[$emlaktipi->id] = __('emlakgrubu.'.$emlaktipi->id);
								}

								return $options;
							})
							->required(),
					],
					$schema
				)
			)->columns(1);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('emlaktipi')->label(__('form.emlaktipi'))
					->formatStateUsing(fn (string $state, Model $record) => __('emlaktipleri.'.$record->id)),
				Tables\Columns\TextColumn::make('grup_id')->label(__('form.grup'))
					->formatStateUsing(fn (string $state, Model $record) => __('emlakgrubu.'.$record->grup_id)),
			])
			->filters([
				//
			])
			->actions([
				Tables\Actions\EditAction::make()
					->mutateRecordDataUsing(function (array $data): array {
						$data['emlaktipleri'] = LanguageLine::where('group', 'emlaktipleri')
							->where('key', $data['id'])
							->first()
						  ?->text;

						return $data;
					})
					->using(function (Model $record, array $data): Model {
						$data['emlaktipi'] = reset($data['emlaktipleri']);
						$record->update($data);
						LanguageLine::where('group', 'emlaktipleri')
							->where('key', $record->id)
							->update([
								'text' => $data['emlaktipleri'],
							]);

						return $record;
					}),
				Tables\Actions\DeleteAction::make()
					->after(function (Model $record) {
						LanguageLine::where('group', 'emlaktipleri')
							->where('key', $record->id)
							->delete();
					}),
			])
			->bulkActions([
				// Tables\Actions\DeleteBulkAction::make(),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageEmlaktipleris::route('/'),
		];
	}
}
