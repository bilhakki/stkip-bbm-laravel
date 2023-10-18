<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomEnrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'remarks',
        'status',
        'season_id',
        'classroom_id',
        'student_id',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
