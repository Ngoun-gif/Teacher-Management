<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected  $table = 'subjects';
    protected $fillable = ['subject_name', 'description' ];
    use HasFactory;
}
