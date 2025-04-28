<?php

namespace App\Filament\Admin\Resources\OrderItemsResource\Pages;

use App\Filament\Admin\Resources\OrderItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderItems extends EditRecord
{
    protected static string $resource = OrderItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
