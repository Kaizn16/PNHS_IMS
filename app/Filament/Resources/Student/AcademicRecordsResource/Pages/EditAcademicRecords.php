<?php

namespace App\Filament\Resources\Student\AcademicRecordsResource\Pages;

use App\Filament\Resources\Student\AcademicRecordsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicRecords extends EditRecord
{
    protected static string $resource = AcademicRecordsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
