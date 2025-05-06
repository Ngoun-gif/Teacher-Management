<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    protected  $table = 'courses';
    protected $fillable = ['course_name', 'syllabus', 'duration', 'course_price' ];
    use HasFactory;
}
