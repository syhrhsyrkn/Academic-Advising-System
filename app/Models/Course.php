<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'course_code'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'course_code',
        'name',
        'credit_hour',
        'classification',
        'prerequisite',
        'description',
    ];

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'prerequisites', 'course_code', 'prerequisite_code');
    }

    public function courseSchedules()
    {
        return $this->hasMany(CourseSchedule::class, 'course_code', 'course_code');
    }
}
