<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run()
    {
        Course::create([
            'name' => 'Introduction to Programming',
            'course_code' => 'CS101', 
            'credit_hour' => 3,
            'prerequisite' => 'None',
            'description' => 'This course introduces programming concepts and basic problem-solving techniques.',
        ]);
        
        Course::create([
            'name' => 'Advanced Programming',
            'course_code' => 'CS201',
            'credit_hour' => 4,
            'prerequisite' => 'CS101',
            'description' => 'This course covers more advanced topics in programming, such as data structures and algorithms.',
        ]);
    }
}
