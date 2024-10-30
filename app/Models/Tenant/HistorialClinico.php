<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    use HasFactory;

    protected $table = 'historial_clinicos';

    protected $fillable = [
        'id_paciente',
        'alergias',
        'antecedentes_medicos',
        'antecedentes_familiares',
        'medicamentos_actuales',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
