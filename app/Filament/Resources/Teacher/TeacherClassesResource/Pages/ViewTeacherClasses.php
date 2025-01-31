<?php

namespace App\Filament\Resources\Teacher\TeacherClassesResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Teacher\TeacherClassesResource;

class ViewTeacherClasses extends ViewRecord
{
    protected static string $resource = TeacherClassesResource::class;

    protected function getHeaderActions(): array
    {
        $userDesignation = Auth::user()->teacher->designation;
        
        if ($userDesignation === 'Adviser') {
            return [
                Actions\EditAction::make(),
            ];
        }

        return [];
    }

}
