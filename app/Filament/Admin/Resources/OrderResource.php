<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'payment & Order Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $label = 'Order List';
    protected static ?string $pluralLabel = 'Order Lists';
    protected static ?string $title = 'Order';
    protected static ?string $slug = 'orders';
    public static function getNavigationBadge(): ?string
    {
        return Order::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name')
                    ->label('User'),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->label('Total Price'),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->default('pending')
                    ->label('Payment Status'),
                Forms\Components\TextInput::make('payment_reference')
                    ->required()
                    ->label('Payment Reference'),
                Forms\Components\TextInput::make('payment_method')
                    ->required()
                    ->label('Payment Method'),
                Forms\Components\TextInput::make('created_at')
                    ->label('Created At')
                    ->disabled()
                    ->default(now()),
                Forms\Components\TextInput::make('updated_at')
                    ->label('Updated At')
                    ->disabled()
                    ->default(now()),
            ])->columns([
                'sm' => 2,
            ])->columnSpan([
                'sm' => 2,
            ])->disableLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
