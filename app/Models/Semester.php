<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $fillable = [
        'semester_name',
        'academic_year_id',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function courseSchedules()
    {
        return $this->hasMany(CourseSchedule::class, 'semester_id');
    }
}