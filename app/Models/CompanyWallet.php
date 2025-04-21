<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyWallet extends Model
{
    use HasFactory;

    protected $table = 'company_wallet';

    protected $fillable = [
        'wallet_id',
        'company_id',
    ];

    // Relación con la cartera
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // Relación con la empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
