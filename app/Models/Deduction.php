<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_detail_id',
        'concept',
        'amount',
    ];
    // Relación con el detalle de nómina
    public function payrollDetail()
    {
        return $this->belongsTo(PayrollDetail::class);
    }
}
