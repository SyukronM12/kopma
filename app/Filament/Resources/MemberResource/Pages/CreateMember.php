<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation($data);
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index setelah berhasil membuat anggota
        return MemberResource::getUrl('index');
    }
}
