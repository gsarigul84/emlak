<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OzelliklerResource\Pages;
use App\Filament\Resources\OzelliklerResource\RelationManagers;
use App\Models\Ozellikgruplari;
use App\Models\Ozellikler;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\TranslationLoader\LanguageLine;

class OzelliklerResource extends Resource
{
  protected static ?string $model = Ozellikler::class;

  protected static ?string $navigationIcon = 'heroicon-o-check-circle';
  protected static ?int $navigationSort = 92;
  protected static function getNavigationGroup(): string
  {
    return __('menu.ayarlar');
  }
  protected static function getNavigationLabel(): string
  {
    return __('menu.ozellikler');
  }
  public static function form(Form $form): Form
  {
    $schema = [];
    $diller = \App\Models\Diller::all();
    foreach ($diller as $dil) {
      $schema[] = Forms\Components\TextInput::make('ozellikadlari.' . $dil->dilkodu)
        ->required()
        ->maxLength(255)
        ->label(__('form.ozellikadi') . ' - ' . $dil->diladi);
    }

    return $form
      ->schema(array_merge([
        Forms\Components\Select::make('grup_id')
          ->options(function () {
            return Ozellikgruplari::all()
              ->map(fn ($item) => ['id' => $item->id, 'grupadi' => __('ozellikgruplari.' . $item->id)])
              ->pluck('grupadi', 'id');
          })
          ->label(__('form.grup'))
          ->required(),
      ], $schema))->columns(1);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('grup_id')->label(__('form.grup'))
          ->formatStateUsing(function (string $state, Model $record) {
            return __('ozellikgruplari.' . $record->grup_id);
          }),
        Tables\Columns\TextColumn::make('ozellikadi')->label(__('form.ozellikadi'))
          ->formatStateUsing(function (string $state, Model $record) {
            return __('ozellik.' . $record->id);
          }),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make()
        ->mutateRecordDataUsing(function (array $data): array {
          $data['ozellikadlari'] = LanguageLine::where('group', 'ozellik')
            ->where('key', $data['id'])
            ->first()
            ?->text;
          return $data;
        })
          ->using(function (Model $record, array $data): Model {
            $data['ozellikadi'] = reset($data['ozellikadlari']);
            $record->update($data);
            LanguageLine::where('group', 'ozellik')
              ->where('key', $record->id)
              ->update([
                'text' => $data['ozellikadlari']
              ]);
            return $record;
          }),
        Tables\Actions\DeleteAction::make()->after(function (Model $record) {
          LanguageLine::where('group', 'ozellik')
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
      'index' => Pages\ManageOzelliklers::route('/'),
    ];
  }
}
