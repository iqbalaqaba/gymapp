<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'license_type',
        'payment_proof',
        'approved',
    ];
}
