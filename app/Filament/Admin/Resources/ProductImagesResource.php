<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductImagesResource\Pages;
use App\Filament\Admin\Resources\ProductImagesResource\RelationManagers;
use App\Models\ProductImages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductImagesResource extends Resource
{
    protected static ?string $model = ProductImages::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 6;
    protected static ?string $label = 'Product Images';
    protected static ?string $pluralLabel = 'Product Images';
    protected static ?string $slug = 'product-images';
    protected static ?string $navigationLabel = 'Product Images';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->required()
                    ->relationship('product', 'name'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'sku')
                    ->required(),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->required(),

                Forms\Components\Toggle::make('is_main')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_variant.sku')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_main')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_main')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('image_path'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProductImages::route('/'),
            'create' => Pages\CreateProductImages::route('/create'),
            'edit' => Pages\EditProductImages::route('/{record}/edit'),
        ];
    }
}
