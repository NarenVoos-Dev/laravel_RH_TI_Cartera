<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;


class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Esta relación está incluida en Spatie, no es necesario redefinirla
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }
}
