<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $table = 'medicos';

    protected $fillable = [
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'especialidad',
        'telefono',
        'email',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_medico');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_medico');
    }
}
