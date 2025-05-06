<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected  $table = 'teachers';
    protected $fillable = [
        'teacher_code', 
        'teacher_name', 
        'teacher_dob', 
        'address', 
        'teacher_email', 
        'teacher_phone',
        'teacher_profile',
        'teacher_image',
        'gender_id'
        
];
    use HasFactory;
}
