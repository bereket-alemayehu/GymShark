<?php

namespace App\Filament\Admin\Resources\ProductImagesResource\Pages;

use App\Filament\Admin\Resources\ProductImagesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductImages extends EditRecord
{
    protected static string $resource = ProductImagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
