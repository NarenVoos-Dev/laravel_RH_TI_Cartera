<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relación con usuarios (un rol puede tener muchos usuarios)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
