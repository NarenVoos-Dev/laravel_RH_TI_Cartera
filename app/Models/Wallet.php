<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
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

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_wallet');
    }
    // Relación con el empleado
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

     // Relación con la empresa del empelado
     public function company()
     {
         return $this->belongsTo(Company::class);
     }

    // Relación con los movimientos de cartera
    public function movements()
    {
        return $this->hasMany(WalletMovement::class);
    }

    public function scopeVisible(\Illuminate\Database\Eloquent\Builder $query)
    {
        $user = auth()->user();
    
        // Empleado → ve solo sus carteras
        if ($user->hasRole('empleado') && $user->employee) {
            return $query->where('employee_id', $user->employee->id);
        }
    
        // Cartera → ver solo carteras originadas por su empresa (en tabla pivote)
        if ($user->hasRole('cartera') && $user->company_id) {
            return $query->whereHas('companies', function ($q) use ($user) {
                $q->where('companies.id', $user->company_id);
            });
        }
    
        // Admin → ve todo
        if ($user->hasRole('administrador')) {
            return $query;
        }
    
        // Otros → nada
        return $query->whereRaw('0 = 1');
    }
}
