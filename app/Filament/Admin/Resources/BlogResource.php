<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BlogResource\Pages;
use App\Models\Blog;
use App\Models\BlogCategory;
use DateTime;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationGroup = 'Post Management System';
    protected static ?string $navigationParentItem = 'Blog Categories';
    protected static ?int $navigationSort = 2;
    public static function getNavigationBadge(): ?string
    {
        return Blog::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('blog_category_id')
                    ->label('Category')
                    ->options(BlogCategory::all()->pluck('name', 'id')),
                DateTimePicker::make('published_at')
                    ->label('Published At')
                    ->default(now())
                    ->minDate(now())
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $date = new DateTime($state);
                        $set('published_at', $date->format('Y-m-d H:i:s'));
                    }),
                TextInput::make('title')
                    ->required()
                    ->label('Title')
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('thumbnail')
                    ->disk('public')
                    ->imageEditor()
                    ->directory('thumbnails')
                    ->image()
                    ->columnSpanFull(),
                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('row_number')
                    ->label('ID')
                    ->getStateUsing(fn($rowLoop, $record) => $rowLoop->iteration),
                ImageColumn::make('thumbnail')
                    ->label('Image')
                    ->circular(),

                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('blogCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Published At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Blog Deleted Successfully')
                    ),

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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
