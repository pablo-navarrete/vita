<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    use HasFactory;

    // Definir las columnas que pueden ser asignadas masivamente
    protected $fillable = [
        'nombre',
        'titular',
        'direccion',
        'telefono',
        'email',
        'status',
        'tenant_id',
        'estado_pago',
        'mes_gratis',
        'servicio'
    ];

    /**
     * Relación: cada clínica pertenece a un tenant.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
