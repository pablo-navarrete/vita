<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;
    protected $table = 'pais';

    protected $fillable = [
        
        'nombre'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'id_pais');
    }
}
