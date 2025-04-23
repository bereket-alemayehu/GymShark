<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WishlistResource\Pages;
use App\Filament\Admin\Resources\WishlistResource\RelationManagers;
use App\Models\Wishlist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WishlistResource extends Resource
{
    protected static ?string $model = Wishlist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('product.name')->label('Product'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListWishlists::route('/'),
            'create' => Pages\CreateWishlist::route('/create'),
            'edit' => Pages\EditWishlist::route('/{record}/edit'),
        ];
    }
}
