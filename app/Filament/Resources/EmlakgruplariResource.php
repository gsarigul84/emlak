<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmlakgruplariResource\Pages;
use App\Filament\Resources\EmlakgruplariResource\RelationManagers;
use App\Models\Emlakgruplari;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\TranslationLoader\LanguageLine;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;


class EmlakgruplariResource extends Resource
{
  protected static ?string $model = Emlakgruplari::class;

  protected static ?string $navigationIcon = 'heroicon-o-collection';
  protected static ?int $navigationSort = 98;
  protected static function getNavigationGroup(): string
  {
    return __('menu.ayarlar');
  }
  protected static function getNavigationLabel(): string
  {
    return __('menu.emlakgruplari');
  }
  public static function form(Form $form): Form
  {
    $schema = [];
    $diller = \App\Models\Diller::all();
    foreach ($diller as $dil) {
      $schema[] = Forms\Components\TextInput::make('emlakgruplari.' . $dil->dilkodu)
        ->required()
        ->maxLength(255)
        ->label(__('grupadi') . ' - ' . $dil->diladi);
    }

    return $form
      ->schema(array_merge(
        $schema,
        [
          CheckboxList::make('ozellikgruplari')
            ->options(
              fn () => \App\Models\Ozellikgruplari::all()
                ->map(fn ($item) => ['id' => $item->id, 'grupadi' => __('ozellikgruplari.' . $item->id)])
                ->pluck('grupadi', 'id')
            )
        ]
      ));
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('grupadi')
          ->formatStateUsing(function (string $state, Model $record) {
            return __('emlakgrubu.'.$record->id);
          }),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make()
          ->mutateRecordDataUsing(function (array $data): array {
            $data['emlakgruplari'] = LanguageLine::where('group', 'emlakgrubu')
              ->where('key', $data['id'])
              ->first()
              ?->text;
            return $data;
          })
          ->using(function (Model $record, array $data): Model {
            $data['grupadi'] = reset($data['emlakgruplari']);
            $record->update($data);
            LanguageLine::where('group', 'emlakgrubu')
              ->where('key', $record->id)
              ->update([
                'text' => $data['emlakgruplari']
              ]);
            return $record;
          }),
        Tables\Actions\DeleteAction::make()->after(function (Model $record) {
          LanguageLine::where('group', 'emlakgrubu')
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
      'index' => Pages\ManageEmlakgruplaris::route('/'),
    ];
  }
}
