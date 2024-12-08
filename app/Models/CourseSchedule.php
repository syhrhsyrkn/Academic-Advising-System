<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['matric_no', 'course_code', 'semester_id'];

    public function student()
    {
        return $this->belongsTo(User::class, 'matric_no', 'matric_no');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
