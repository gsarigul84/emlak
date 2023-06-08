<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahallelerResource\Pages;
use App\Filament\Resources\MahallelerResource\RelationManagers;
use App\Models\Diller;
use App\Models\Ilceler;
use App\Models\Iller;
use App\Models\Mahalleler;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\TranslationLoader\LanguageLine;

class MahallelerResource extends Resource
{
  protected static ?string $model = Mahalleler::class;

  protected static ?string $navigationIcon = 'heroicon-o-location-marker';
  protected static ?int $navigationSort = 94;
  protected static function getNavigationGroup(): string
  {
    return __('menu.ayarlar');
  }
  protected static function getNavigationLabel(): string
  {
    return __('menu.mahalleler');
  }
  public static function form(Form $form): Form
  {
    $schema = [];
    $diller = Diller::all();
    foreach ($diller as $dil) {
      $schema[] = Forms\Components\TextInput::make('mahalleadlari.' . $dil->dilkodu)
        ->required()
        ->label(__('mahalleadi') . ' - ' . $dil->diladi)
        ->maxLength(255);
    }

    return $form
      ->schema(array_merge([
        Forms\Components\Select::make('il_id')
          ->options(function () {
            $iller = Iller::all();
            $options = [];
            foreach ($iller as $i) {
              $options[$i->id] = __('iller.' . $i->id);
            }
            return $options;
          })
          ->afterStateUpdated(fn (callable $set) => $set('ilce_id', null))
          ->reactive()
          ->required(),

        Forms\Components\Select::make('ilce_id')
          ->options(function (callable $get) {
            if ($get('il_id')) {
              return Ilceler::where('il_id', $get('il_id'))->get()->map(fn ($ilce) => [
                'id' => $ilce->id,
                'ilceadi' => __('ilceler.'.$ilce->id)
              ])->pluck('ilceadi','id');
            }
            return [];
          })
          ->required(),
      ], $schema));
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('il.iladi'),
        Tables\Columns\TextColumn::make('ilce.ilceadi'),
        Tables\Columns\TextColumn::make('mahalleadi'),
        // Tables\Columns\TextColumn::make('created_at')
        //   ->dateTime(),
        // Tables\Columns\TextColumn::make('updated_at')
        //   ->dateTime(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make()->mutateRecordDataUsing(function (array $data): array {
          $data['mahalleadlari'] = LanguageLine::where('group', 'mahalleler')
            ->where('key', $data['id'])
            ->first()
            ?->text;
          return $data;
      })
      ->using(function (Model $record, array $data): Model {
        $data['mahalleadi'] = reset($data['mahalleadlari']);
        $record->update($data);
        LanguageLine::where('group', 'mahalleler')
          ->where('key', $record->id)
          ->update([
            'text' => $data['mahalleadlari']
          ]);
        return $record;
      }),
        Tables\Actions\DeleteAction::make()
        ->after(function (Model $record) {
          LanguageLine::where('group', 'mahalleler')
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
      'index' => Pages\ManageMahallelers::route('/'),
    ];
  }
}
