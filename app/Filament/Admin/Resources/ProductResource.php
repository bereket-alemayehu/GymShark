<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use PhpParser\Node\Stmt\Label;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Product';
    protected static ?string $pluralLabel = 'Products';
    protected static ?string $slug = 'products';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationParentItem = 'Product Categories';

    public static function getNavigationBadge(): ?string
    {
        return Product::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Section One')
                    ->collapsed()
                    ->columns(2) // Two columns layout for the section
                    ->schema([
                        Select::make('product_category_id')
                            ->label('Category')
                            ->relationship('productCategory', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->placeholder('e.g. Primus Trail Knit   Mens')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->prefix('$'),
                        Forms\Components\TextInput::make('discount_price')
                            ->numeric()
                            ->default(0.0000)
                            ->prefix('$'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_new')
                            ->default(false),
                        Forms\Components\Toggle::make('is_popular')
                            ->default(false),
                        Forms\Components\RichEditor::make('description')
                            ->label(' Description')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('features')
                            ->label('Delivery & Returns')
                            ->columnSpanFull(),
                    ]),

                Section::make('Section Two')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->nullable()
                            ->label('Header Title for the Second Section')
                            ->placeholder('e.g. HandCrafted Leather Shoes , ...'),
                        Forms\Components\RichEditor::make('information')
                            ->label('Product Info'),
                        Forms\Components\RichEditor::make('size_fit')
                            ->label('Size & Fit'),
                        Forms\Components\RichEditor::make('delivery_info')
                            ->label('Delivery Info'),
                        Repeater::make('materials')
                            ->label('Materials')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->label('Material Title'),
                                Textarea::make('description')
                                    ->label('Material Description')
                                    ->rows(3),
                            ])
                            ->addActionLabel('Add Material')
                            ->reorderable() // Optional: allows drag/drop reordering
                            ->collapsible() // Optional: collapses each item
                            ->grid(2), // Optional: put title and description side-by-side
                        // ->columnSpanFull(),//  unneccessary because grid(2) override this one.

                        Forms\Components\RichEditor::make('care')
                            ->label('Care Guide'),
                        Forms\Components\TextInput::make('made_in')
                            ->maxLength(255)
                            ->label('Made In')
                            ->placeholder('Enter the country of origin')
                            ->default('Made in Ethiopia'),



                    ]),

                Section::make('Section Three')
                    ->collapsed()
                    // ->columns(2)
                    ->schema([
                        // Forms\Components\FileUpload::make('detail_image')
                        //     ->label('Detail Image')
                        //     ->image()
                        //     ->disk('public')
                        //     ->directory('products/detail_image')
                        //     ->preserveFilenames(),
                        // // ->enableOpen()
                        // // ->enableDownload(),
                        Forms\Components\FileUpload::make('thumbnail_image')
                            ->label('Banner Image')
                            ->image()
                            ->disk('public')
                            ->directory('products/thumbnail_image')
                            ->preserveFilenames()
                            ->enableOpen()
                            ->enableDownload()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('inner_title')
                            ->maxLength(255)
                            ->label('Inner Title')
                            ->columnSpanFull()
                            ->placeholder('e.g. Give your feet He Chance To Feel ..'),
                        Forms\Components\RichEditor::make('inner_description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Section Four')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('inner_subtitle')
                                    ->maxLength(255)
                                    ->label('header title')
                                    ->columnSpanFull()
                                    ->placeholder('e.g. Addis OutSole ..'),
                                Forms\Components\RichEditor::make('inner_subdescription')
                                    ->columnSpanFull()
                                    ->label('Description')
                                    ->placeholder('eg. The Addis Outsole is ...'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('inner_base')
                                    ->label(' Base Name')
                                    ->placeholder('e.g. SoleBase')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('inner_basevalue')
                                    ->label(' Base Value')
                                    ->placeholder('e.g. 4mm')
                                    ->maxLength(255),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('inner_depth')
                                    ->maxLength(255)
                                    ->label('Depth Name')
                                    ->placeholder('e.g. Tread Depth'),
                                Forms\Components\TextInput::make('inner_depthvalue')
                                    ->label('Depth Value')
                                    ->placeholder('e.g. 0mm')
                                    ->maxLength(255),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->Label('Image Title')
                                    ->placeholder('e.g. EMBRACE YOUR HUMAN NATURE')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('meta_description')
                                    ->maxLength(255)
                                    ->label('Image Description')
                                    ->columnSpanFull()
                                    ->helperText('e.g The Best piece of Technology ever to '),
                                Forms\Components\FileUpload::make('inner_image')
                                    ->label('Inner Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products/inner_image')
                                    ->preserveFilenames()
                                    ->enableOpen()
                                    ->enableDownload(),




                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_new')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_popular')
                    ->boolean(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
