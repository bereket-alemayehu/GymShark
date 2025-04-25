<?php

namespace App\Filament\Admin\Resources\ContactusResource\Pages;

use App\Filament\Admin\Resources\ContactusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactus extends EditRecord
{
    protected static string $resource = ContactusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
