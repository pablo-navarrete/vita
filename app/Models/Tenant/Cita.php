<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'id_paciente',
        'id_user',
        'fecha',
        'hora',
        'estado',
        'observaciones',
        'estado_pago'
        
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class, 'id_cita');
    }
}
