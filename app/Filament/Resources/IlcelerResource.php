<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IlcelerResource\Pages;
use App\Filament\Resources\IlcelerResource\RelationManagers;
use App\Models\Diller;
use App\Models\Ilceler;
use App\Models\Iller;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\TranslationLoader\LanguageLine;

class IlcelerResource extends Resource
{
    protected static ?string $model = Ilceler::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?int $navigationSort = 95;
    protected static function getNavigationGroup(): string
    {
      return __('menu.ayarlar');
    }
    protected static function getNavigationLabel(): string
    {
      return __('menu.ilceler');
    }
    public static function form(Form $form): Form
    {
        $schema = [];
        $diller = Diller::all();
        foreach($diller as $dil){
          $schema[] = Forms\Components\TextInput::make('ilceadlari.'.$dil->dilkodu)
          ->required()
          ->label(__('form.ilceadi').' - '.$dil->diladi)
          ->maxLength(255);
        }
        
        
        return $form
            ->schema(array_merge([
              Forms\Components\Select::make('il_id')
              ->label(__('form.il'))
              ->options(function(): array{
                $options = [];
                $iller = Iller::all();
                foreach($iller as $il){
                  $options[$il->id] = __('iller.'.$il->id);
                }
                return $options;
              })
              ->required(),
            ],
            $schema))->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('il.iladi')->label(__('form.il')),
                Tables\Columns\TextColumn::make('ilceadi')->label(__('form.ilceadi'))
                  ->formatStateUsing(fn (string $state, Model $record) =>  __('ilceler.'.$record->id)),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                  ->mutateRecordDataUsing(function (array $data): array {
                    $data['ilceadlari'] = LanguageLine::where('group', 'ilceler')
                      ->where('key', $data['id'])
                      ->first()
                      ?->text;
                    return $data;
                })
                ->using(function (Model $record, array $data): Model {
                  $data['ilceadi'] = reset($data['ilceadlari']);
                  $record->update($data);
                  LanguageLine::where('group', 'ilceler')
                    ->where('key', $record->id)
                    ->update([
                      'text' => $data['ilceadlari']
                    ]);
                  return $record;
                }),
                Tables\Actions\DeleteAction::make()->after(function (Model $record) {
                  LanguageLine::where('group', 'ilceler')
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
            'index' => Pages\ManageIlcelers::route('/'),
        ];
    }    
}
