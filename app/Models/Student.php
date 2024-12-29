<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamps

    protected $table = 'students';

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'user_id', 
        'student_id',
        'full_name', 
        'contact_no', 
        'matric_no', 
        'kulliyyah', 
        'department', 
        'specialisation',
        'year', 
        'semester',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courseSchedules()
    {
        return $this->hasMany(StudentCourseSchedule::class, 'student_id');
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'student_id', 'student_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course_schedule', 'student_id', 'course_code')
                    ->withPivot('semester_id'); 
    }
    
    public function academicResults()
    {
        return $this->hasMany(AcademicResult::class, 'student_id');
    }
}
