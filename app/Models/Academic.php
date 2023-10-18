<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'academicable_type',
        'academicable_id',
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }
    
    public function academicable()
    {
        return $this->morphTo();
    }

}
