<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TuitionPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'payment_date',
        'amount',
        'receipt_number',
        'status',
        'season_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
