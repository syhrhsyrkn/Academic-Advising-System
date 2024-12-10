<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric_no',
        'advising_reason',
        'status',
        'appointment_date',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'matric_no', 'matric_no');
    }
}
