<?php

namespace App\Filament\Admin\Resources\ContactusResource\Pages;

use App\Filament\Admin\Resources\ContactusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactuses extends ListRecords
{
    protected static string $resource = ContactusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
