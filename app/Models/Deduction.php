<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percentage',
        'is_mandatory',
        'is_editable',
    ];

}


