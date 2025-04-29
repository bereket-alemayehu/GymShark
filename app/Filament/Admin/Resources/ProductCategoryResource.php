<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductCategoryResource\Pages;
use App\Filament\Admin\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Product Management System';
    protected static ?int $navigationSort = 1;
    protected static ?string $label = 'Product Category';
    protected static ?string $pluralLabel = 'Product Categories';
    protected static ?string $slug = 'product-categories';
    protected static ?string $navigationLabel = 'Product Categories';
    public static function getNavigationBadge(): ?string
    {
        return ProductCategory::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Section One')
                    ->collapsed()
                    ->columns(2) // Two columns layout for the section

                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label(' Category Name')
                            ->maxLength(255)
                            ->placeholder('e.g. Dress Glove'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'men' => 'Men',
                                'women' => 'Women',
                                'kids' => 'Kids',
                                'accessories' => 'Accessories'
                            ])
                            ->label('Category Type')
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label('Header Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('quickly add a title on to the image'),

                        Forms\Components\RichEditor::make('description')
                            ->label('Description')
                            ->nullable()
                            ->columnSpanFull()
                            ->placeholder('description that will be displayed on the page'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Promotional Image')
                            ->nullable()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('product-category'),
                        Forms\Components\FileUpload::make('banner')
                            ->label('Background Image')
                            ->nullable()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('product-category'),
                    ]),

                Forms\Components\Section::make('Section Two')
                    ->collapsed()
                    ->columns(2) // Two columns layout for the section
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Headline')
                            ->placeholder('Add  headline')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('meta_description')
                            ->label(' Description')
                            ->nullable()
                            ->columnSpanFull()
                            ->placeholder('Add headline  description'),

                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('title')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
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
                    ->slideOver()
                    ->action(function (array $data) {
                        $record = ProductCategory::find($data['record']);
                        if ($record) {
                            $record->delete();
                            Notification::make()
                                ->title('Product Category Deleted')
                                ->success()
                                ->send();
                        }
                    }),
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
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }
}
