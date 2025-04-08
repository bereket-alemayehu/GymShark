<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductSubCategoryResource\Pages;
use App\Filament\Admin\Resources\ProductSubCategoryResource\RelationManagers;
use App\Models\ProductSubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductSubCategoryResource extends Resource
{
    protected static ?string $model = ProductSubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Product Sub Category';
    protected static ?string $pluralLabel = 'Product Sub Categories';
    protected static ?string $slug = 'product-sub-categories';
    protected static ?string $navigationLabel = 'Product Sub Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_category_id')
                    ->required()
                    ->options(\App\Models\ProductCategory::all()->pluck('name', 'id'))
                    ->label('Product Category')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $category = \App\Models\ProductCategory::find($state);
                        if ($category) {
                            $set('slug', str($category->name)->slug());
                        }
                    }),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('slug')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\MarkdownEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
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
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->label('Edit'),
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->url(fn(ProductSubCategory $record): string => route('admin.product-sub-categories.show', $record->id))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListProductSubCategories::route('/'),
            'create' => Pages\CreateProductSubCategory::route('/create'),
            'edit' => Pages\EditProductSubCategory::route('/{record}/edit'),
        ];
    }
}
