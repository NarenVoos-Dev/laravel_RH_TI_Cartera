<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Earning extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'default_value',
        'is_editable',
        'is_taxable',
    ];

}
