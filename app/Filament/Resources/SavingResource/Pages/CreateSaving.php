<?php

namespace App\Filament\Resources\SavingResource\Pages;

use App\Filament\Resources\SavingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSaving extends CreateRecord
{
    protected static string $resource = SavingResource::class;

    protected function getRedirectUrl(): string
    {
        return SavingResource::getUrl('index');
    }
}
