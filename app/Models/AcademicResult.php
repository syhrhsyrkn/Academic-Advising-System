<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


class AcademicResult extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = ['student_id', 'course_code', 'semester_id']; // Composite key


    protected $fillable = [
        'student_id',
        'course_code',
        'grade',
        'point',
        'semester_id',
    ];

    protected $casts = [
        'point' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function studentCourseSchedule()
    {
        return $this->belongsTo(StudentCourseSchedule::class, 'course_code', 'course_code')
                    ->where('student_course_schedule.student_id', $this->student_id)
                    ->where('student_course_schedule.semester_id', $this->semester_id);
    }

    public static function getGradePoint($grade)
    {
        $gradePoints = [
            'A' => 4.00,
            'A-' => 3.67,
            'B+' => 3.33,
            'B' => 3.00,
            'B-' => 2.67,
            'C+' => 2.33,
            'C' => 2.00,
            'D' => 1.67,
            'D-' => 1.33,
            'E' => 1.00,
            'F' => 0.00,
        ];

        return $gradePoints[$grade] ?? 0;
    }

    public static function setGradeAndPoint($grade)
    {
        $point = self::getGradePoint($grade);

        return [
            'grade' => $grade,
            'point' => $point
        ];
    }
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('student_id', $this->getAttribute('student_id'))
                     ->where('course_code', $this->getAttribute('course_code'))
                     ->where('semester_id', $this->getAttribute('semester_id'));
    }
}
