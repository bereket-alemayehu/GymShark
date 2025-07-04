<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Wishlist;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\WishlistResource\Pages;
use App\Filament\Admin\Resources\WishlistResource\Pages\ViewWishlist;

class WishlistResource extends Resource
{
    protected static ?string $model = Wishlist::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Wishlists';
    protected static ?string $label = 'Wishlist';
    protected static ?string $pluralLabel = 'Wishlists';
    protected static ?string $slug = 'wishlists';
    protected static ?string $recordTitleAttribute = 'user_id';

    public static function getNavigationBadge(): ?string
    {
        return Wishlist::count();
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['user_id', 'product_id'];
    }
    public static function getEagerLoadRelations(): array
    {
        return ['user', 'product'];
    }
    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->user->name . ' - ' . $record->product->name;
    }

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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->url(fn(Wishlist $record): string => route('filament.admin.resources.wishlists.view', $record)),
                    Tables\Actions\Action::make('Edit')
                        ->url(fn(Wishlist $record): string => route('filament.admin.resources.wishlists.edit', $record)),

                    Tables\Actions\Action::make('Delete')
                        ->action(function (Wishlist $record) {
                            $record->delete();
                            return redirect()->route('filament.admin.resources.wishlists.index');
                        })
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                ]),
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
            'view' => ViewWishlist::route('/{record}'),
        ];
    }
}
