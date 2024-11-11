<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';

    protected $fillable = [
        'rut',
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'email',
        'direccion',
        'id_pais'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_paciente');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_paciente');
    }

    public function historialClinico()
    {
        return $this->hasOne(HistorialClinico::class, 'id_paciente');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_paciente');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }
    
}
