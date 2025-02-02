<?php

namespace App\Filament\Resources\Teacher\AcademicRecordResource\Pages;

use App\Filament\Resources\Teacher\AcademicRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicRecords extends ListRecords
{
    protected static string $resource = AcademicRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
