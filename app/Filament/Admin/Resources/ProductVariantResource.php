<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductVariantResource\Pages;
use App\Filament\Admin\Resources\ProductVariantResource\RelationManagers;
use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 5;
    protected static ?string $label = 'Product Variant';
    protected static ?string $pluralLabel = 'Product Variants';
    protected static ?string $slug = 'product-variants';
    protected static ?string $navigationLabel = 'Product Variants';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->required()
                    ->relationship('product', 'name')
                    ->label('Product'),

                // Multi-select for colors (using Color Picker or predefined options)
                Forms\Components\Select::make('colors')
                    ->label('Colors')
                    ->multiple()  // Allow multiple selections
                    ->options([
                        '#FF0000' => 'Red',
                        '#FF6347' => 'Tomato',
                        '#FF4500' => 'Orange Red',
                        '#FFA500' => 'Orange',
                        '#FFD700' => 'Gold',
                        '#FFFF00' => 'Yellow',
                        '#9ACD32' => 'Yellow Green',
                        '#008000' => 'Green',
                        '#006400' => 'Dark Green',
                        '#00FF00' => 'Lime',
                        '#32CD32' => 'Lime Green',
                        '#98FB98' => 'Pale Green',
                        '#8B4513' => 'Saddle Brown',
                        '#A52A2A' => 'Brown',
                        '#D2691E' => 'Chocolate',
                        '#8B0000' => 'Dark Red',
                        '#800000' => 'Maroon',
                        '#C71585' => 'Medium Violet Red',
                        '#FF1493' => 'Deep Pink',
                        '#FF69B4' => 'Hot Pink',
                        '#FFC0CB' => 'Pink',
                        '#FFB6C1' => 'Light Pink',
                        '#DC143C' => 'Crimson',
                        '#FF00FF' => 'Magenta',
                        '#8A2BE2' => 'Blue Violet',
                        '#9400D3' => 'Dark Violet',
                        '#8B008B' => 'Dark Magenta',
                        '#4B0082' => 'Indigo',
                        '#0000FF' => 'Blue',
                        '#00008B' => 'Dark Blue',
                        '#1E90FF' => 'Dodger Blue',
                        '#87CEFA' => 'Light Sky Blue',
                        '#00BFFF' => 'Deep Sky Blue',
                        '#4682B4' => 'Steel Blue',
                        '#5F9EA0' => 'Cadet Blue',
                        '#6495ED' => 'Cornflower Blue',
                        '#4169E1' => 'Royal Blue',
                        '#000080' => 'Navy',
                        '#191970' => 'Midnight Blue',
                        '#ADD8E6' => 'Light Blue',
                        '#B0C4DE' => 'Light Steel Blue',
                        '#7B68EE' => 'Medium Slate Blue',
                        '#6A5ACD' => 'Slate Blue',
                        '#483D8B' => 'Dark Slate Blue',
                        '#FFF0F5' => 'Lavender Blush',
                        '#E6E6FA' => 'Lavender',
                        '#D8BFD8' => 'Thistle',
                        '#DDA0DD' => 'Plum',
                        '#EE82EE' => 'Violet',
                        '#DA70D6' => 'Orchid',
                        '#BA55D3' => 'Medium Orchid',
                        '#800080' => 'Purple',
                        '#4B0082' => 'Indigo',
                        '#9370DB' => 'Medium Purple',
                        '#A9A9A9' => 'Dark Gray',
                        '#808080' => 'Gray',
                        '#C0C0C0' => 'Silver',
                        '#F5F5F5' => 'White Smoke',
                        '#DCDCDC' => 'Gainsboro',
                        '#F0F8FF' => 'Alice Blue',
                        '#F5FFFA' => 'Mint Cream',
                        '#FFE4E1' => 'Misty Rose',
                        '#FFF5EE' => 'Sea Shell',
                        '#F0FFF0' => 'Honeydew',
                        '#E0FFFF' => 'Light Cyan',
                        '#AFEEEE' => 'Pale Turquoise',
                        '#40E0D0' => 'Turquoise',
                        '#00CED1' => 'Dark Turquoise',
                        '#48D1CC' => 'Medium Turquoise',
                        '#20B2AA' => 'Light Sea Green',
                        '#008B8B' => 'Dark Cyan',
                        '#008080' => 'Teal',
                        '#B0E0E6' => 'Powder Blue',
                        '#ADD8E6' => 'Light Blue',
                        '#F0E68C' => 'Khaki',
                        '#BDB76B' => 'Dark Khaki',
                        '#808000' => 'Olive',
                        '#556B2F' => 'Dark Olive Green',
                        '#6B8E23' => 'Olive Drab',
                        '#808000' => 'Olive',
                        '#A9A9A9' => 'Dark Gray',
                        '#A52A2A' => 'Brown',
                        '#8B4513' => 'Saddle Brown',
                        '#F4A460' => 'Sandy Brown',
                        '#D2B48C' => 'Tan',
                        '#BC8F8F' => 'Rosy Brown',
                        '#F5DEB3' => 'Wheat',
                        '#FFE4B5' => 'Moccasin',
                        '#FFDEAD' => 'Navajo White',
                        '#FAEBD7' => 'Antique White',
                        '#D3D3D3' => 'Light Gray',
                        '#B0E0E6' => 'Powder Blue',
                        '#D8BFD8' => 'Thistle',
                        '#E6E6FA' => 'Lavender',
                        '#F5F5F5' => 'White Smoke',
                        '#F0F8FF' => 'Alice Blue',
                        '#F5FFFA' => 'Mint Cream',
                        '#FFE4E1' => 'Misty Rose',
                        '#FFF5EE' => 'Sea Shell',
                        '#F0FFF0' => 'Honeydew',
                        '#AFEEEE' => 'Pale Turquoise',
                        '#40E0D0' => 'Turquoise',
                        '#00CED1' => 'Dark Turquoise',
                        '#48D1CC' => 'Medium Turquoise',
                        '#20B2AA' => 'Light Sea Green',
                        '#008B8B' => 'Dark Cyan',
                        '#008080' => 'Teal',
                        '#B0E0E6' => 'Powder Blue',
                        '#ADD8E6' => 'Light Blue',
                        '#F0E68C' => 'Khaki',
                        '#BDB76B' => 'Dark Khaki',
                        '#808000' => 'Olive',
                    ])
                    ->default([]), // Default to an empty array

                // Multi-select for sizes
                Forms\Components\Select::make('sizes')
                    ->label('Sizes')
                    ->multiple()  // Allow multiple selections
                    ->options([
                        'XS' => 'XS',
                        'S' => 'S',
                        'M' => 'M',
                        'L' => 'L',
                        'XL' => 'XL',
                        'XXL' => 'XXL',
                    ])
                    ->default([]), // Default to an empty array

                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('stock_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                // Display the colors as a comma-separated string
                Tables\Columns\TextColumn::make('colors')
                    ->label('Colors')
                    ->getStateUsing(function ($record) {
                        // Ensure colors is an array, then convert it to a comma-separated string
                        return is_array($record->colors) ? implode(', ', $record->colors) : $record->colors;
                    })
                    ->searchable(),

                // Display the sizes as a comma-separated string
                Tables\Columns\TextColumn::make('sizes')
                    ->label('Sizes')
                    ->getStateUsing(function ($record) {
                        // Ensure sizes is an array, then convert it to a comma-separated string
                        return is_array($record->sizes) ? implode(', ', $record->sizes) : $record->sizes;
                    })
                    ->searchable(),

                // Other columns, for example SKU and price
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.price')
                    ->money()
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}
