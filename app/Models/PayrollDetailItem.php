<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PayrollDetailItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_detail_id',
        'concept_id',
        'type',
        'description',
        'amount',
    ];

    public function payrollDetail()
    {
        return $this->belongsTo(PayrollDetail::class, 'payroll_detail_id');
    }

    

    public function concept()
    {
        return $this->morphTo(); // si usas morph para earnings/deductions
    }
}
