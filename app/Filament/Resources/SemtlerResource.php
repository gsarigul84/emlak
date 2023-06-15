<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemtlerResource\Pages;
use App\Models\Diller;
use App\Models\Ilceler;
use App\Models\Iller;
use App\Models\Semtler;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class SemtlerResource extends Resource
{
	protected static ?string $model = Semtler::class;

	protected static ?string $navigationIcon = 'heroicon-o-map';

	protected static ?int $navigationSort = 96;

	protected static function getNavigationGroup(): string
	{
		return __('menu.ayarlar');
	}

	protected static function getNavigationLabel(): string
	{
		return __('menu.semtler');
	}

	public static function form(Form $form): Form
	{
		$schema = [];
		$diller = Diller::all();
		foreach ($diller as $dil) {
			$schema[] = Forms\Components\TextInput::make('semtadlari.'.$dil->dilkodu)
				->required()
				->label(__('form.semtadi').' - '.$dil->diladi)
				->maxLength(255);
		}

		return $form
			->schema(
				[
					Forms\Components\Select::make('il_id')
						->options(function () {
							$iller = Iller::all();
							$options = [];
							foreach ($iller as $i) {
								$options[$i->id] = __('iller.'.$i->id);
							}

							return $options;
						})
						->afterStateUpdated(fn (callable $set) => $set('ilce_id', null))
						->reactive()
						->label(__('form.il'))
						->required(),

					Forms\Components\Select::make('ilce_id')
						->options(function (callable $get) {
							if ($get('il_id')) {
								return Ilceler::where('il_id', $get('il_id'))->get()->map(fn ($ilce) => [
									'id' => $ilce->id,
									'ilceadi' => __('ilceler.'.$ilce->id),
								])->pluck('ilceadi', 'id');
							}

							return [];
						})
						->label(__('form.ilce'))
						->required(),
					...$schema,
				]
			);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('il.iladi')
					->label(__('form.il')),
				Tables\Columns\TextColumn::make('ilce.ilceadi')
					->label(__('form.ilce')),
				Tables\Columns\TextColumn::make('semtadi')
					->label(__('form.semtadi')),
			])
			->filters([
				//
			])
			->actions([
				Tables\Actions\EditAction::make()
					->mutateRecordDataUsing(function (array $data): array {
						$data['semtadlari'] = LanguageLine::where('group', 'semtler')
							->where('key', $data['id'])
							->first()
						  ?->text;

						return $data;
					})
					->using(function (Model $record, array $data): Model {
						$data['semtadi'] = reset($data['semtadlari']);
						$record->update($data);
						LanguageLine::where('group', 'semtler')
							->where('key', $record->id)
							->update([
								'text' => $data['semtadlari'],
							]);

						return $record;
					}),
				Tables\Actions\DeleteAction::make()
					->after(function (Model $record) {
						LanguageLine::where('group', 'semtler')
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
			'index' => Pages\ManageSemtlers::route('/'),
		];
	}
}
