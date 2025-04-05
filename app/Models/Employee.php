<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{

    use HasFactory;

    protected $fillable = [
        'name', 
        'user_id',
        'document_identification',
        'salary',
        'transport_aid',
        'hire_date',
        'status',
    ];
    

    // Relación con User (Un empleado es un usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(EmployeeCompany::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(EmployeeCompany::class)->whereNull('removed_at');
    }
}
