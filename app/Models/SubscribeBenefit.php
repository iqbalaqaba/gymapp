<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribeBenefit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'subscribe_package_id'
    ];

    // //relasi database
    // public function SubscribeBenefits(): HasMany
    // {
    //     return $this->hasMany(SubscribeBenefit::class);
    // }
    public function subscribePackage(): BelongsTo
    {
        return $this->belongsTo(SubscribePackage::class);
    }
}
