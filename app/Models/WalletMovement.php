<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class WalletMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'description',
    ];

     // Relación con la cartera del empleado
     public function wallet()
     {
         return $this->belongsTo(Wallet::class);
     }
}
