<?php

namespace App\Filament\Resources\Teacher\TeacherClassesResource\Pages;

use App\Filament\Resources\Teacher\TeacherClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTeacherClasses extends CreateRecord
{
    protected static string $resource = TeacherClassesResource::class;

    public function mount(): void
    {
        abort_unless(Auth::user()->teacher->designation === 'Adviser', 403);
    
        $this->data['room_id'] = $this->data['room_id'] ?? null;
        $this->data['subject_id'] = $this->data['subject_id'] ?? null;
        $this->data['students'] = $this->data['student_id'] ?? [];
    }
    
}
