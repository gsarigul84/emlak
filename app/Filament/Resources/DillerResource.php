<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DillerResource\Pages;
use App\Filament\Resources\DillerResource\RelationManagers;
use App\Models\Diller;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DillerResource extends Resource
{
    protected static ?string $model = Diller::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?int $navigationSort = 99;
    protected static function getNavigationGroup(): string
    {
      return __('menu.ayarlar');
    }
    protected static function getNavigationLabel(): string
    {
      return __('menu.diller');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('diladi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dilkodu')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('diladi'),
                Tables\Columns\TextColumn::make('dilkodu'),
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
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDillers::route('/'),
        ];
    }    
}
