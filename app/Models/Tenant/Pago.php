<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
 
    protected $table = 'pagos';

    
    protected $fillable = [
        'id_paciente',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'descripcion_servicio',
        'estado_pago',
    ];
    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
