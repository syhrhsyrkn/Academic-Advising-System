<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric_no',
        'course_code',
        'grade',
        'gpa',
        'cgpa',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }

    public function student()
    {
        return $this->belongsTo(Profile::class, 'matric_no', 'matric_no');
    }
}
