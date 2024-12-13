<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    protected $table = 'student_course_schedule';

    protected $fillable = [
        'student_id',   
        'course_code',  
        'semester_id',  
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code');  
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
