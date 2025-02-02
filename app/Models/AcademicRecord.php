<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicRecord extends Model
{
    use SoftDeletes;
    protected $table = 'academic_records';
    protected $primaryKey = 'academic_record_id';
    protected $fillable = [
        'student_id', 'class_id', 'final_grade', 'semester', 'school_year'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
