<?php

namespace App\Filament\Resources\Teacher\AcademicRecordResource\Pages;

use App\Filament\Resources\Teacher\AcademicRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicRecord extends EditRecord
{
    protected static string $resource = AcademicRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
