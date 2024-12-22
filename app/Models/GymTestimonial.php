<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GymTestimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'occupation',
        'name',
        'photo',
        'message',
        'gym_id'
    ];

    //relasi database
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }
}
