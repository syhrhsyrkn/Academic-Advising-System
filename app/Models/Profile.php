<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'contact_number',
        'kulliyyah',
        'department',
        'specialisation',
        'matric_no',
        'year',
        'semester',
        'staff_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
