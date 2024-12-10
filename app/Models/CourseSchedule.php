<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric_no', 
        'course_code', 
        'academic_year',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'matric_no', 'matric_no');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }
}
