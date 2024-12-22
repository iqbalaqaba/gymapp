<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribeTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_trx_id',
        'name',
        'phone',
        'email',
        'proof',
        'total_ammount',
        'duration',
        'is_paid',
        'started_at',
        'ended_at',
        'subscribe_package_id'
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date'
    ];

    //relasi database
    public function subscribePackage(): BelongsTo
    {
        return $this->belongsTo(SubscribePackage::class, 'subscribe_package_id');
    }

    //metode untuk generate transaction ID baru
    public static function generatUniqueTrxId()
    {
        $prefix = 'TRANSAKSI'; //ditambahkan didepan

        do {
            $randomString = $prefix . mt_rand(1000, 9999); // generate angka random
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function getRouteKeyName()
    {
        return 'id'; // This matches the {subscribeTransaction:id} in your route
    }
}
