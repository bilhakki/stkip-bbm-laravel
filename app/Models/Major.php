<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'faculty_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'major_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'major_id');
    }

    public function academics()
    {
        return $this->morphMany(Academic::class, 'academicable');
    }
}
