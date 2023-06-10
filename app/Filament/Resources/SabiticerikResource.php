<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SabiticerikResource\Pages;
use App\Filament\Resources\SabiticerikResource\RelationManagers;
use App\Models\Sabiticerik;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SabiticerikResource extends Resource
{
    protected static ?string $model = Sabiticerik::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSabiticeriks::route('/'),
            'create' => Pages\CreateSabiticerik::route('/create'),
            'edit' => Pages\EditSabiticerik::route('/{record}/edit'),
        ];
    }    
}
