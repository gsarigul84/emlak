<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmlaklarResource\Pages;
use App\Filament\Resources\EmlaklarResource\RelationManagers;
use App\Models\Diller;
use App\Models\Emlakgruplari;
use App\Models\Emlaklar;
use App\Models\Emlaktipleri;
use App\Models\Fiyatlandirma;
use App\Models\Ilceler;
use App\Models\Iller;
use App\Models\Mahalleler;
use App\Models\Nitelikler;
use App\Models\Ozellikgruplari;
use App\Models\Ozellikler;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Humaidem\FilamentMapPicker\Fields\OSMMap;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EmlaklarResource extends Resource
{
  protected static ?string $model = Emlaklar::class;

  protected static ?string $navigationIcon = 'heroicon-o-collection';


  public static function getEmlaktipiRow(): array
  {
    return [
      Grid::make()
        ->columns(3)
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
            ->label(__('form.emlaktipi'))
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
          Forms\Components\Select::make('ilantipi')
            ->options([
              'satilik' => __('form.satilik'),
              'kiralik' => __('form.kiralik'),
            ])
            ->label(__('form.ilantipi'))
            ->required()
        ])
    ];
  }
  public static function getLokasyonBilgileri(): array
  {
    return [
      Grid::make()
        ->columns(3)
        ->schema([
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
            ->label(__('form.mahalle'))
            ->required()
        ]),
      Grid::make()
        ->columns(1)
        ->schema([
          OSMMap::make('koordinatlar')
            ->label(__('form.konum'))
            ->showMarker()
            ->draggable()
            ->zoom(15)
            ->extraControl([
              'zoomDelta'           => 1,
              'zoomSnap'            => 0.25,
              'wheelPxPerZoomLevel' => 60
            ])
            ->afterStateHydrated(function ($state, callable $set) {
              $set('koordinatlar', ['lat' => 36.854018, 'lng' => 30.799940]);
            })
            // ->afterStateUpdated(function ($state, callable $set) {
            //   // dd($state);
            //   // $set('koordinatlar', ['lat' => $state->getLat(), 'lng' => $state->getLng()]);
            // })
            ->tilesUrl('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}')
        ])
    ];
  }

  public static function getFiyatlandirmaRow(): array
  {
    return [
      Grid::make()
        ->columns(3)
        ->schema([
          ...Fiyatlandirma::where('durum', true)->get()->map(function ($fiyatlandirma) {
            return Forms\Components\TextInput::make('fiyatlar.' . $fiyatlandirma->id)
              ->label(__('form.fiyat').' - ' . $fiyatlandirma->sembol)
              ->required();
          })->toArray(),
        ])
    ];
  }

  public static function getGorsellerRow(): array
  {
    return [
      Grid::make()
        ->columns(1)
        ->schema([
          SpatieMediaLibraryFileUpload::make('attachments')
            ->multiple()
            ->image()
            ->enableReordering(),
        ])
    ];
  }

  public static function getIcerikRow(): array
  {
    $schema = [];
    $diller = Diller::all();
    foreach ($diller as $dil) {
      $schema[] = Forms\Components\Tabs\Tab::make('tab_' . $dil->id)
        ->label($dil->diladi)
        ->schema([
          Forms\Components\TextInput::make('sef.' . $dil->dilkodu)
            ->label(__('form.sefurl'))
            ->required(),
          Forms\Components\TextInput::make('aciklama.' . $dil->dilkodu)
            ->label(__('form.aciklama'))
            ->required(),
          Forms\Components\TextInput::make('baslik.' . $dil->dilkodu)
            ->label(__('form.baslik'))
            ->required(),
          Forms\Components\RichEditor::make('icerik' . $dil->dilkodu)
            ->label(__('form.icerik'))
            ->required(),
        ]);
    }
    return [
      Grid::make('icerikler')
        ->columns(1)
        ->schema([
          Forms\Components\Tabs::make('icerikler')
            ->tabs($schema)
        ])

    ];
  }

  public static function getOzelliklerRow(): array
  {
    $schema = [];
    $ozellikgruplari = Ozellikgruplari::all();
    $ozellikler = Ozellikler::all()->groupBy('grup_id');
    $emlakgruplari = Emlakgruplari::all()->keyBy('id');
    foreach($ozellikgruplari as $og){
      $schema[] = Forms\Components\CheckboxList::make('ozellikler.' . $og->id)
      ->label(__('ozellikgruplari.' . $og->id))
      ->visible(function(callable $get) use($emlakgruplari, $og){
        return $get('grup_id') && in_array($og->id, $emlakgruplari[$get('grup_id')]->ozellikgruplari);
      })
      ->options($ozellikler[$og->id] ? collect($ozellikler[$og->id])->map(fn ($item) => [
        'anahtar' => $item,
        'deger' => __('ozellik.' . $item->id)
      ])->pluck('deger', 'anahtar') : []);
    }
    return [
      Forms\Components\Fieldset::make('nitelikler')
        ->label(__('form.nitelikler'))
        ->columns(3)
        ->schema($schema)
    ];
  }

  public static function getNiteliklerRow(): array
  {
    $schema = [];
    $nitelikler = Nitelikler::all();
    $emlakgruplari = Emlakgruplari::all()->keyBy('id');
    foreach($nitelikler as $nitelik){
      switch($nitelik->tip){
        case 'varyok':
          $schema[] = Forms\Components\Toggle::make('nitelikler.' . $nitelik->id)
            ->label(__('nitelik.' . $nitelik->id))
            ->inline()
            ->visible(function(callable $get) use($emlakgruplari, $nitelik){
              return $get('grup_id') && in_array($nitelik->id, $emlakgruplari[$get('grup_id')]->nitelikler);
            });
        break;
        case 'yazi':
          $schema[] = Forms\Components\TextInput::make('nitelikler.' . $nitelik->id)
            ->label(__('nitelik.' . $nitelik->id))
            ->inlineLabel()
            ->visible(function(callable $get) use($emlakgruplari, $nitelik){
              return $get('grup_id') && in_array($nitelik->id, $emlakgruplari[$get('grup_id')]->nitelikler);
            });
        break;
        case 'coktansecmeli':
          $schema[] = Forms\Components\Select::make('nitelikler.' . $nitelik->id)
            ->label(__('nitelik.' . $nitelik->id))
            ->inlineLabel()
            ->visible(function(callable $get) use($emlakgruplari, $nitelik){
              return $get('grup_id') && in_array($nitelik->id, $emlakgruplari[$get('grup_id')]->nitelikler);
            })
            ->options(collect($nitelik->degerler)->map(fn ($item) => [
              'anahtar' => $item,
              'deger' => __('nitelikdegeri.' . $nitelik->id . '-deger-' . $item)
            ])->pluck('deger', 'anahtar'));
        break;
        case 'coklusecmeli':
          $schema[] = Forms\Components\CheckboxList::make('nitelikler.' . $nitelik->id)
            ->label(__('nitelik.' . $nitelik->id))
            ->visible(function(callable $get) use($emlakgruplari, $nitelik){
              return $get('grup_id') && in_array($nitelik->id, $emlakgruplari[$get('grup_id')]->nitelikler);
            })
            ->options(collect($nitelik->degerler)->map(fn ($item) => [
              'anahtar' => $item,
              'deger' => __('nitelikdegeri.' . $nitelik->id . '-deger-' . $item)
            ])->pluck('deger', 'anahtar'));
        break;
        
      }
    }
    return [
      Forms\Components\Fieldset::make('nitelikler')
        ->label(__('form.nitelikler'))
        ->columns(3)
        ->schema($schema)
    ];
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema(
        [
          ...static::getEmlaktipiRow(),
          ...static::getLokasyonBilgileri(),
          ...static::getFiyatlandirmaRow(),
          ...static::getIcerikRow(),
          ...static::getNiteliklerRow(),
          ...static::getOzelliklerRow(),
          ...static::getGorsellerRow(),
        ],
      );
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
