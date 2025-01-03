<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamps

    protected $table = 'staff';

    protected $primaryKey = 'staff_id';

    protected $fillable = [
        'user_id',
        'staff_id', 
        'full_name', 
        'contact_no', 
        'kulliyyah', 
        'department',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}