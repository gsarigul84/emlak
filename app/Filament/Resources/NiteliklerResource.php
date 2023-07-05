<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NiteliklerResource\Pages;
use App\Models\Nitelikler;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class NiteliklerResource extends Resource
{
	protected static ?string $model = Nitelikler::class;

	protected static ?string $navigationIcon = 'heroicon-o-collection';

	protected static ?int $navigationSort = 91;

	protected static function getNavigationGroup(): string
	{
		return __('menu.ayarlar');
	}

	protected static function getNavigationLabel(): string
	{
		return __('menu.nitelikler');
	}

	public static function form(Form $form): Form
	{
		$schema = [];
		$altdegerler = [];
		$diller = \App\Models\Diller::all();
		foreach ($diller as $dil) {
			$schema[] = Forms\Components\TextInput::make('nitelikadlari.'.$dil->dilkodu)
				->required()
				->maxLength(255)
				->label(__('form.nitelik').' - '.$dil->diladi);
			$altdegerler[] = Forms\Components\TextInput::make($dil->dilkodu)
				->required()
				->maxLength(255)
				->label(__('form.deger').' - '.$dil->diladi);
		}

		return $form
			->schema(array_merge($schema, [
				Forms\Components\Select::make('tip')
					->label(__('form.tip'))
					->options([
						'yazi' => __('form.yazi'),
						'varyok' => __('form.varyok'),
						'coktansecmeli' => __('form.coktansecmeli'),
						'coklusecimli' => __('form.coklusecimli'),
					])
					->required()
					->reactive(),
				Forms\Components\Repeater::make('degerler_raw')
					->label(__('form.degerler'))
					->schema(array_merge(
						[
							Forms\Components\TextInput::make('anahtar')
								->required()
								->maxLength(255)
								->label(__('form.anahtar')),
						],
						$altdegerler
					))
					->helperText(__('form.anahtar_yardim'))
					->visible(fn (callable $get) => $get('tip') == 'coktansecmeli' || $get('tip') == 'coklusecimli')
					->columns(count($diller) + 1)
					->createItemButtonLabel(__('form.yeni_ekle'))
					->grid(1),
			]))
			->columns(1);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('nitelikadi')->label(__('form.nitelik')),
				Tables\Columns\IconColumn::make('secimli')->label(__('form.tip'))
					->boolean(),
				Tables\Columns\TextColumn::make('degerler')->label(__('form.degerler')),
				// Tables\Columns\TextColumn::make('created_at')
				//   ->dateTime(),
				// Tables\Columns\TextColumn::make('updated_at')
				//   ->dateTime(),
			])
			->filters([
				//
			])
			->actions([
				Tables\Actions\EditAction::make()
					->mutateRecordDataUsing(function (array $data): array {
						$data['nitelikadlari'] = LanguageLine::where('group', 'nitelik')
							->where('key', $data['id'])
							->first()
						  ?->text;
						if ($data['tip'] == 'coktansecmeli' || $data['tip'] == 'coklusecimli') {
							$data['degerler_raw'] = [];
							foreach ($data['degerler'] as $k) {
								$varmi = LanguageLine::where('group', 'nitelikdegeri')
									->where('key', $data['id'].'-deger-'.$k)
									->first();
								$anahtar = ['anahtar' => $k];
								if ($varmi) {
									$data['degerler_raw'][] = array_merge($anahtar, $varmi->text);
								} else {
									$data['degerler_raw'][] = $anahtar;
								}
							}
						}

						return $data;
					})
					->using(function (Model $record, array $data): Model {
						$data['nitelikadi'] = reset($data['nitelikadlari']);
						$data['degerler'] = array_map(function ($deger) {
							return $deger['anahtar'];
						}, $data['degerler_raw'] ?? []);
						$record->update($data);
						LanguageLine::where('group', 'nitelik')
							->where('key', $record->id)
							->update([
								'text' => $data['nitelikadlari'],
							]);
						if ($data['tip'] == 'coktansecmeli' || $data['tip'] == 'coklusecimli') {
							foreach ($data['degerler_raw'] as $deger) {
								$varmi = LanguageLine::where('group', 'nitelikdegeri')
									->where('key', $record->id.'-deger-'.$deger['anahtar'])
									->first();
								if ($varmi) {
									$varmi->update([
										'text' => array_filter($deger, fn ($item, $key) => $key != 'anahtar', ARRAY_FILTER_USE_BOTH),
									]);
								} else {
									LanguageLine::create([
										'group' => 'nitelikdegeri',
										'key' => $record->id.'-deger-'.$deger['anahtar'],
										'text' => array_filter($deger, fn ($item, $key) => $key != 'anahtar', ARRAY_FILTER_USE_BOTH),
									]);
								}
							}
						}

						return $record;
					}),
				Tables\Actions\DeleteAction::make(),
			])
			->bulkActions([
				// Tables\Actions\DeleteBulkAction::make(),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageNiteliklers::route('/'),
		];
	}
}
