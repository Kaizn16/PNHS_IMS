<?php

namespace App\Filament\Resources\Student\AcademicRecordsResource\Pages;

use App\Filament\Resources\Student\AcademicRecordsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicRecords extends ListRecords
{
    protected static string $resource = AcademicRecordsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
