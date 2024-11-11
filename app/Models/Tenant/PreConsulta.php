<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreConsulta extends Model
{
    use HasFactory;
    protected $table = 'pre_consultas';
    protected $fillable = [
        'paciente_id',
        'cita_id',
        'motivo_consulta',
        'sintomas',
        'observaciones',
    ];

    // Relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con el modelo Consulta
    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
