<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductImagesResource\Pages;
use App\Models\ProductImages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductImagesResource extends Resource
{
    protected static ?string $model = ProductImages::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 4;
    protected static ?string $label = 'Product Images';
    protected static ?string $pluralLabel = 'Product Images';
    protected static ?string $slug = 'product-images';
    protected static ?string $navigationLabel = 'Product Images';
    protected static ?string $navigationParentItem = 'Product Categories';

    public static function getNavigationBadge(): ?string
    {
        return ProductImages::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('product_variant_id')
                    ->label('Variant SKU')
                    ->relationship('productVariant', 'sku')
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->directory('products') // storage/app/public/uploads/products
                    ->required()
                    ->preserveFilenames()
                    ->enableOpen()
                    ->enableDownload()
                    ->enableReordering()

                    ->multiple()
                    ->maxFiles(8)
                    ->minFiles(1)
                    ->acceptedFileTypes(['image/*'])
                    ->maxSize(1024 * 10) // 10MB
                    ->columnSpanFull()
                    ->label('Product Image')
                    ->imageEditor(),

                Forms\Components\Toggle::make('is_main')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('productVariant.sku')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_main')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->circular()
                    ->label('Product Image'),

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
            'index' => Pages\ListProductImages::route('/'),
            'create' => Pages\CreateProductImages::route('/create'),
            'edit' => Pages\EditProductImages::route('/{record}/edit'),
        ];
    }
}
