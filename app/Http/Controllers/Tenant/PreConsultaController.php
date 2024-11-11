<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;

use App\Models\Tenant\HistorialClinico;
use App\Models\Tenant\Logo;
use App\Models\Tenant\Paciente;
use App\Models\Tenant\Pais;
use App\Models\Tenant\PreConsulta;
use Illuminate\Http\Request;

class PreConsultaController extends Controller
{
   public function create(Request $request, $id){
    $logo = Logo::where('status',1)->first();
    $paises = Pais::all();
    $paciente = Paciente::find($id);
    $historialClinico = HistorialClinico::where('id_paciente',$id)->get();
   
    return view('tenant.preconsulta.create', compact('logo','paises','paciente','historialClinico'));
   }

   public function store(Request $request)
   {
   
       // Validar los datos
       $validatedData = $request->validate([
           'paciente_id' => 'required|integer|exists:pacientes,id', // Asegúrate de que el paciente existe
           'cita_id' => 'required|integer|exists:pacientes,id',
           'motivo_consulta' => 'required|string|max:255',
           'sintomas' => 'required|string|max:500',
           'observaciones' => 'required|string|max:500',
       ]);

       // Crear el historial clínico
       PreConsulta::create($request->all());

       // Retornar una respuesta, puedes personalizar esto según tu necesidad
       return response()->json([ 'success' => true,'message' => 'Pre-consulta guardada exitosamente.']);
   }
}
