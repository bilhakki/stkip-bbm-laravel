<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_datetime',
        'end_datetime',
        'attendance_code',
        'topic',
        'classroom_id',
        'season_id',
        'lecturer_id',
        'room_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class, 'classroom_session_id');
    }
}
