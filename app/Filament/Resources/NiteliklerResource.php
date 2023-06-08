<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NiteliklerResource\Pages;
use App\Filament\Resources\NiteliklerResource\RelationManagers;
use App\Models\Nitelikler;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
    return $form
      ->schema([
        Forms\Components\TextInput::make('nitelikadi')
          ->tel()
          ->required()
          ->maxLength(255),
        Forms\Components\Toggle::make('secimli')
          ->required()
          ->reactive(),
        Forms\Components\Repeater::make('degerler')
          ->schema([
            Forms\Components\TextInput::make('deger')->required(),
          ])
          ->visible(fn (callable $get) => $get('secimli'))
          ->grid(3),
      ])->columns(1);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('nitelikadi'),
        Tables\Columns\IconColumn::make('secimli')
          ->boolean(),
        Tables\Columns\TextColumn::make('degerler'),
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
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ManageNiteliklers::route('/'),
    ];
  }
}
