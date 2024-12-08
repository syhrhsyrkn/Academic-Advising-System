<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CourseSchedule;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseScheduleSeeder extends Seeder
{

    public function run()
    {
        $student = User::where('email', 'student@gmail.com')->first();
        
        if ($student && $student->profile) {
            $matricNo = $student->profile->matric_no;

            $courses = [
                'UNGS 1301',
                'BIIT 1301',
                'BICS 1301', 
                'BICS 1302',
            ];

            foreach ($courses as $courseCode) {
                $course = Course::where('course_code', $courseCode)->first();

                if ($course) {
                    CourseSchedule::create([
                        'matric_no' => $matricNo, 
                        'semester_number' => 1, 
                        'academic_year' => 'Year 1', 
                        'course_code' => $course->course_code,
                    ]);
                }
            }
        }
    }
}
