<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'semester_number', 'academic_year'];

    public function courseSchedules()
    {
        return $this->hasMany(CourseSchedule::class, 'semester_id');
    }
}