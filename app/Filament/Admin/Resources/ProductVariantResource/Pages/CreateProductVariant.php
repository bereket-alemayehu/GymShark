<?php

namespace App\Filament\Admin\Resources\ProductVariantResource\Pages;

use App\Filament\Admin\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductVariant extends CreateRecord
{
    protected static string $resource = ProductVariantResource::class;
}
