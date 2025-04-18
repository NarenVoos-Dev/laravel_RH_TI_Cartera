<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Wallet;

class WalletMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'payment_date',
        'description',
        'status',
    ];

    // Relación con la cartera
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
