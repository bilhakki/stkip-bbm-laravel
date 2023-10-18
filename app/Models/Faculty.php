<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function majors()
    {
        return $this->hasMany(Major::class, 'faculty_id');
    }

    public function academics()
    {
        return $this->morphMany(Academic::class, 'academicable');
    }
}
