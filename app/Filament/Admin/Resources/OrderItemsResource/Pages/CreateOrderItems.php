<?php

namespace App\Filament\Admin\Resources\OrderItemsResource\Pages;

use App\Filament\Admin\Resources\OrderItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderItems extends CreateRecord
{
    protected static string $resource = OrderItemsResource::class;
}
