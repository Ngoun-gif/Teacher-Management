<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model{
    protected  $table = 'majors';
    protected $fillable = ['major_type', 'description', 'state'];
    use HasFactory;
}
