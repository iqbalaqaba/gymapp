<?php

namespace App\Models;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gym extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'name',
        'slug',
        'address',
        'about',
        'is_popular',
        'open_time_at',
        'closed_time_at',
        'city_id'
    ];

    protected $casts = [
        'open_time_at' => 'datetime:H:i',
        'closed_time_at' => 'datetime:H:i',
    ];

    //function untuk generate URL halaman secara otomatis menggunakan name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    //Relasi database
    //Check gym-nya ada di kota apa pakai relations BelongsTo ke id kota yang fieldnya ID city
    public function cities(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function gymTestimonials(): HasMany
    {
        return $this->hasMany(gymTestimonial::class);
    }

    public function gymPhotos(): HasMany
    {
        return $this->hasMany(GymPhoto::class);
    }

    public function gymFacilities(): HasMany
    {
        return $this->hasMany(GymFacilities::class, 'gym_id');
    }
}
