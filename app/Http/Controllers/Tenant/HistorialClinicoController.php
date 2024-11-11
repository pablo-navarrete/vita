<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;

use App\Models\Tenant\HistorialClinico;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'id_paciente' => 'required|integer|exists:pacientes,id', // Asegúrate de que el paciente existe
            'alergias' => 'required|string|max:255',
            'antecedentes_medicos' => 'required|string|max:255',
            'antecedentes_familiares' => 'required|string|max:255',
            'medicamentos_actuales' => 'required|string|max:255',
        ]);

        // Crear el historial clínico
        $historialClinico = HistorialClinico::updateOrCreate(
            ['id_paciente' => $validatedData['id_paciente']], // Criterio para buscar
            $validatedData // Datos a actualizar o crear
        );

        // Retornar una respuesta, puedes personalizar esto según tu necesidad
        return response()->json([ 'success' => true,'message' => 'Historial clínico guardado exitosamente.']);
    }

    public function getHistorial($id)
    {
        // Obtener el historial clínico del paciente
        $historialClinico = HistorialClinico::where('id_paciente', $id)->first();

        // Retornar los datos en formato JSON
        return response()->json($historialClinico);
    }
}
