<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'balance',
    ];
    // Relación con el empleado
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relación con los movimientos de cartera
    public function movements()
    {
        return $this->hasMany(WalletMovement::class);
    }
}
