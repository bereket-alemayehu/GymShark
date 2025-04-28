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
    protected static ?string $navigationParentItem = 'Product Categories';

    public static function getNavigationBadge(): ?string
    {
        return ProductVariant::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->required()
                    ->relationship('product', 'name')
                    ->label('Product'),

                // Multi-select for colors (using Color Picker or predefined options)
                Forms\Components\Select::make('color')
                    ->label('Colors')
                    ->multiple()  // Allow multiple selections
                    ->options([
                        'red' => 'Red',
                        'tomato' => 'Tomato',
                        'orange' => 'Orange',
                        'yellow' => 'Yellow',
                        'green' => 'Green',
                        'white' => 'White',
                        'blue' => 'Blue',
                        'purple' => 'Purple',
                        'pink' => 'Pink',
                        'brown' => 'Brown',
                        'black' => 'Black',
                        'gray' => 'Gray',
                        'cyan' => 'Cyan',
                        'magenta' => 'Magenta',
                        'violet' => 'Violet',
                        'indigo' => 'Indigo',
                        'gold' => 'Gold',
                        'silver' => 'Silver',
                        'beige' => 'Beige',
                        'lavender' => 'Lavender',
                        'peach' => 'Peach',
                        'coral' => 'Coral',
                        'salmon' => 'Salmon',
                        'turquoise' => 'Turquoise',
                        'teal' => 'Teal',
                        'navy' => 'Navy',
                        'maroon' => 'Maroon',
                        'olive' => 'Olive',
                        'khaki' => 'Khaki',
                        'orange red' => 'Orange Red',
                        'light blue' => 'Light Blue',
                        'light green' => 'Light Green',
                        'light pink' => 'Light Pink',
                        'light yellow' => 'Light Yellow',
                        'light gray' => 'Light Gray',
                        'dark red' => 'Dark Red',
                        'dark green' => 'Dark Green',
                        'dark blue' => 'Dark Blue',
                        'dark purple' => 'Dark Purple',
                        'dark pink' => 'Dark Pink',
                        'dark brown' => 'Dark Brown',
                        'dark gray' => 'Dark Gray',
                        'dark orange' => 'Dark Orange',
                        'dark yellow' => 'Dark Yellow',
                        'dark cyan' => 'Dark Cyan',
                        'dark magenta' => 'Dark Magenta',
                        'dark violet' => 'Dark Violet',
                        'dark olive green' => 'Dark Olive Green',
                        'dark salmon' => 'Dark Salmon',
                        'dark slate blue' => 'Dark Slate Blue',
                        'dark slate gray' => 'Dark Slate Gray',
                        'dark turquoise' => 'Dark Turquoise',
                        'dark violet' => 'Dark Violet',
                        'dark khaki' => 'Dark Khaki',
                        'dark orchid' => 'Dark Orchid',
                        'dark sea green' => 'Dark Sea Green',
                        'dark slate gray' => 'Dark Slate Gray',
                        'dark golden rod' => 'Dark Golden Rod',
                        'dark sea green' => 'Dark Sea Green',
                        'dark slate blue' => 'Dark Slate Blue',
                        'dark slate gray' => 'Dark Slate Gray',
                        'dark golden rod' => 'Dark Golden Rod',
                        'dark olive green' => 'Dark Olive Green',
                        'dark orange' => 'Dark Orange',
                        'dark orchid' => 'Dark Orchid',
                        'dark red' => 'Dark Red',
                        'dark salmon' => 'Dark Salmon',
                        'dark sea green' => 'Dark Sea Green',
                        'dark slate blue' => 'Dark Slate Blue',
                        'dark slate gray' => 'Dark Slate Gray',
                        'dark turquoise' => 'Dark Turquoise',
                        'dark violet' => 'Dark Violet',
                        'dark khaki' => 'Dark Khaki',
                    ])
                    ->default([]), // Default to an empty array

                // Multi-select for sizes
                Forms\Components\Select::make('size')
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
                Tables\Columns\TextColumn::make('color')
                    ->label('Colors')
                    ->getStateUsing(function ($record) {
                        // Ensure colors is an array, then convert it to a comma-separated string
                        return is_array($record->color) ? implode(', ', $record->color) : $record->color;
                    })
                    ->searchable(),

                // Display the sizes as a comma-separated string
                Tables\Columns\TextColumn::make('size')
                    ->label('Sizes')
                    ->getStateUsing(function ($record) {
                        // Ensure sizes is an array, then convert it to a comma-separated string
                        return is_array($record->size) ? implode(', ', $record->size) : $record->size;
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
                    ->sortable()
                    ->label('Price')
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
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\DeleteAction::make()
                    ->slideOver(),
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
