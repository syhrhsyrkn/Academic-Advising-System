<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric_no',
        'semester',
        'year',
        'total_credit_hour',
        'course_codes',  // This will be a JSON column storing course codes
    ];

    protected $casts = [
        'course_codes' => 'array',  // Cast course_codes as an array to handle multiple courses
    ];

    /**
     * Get the courses associated with this schedule.
     * Since course_codes is stored as an array, we will fetch the courses based on these codes.
     */
    public function courses()
    {
        return $this->hasManyThrough(Course::class, 'course_code', 'course_code', 'course_code');
    }

    /**
     * Calculate the total credit hours for the schedule by summing up the credit hours of the associated courses.
     */
    public function calculateTotalCreditHours()
    {
        // Sum the credit hours of the courses in the schedule
        $totalCreditHours = Course::whereIn('course_code', $this->course_codes)->sum('credit_hour');
        
        return $totalCreditHours;
    }

    /**
     * Add courses to the schedule while ensuring the total credit hours are within the specified range.
     */
    public function addCoursesToSchedule(array $courses)
    {
        // Make sure the total credit hours are within the 12-20 range
        $totalCreditHours = Course::whereIn('course_code', $courses)->sum('credit_hour');

        if ($totalCreditHours < 12 || $totalCreditHours > 20) {
            throw new \Exception('Total credit hours must be between 12 and 20 for the semester.');
        }

        // Assign courses to the schedule and update the total credit hour
        $this->course_codes = $courses;
        $this->total_credit_hour = $totalCreditHours;
        $this->save();
    }

    /**
     * Get the profile of the student associated with this schedule.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'matric_no', 'matric_no');
    }
}
