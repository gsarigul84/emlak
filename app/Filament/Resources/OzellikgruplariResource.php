<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OzellikgruplariResource\Pages;
use App\Filament\Resources\OzellikgruplariResource\RelationManagers;
use App\Models\Diller;
use App\Models\Ozellikgruplari;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\TranslationLoader\LanguageLine;

class OzellikgruplariResource extends Resource
{
  protected static ?string $model = Ozellikgruplari::class;

  protected static ?string $navigationIcon = 'heroicon-o-folder';
  protected static ?int $navigationSort = 93;
  protected static function getNavigationGroup(): string
  {
    return __('menu.ayarlar');
  }
  protected static function getNavigationLabel(): string
  {
    return __('menu.ozellikgruplari');
  }
  public static function form(Form $form): Form
  {
    $schema = [];
    $diller = Diller::all();
    foreach ($diller as $dil) {
      $schema[] = Forms\Components\TextInput::make('grupadlari.' . $dil->dilkodu)
        ->label(__('grupadi') . ' - ' . $dil->diladi)
        ->required()
        ->maxLength(255);
    }
    return $form
      ->schema($schema);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('grupadi'),
        // Tables\Columns\TextColumn::make('created_at')
        //     ->dateTime(),
        // Tables\Columns\TextColumn::make('updated_at')
        //     ->dateTime(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make()->mutateRecordDataUsing(function (array $data): array {
          $data['grupadlari'] = LanguageLine::where('group', 'ozellikgruplari')
            ->where('key', $data['id'])
            ->first()
            ?->text;
          return $data;
        })
          ->using(function (Model $record, array $data): Model {
            $data['grupadi'] = reset($data['grupadlari']);
            $record->update($data);
            LanguageLine::where('group', 'ozellikgruplari')
              ->where('key', $record->id)
              ->update([
                'text' => $data['grupadlari']
              ]);
            return $record;
          }),
        Tables\Actions\DeleteAction::make()->after(function (Model $record) {
          LanguageLine::where('group', 'ozellikgruplari')
            ->where('key', $record->id)
            ->delete();
        }),
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ManageOzellikgruplaris::route('/'),
    ];
  }
}
