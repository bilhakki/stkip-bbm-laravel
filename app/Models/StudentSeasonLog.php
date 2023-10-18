<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentSeasonLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'season_id',
        'status',
        'description',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
