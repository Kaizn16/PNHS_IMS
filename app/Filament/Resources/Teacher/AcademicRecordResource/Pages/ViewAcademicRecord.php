<?php

namespace App\Filament\Resources\Teacher\AcademicRecordResource\Pages;

use App\Filament\Resources\Teacher\AcademicRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables;
use App\Models\AcademicRecord;

class ViewAcademicRecord extends ViewRecord
{
    protected static string $resource = AcademicRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
