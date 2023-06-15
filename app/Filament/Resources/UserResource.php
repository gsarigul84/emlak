<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
	protected static ?string $model = User::class;

	protected static ?string $navigationIcon = 'heroicon-o-collection';

	protected static function getNavigationLabel(): string
	{
		return __('menu.kullanicilar');
	}

	public static function canViewAny(): bool
	{
		return auth()->user()->is_admin;
	}

	public static function getModelLabel(): string
	{
		return __('menu.kullanicilar');
	}

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\TextInput::make('name')
					->label(__('form.ad'))
					->required()
					->maxLength(255)
					->columnSpan(2),
				Forms\Components\TextInput::make('email')
					->label(__('form.eposta'))
					->email()
					->required()
					->maxLength(255)
					->columnSpan(2),
				Forms\Components\TextInput::make('password')
					->label(__('form.sifre'))
					->password()
					->maxLength(255)
					->columnSpan(2),
				Forms\Components\Toggle::make('is_admin')
					->label(__('form.admin')),
				Forms\Components\Toggle::make('active')
					->label(__('form.aktif')),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('name')
					->label(__('form.ad')),
				Tables\Columns\TextColumn::make('email')
					->label(__('form.eposta')),
				Tables\Columns\IconColumn::make('is_admin')
					->label(__('form.admin'))
					->boolean(),
				Tables\Columns\IconColumn::make('active')
					->label(__('form.aktif'))
					->boolean(),
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
					->using(function (Model $record, array $data): Model {
						if (trim($data['password']) == '') {
							unset($data['password']);
						}
						$record->update($data);

						return $record;
					}),
				Tables\Actions\DeleteAction::make(),
			])
			->bulkActions([
				// Tables\Actions\DeleteBulkAction::make(),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageUsers::route('/'),
		];
	}
}
