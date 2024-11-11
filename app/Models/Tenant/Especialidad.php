<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;
    protected $table = 'especialidads';

    protected $fillable = [
       
        'nombre',
        'descripcion'
    ];
}
