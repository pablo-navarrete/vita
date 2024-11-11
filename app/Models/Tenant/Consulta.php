<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'id_cita',
        'id_paciente',
        'id_user',
        'id_preconsulta',
        'motivo_consulta',
        'observaciones',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function diagnostico()
    {
        return $this->hasOne(Diagnostico::class, 'id_consulta');
    }
}
