<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IllerResource\Pages;
use App\Filament\Resources\IllerResource\RelationManagers;
use App\Models\Iller;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use JetBrains\PhpStorm\Language;
use Spatie\TranslationLoader\LanguageLine;

class IllerResource extends Resource
{
  protected static ?string $model = Iller::class;

  protected static ?string $navigationIcon = 'heroicon-o-map';
  protected static ?int $navigationSort = 96;
  protected static function getNavigationGroup(): string
  {
    return __('menu.ayarlar');
  }
  protected static function getNavigationLabel(): string
  {
    return __('menu.iller');
  }
  public static function form(Form $form): Form
  {
    $schema = [];
    $diller = \App\Models\Diller::all();
    foreach ($diller as $dil) {
      $schema[] = Forms\Components\TextInput::make('iladlari.' . $dil->dilkodu)
        ->required()
        ->maxLength(255)
        ->label(__('iladi') . ' - ' . $dil->diladi);
    }
    return $form
      ->schema($schema);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('iladi')
        ->formatStateUsing(fn (string $state, Model $record) => __('iller.'.$record->id) ),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make()
        ->mutateRecordDataUsing(function (array $data): array {
          
              $data['iladlari'] = LanguageLine::where('group', 'iller')
                ->where('key', $data['id'])
                ->first()
                ?->text;
              return $data;
          })
          ->using(function (Model $record, array $data): Model {
            $data['iladi'] = reset($data['iladlari']);
            $record->update($data);
            LanguageLine::where('group', 'iller')
              ->where('key', $record->id)
              ->update([
                'text' => $data['iladlari']
              ]);
            return $record;
          }),
        Tables\Actions\DeleteAction::make()
          ->after(function (Model $record) {
            LanguageLine::where('group', 'iller')
              ->where('key', $record->id)
              ->delete();
          })
      ])
      ->bulkActions([
        // Tables\Actions\DeleteBulkAction::make(),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ManageIllers::route('/'),
    ];
  }
}
