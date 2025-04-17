<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\WalletMovement;


class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'company_id',
        'issue_date',
        'concept',
        'total_amount',
        'balance',
    ];
    // Relación con el empleado
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

     // Relación con la empresa
     public function company()
     {
         return $this->belongsTo(Company::class);
     }

    // Relación con los movimientos de cartera
    public function movements()
    {
        return $this->hasMany(WalletMovement::class);
    }
}
