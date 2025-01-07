<?php

namespace App\Filament\Resources\AnggotaResource\Pages;

use App\Filament\Resources\AnggotaResource;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;

class CreateAnggota extends CreateRecord
{
    protected static string $resource = AnggotaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation($data);
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah berhasil membuat anggota
        return AnggotaResource::getUrl('index');
    }
}
