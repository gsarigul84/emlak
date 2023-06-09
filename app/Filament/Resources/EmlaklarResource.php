<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmlaklarResource\Pages;
use App\Filament\Resources\EmlaklarResource\RelationManagers;
use App\Models\Emlakgruplari;
use App\Models\Emlaklar;
use App\Models\Emlaktipleri;
use App\Models\Ilceler;
use App\Models\Iller;
use App\Models\Mahalleler;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Humaidem\FilamentMapPicker\Fields\OSMMap;

class EmlaklarResource extends Resource
{
  protected static ?string $model = Emlaklar::class;

  protected static ?string $navigationIcon = 'heroicon-o-collection';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('grup_id')
          ->options(
            Emlakgruplari::all()
              ->map(fn ($emlakgruplari) => [
                'id' => $emlakgruplari->id,
                'grupadi' => __('emlakgrubu.' . $emlakgruplari->id),
              ])
              ->pluck('grupadi', 'id')
              ->toArray()
          )
          ->label(__('form.grup'))
          ->reactive()
          ->required(),
        Forms\Components\Select::make('tip_id')
          ->options(function (callable $get) {
            if ($get('grup_id')) {
              return Emlaktipleri::where('grup_id', $get('grup_id'))->get()->map(fn ($tip) => [
                'id' => $tip->id,
                'emlaktipi' => __('emlaktipleri.' . $tip->id)
              ])->pluck('emlaktipi', 'id');
            }
            return [];
          })
          ->required(),
        Forms\Components\Select::make('il_id')
          ->options(function () {
            $iller = Iller::all();
            $options = [];
            foreach ($iller as $i) {
              $options[$i->id] = __('iller.' . $i->id);
            }
            return $options;
          })

          ->label(__('form.il'))
          ->reactive()
          ->required(),
        Forms\Components\Select::make('ilce_id')
          ->options(function (callable $get) {
            if ($get('il_id')) {
              return Ilceler::where('il_id', $get('il_id'))->get()->map(fn ($ilce) => [
                'id' => $ilce->id,
                'ilceadi' => __('ilceler.' . $ilce->id)
              ])->pluck('ilceadi', 'id');
            }
            return [];
          })
          ->label(__('form.ilce'))
          ->reactive()
          ->required(),
        Forms\Components\Select::make('mahalle_id')
          ->options(function (callable $get) {
            if ($get('il_id')) {
              return Mahalleler::where('ilce_id', $get('ilce_id'))->get()->map(fn ($mahalle) => [
                'id' => $mahalle->id,
                'mahalleadi' => __('mahalleler.' . $mahalle->id)
              ])->pluck('mahalleadi', 'id');
            }
            return [];
          })
          ->label(__('form.ilce'))
          ->required(),
        Forms\Components\TextInput::make('ilan_no')
          ->required()
          ->maxLength(255),
        OSMMap::make('location')
          ->label('Location')
          ->showMarker()
          ->draggable()
          ->zoom(15)
          ->extraControl([
            'zoomDelta'           => 1,
            'zoomSnap'            => 0.25,
            'wheelPxPerZoomLevel' => 60
          ])
          ->afterStateHydrated(function ($state, callable $set) {
            $set('location', ['lat' => 36.854018, 'lng' => 30.799940]);
          })
          ->tilesUrl('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('grup_id'),
        Tables\Columns\TextColumn::make('tip_id'),
        Tables\Columns\TextColumn::make('ilan_no'),
        Tables\Columns\TextColumn::make('il_id'),
        Tables\Columns\TextColumn::make('ilce_id'),
        Tables\Columns\TextColumn::make('mahalle_id'),
        Tables\Columns\TextColumn::make('kordinatlar'),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime(),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
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
      'index' => Pages\ListEmlaklars::route('/'),
      'create' => Pages\CreateEmlaklar::route('/create'),
      'edit' => Pages\EditEmlaklar::route('/{record}/edit'),
    ];
  }
}
