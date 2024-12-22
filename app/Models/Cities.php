<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cities extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo'
    ];

    //function untuk generate URL halaman secara otomatis menggunakan name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    //Relasi database
    //method gyms tugasnya mendapatkan beberpaa data gym dari kota tsb, jadi harus di import dulu relationsnya
    public function gyms(): HasMany
    {
        return $this->hasMany(Gym::class, 'city_id');
    }
}
