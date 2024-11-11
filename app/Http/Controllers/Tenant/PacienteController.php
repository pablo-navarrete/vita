<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Tenant\HistorialClinico;
use App\Models\Tenant\Logo;
use App\Models\Tenant\Paciente;
use App\Models\Tenant\Pais;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class PacienteController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();
        
       
        return view('tenant.paciente.index', compact('logo'));
    }

    public function getPacientes()
    {
        $pacientes = Paciente::with('pais')
        ->orderBy('created_at', 'DESC')
        ->get();
    
        return DataTables::of($pacientes)
            ->make(true);
    }

    public function create(){
        $logo = Logo::where('status',1)->first();
        $paises = Pais::all();
       
        return view('tenant.paciente.create', compact('logo','paises'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_pat' => 'required|string|max:255',
            'apellido_mat' => 'required|string|max:255',
            'rut' => 'required',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required', // Asegúrate de que estos valores sean los que usas
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:pacientes,email', // Asegúrate de que la tabla sea la correcta
            'direccion' => 'required|string|max:255',
            'id_pais' => 'required|exists:pais,id', // Asegúrate de que esta columna exista
        ]);
    
        try {
            // Valida y guarda el paciente
            $paciente = Paciente::create($request->all());
    
            // Devuelve un mensaje de éxito
            return response()->json(['success' => true, 'message' => 'Paciente creado exitosamente.']);

        } catch (\Exception $e) {
            // Devuelve un mensaje de error
            return response()->json(['success' => false, 'message' => 'Error al crear el paciente: ' . $e->getMessage()]);
        }
    }
    public function show($id)
    {
        $logo = Logo::where('status', 1)->first();
        $paciente = Paciente::with(['pais'])->findOrFail($id);
    
        // Crear la variable de mensaje si el historial clínico es null o no tiene registros
        $historialClinico = HistorialClinico::where('id_paciente',$id)->get();

      
        return view('tenant.paciente.show', compact('paciente', 'logo', 'historialClinico'));
    }

    public function edit($id){
        $logo = Logo::where('status',1)->first();
        $paises = Pais::all();
        $paciente = Paciente::with(['pais'])->findOrFail($id);
        return view('tenant.paciente.edit',compact('paciente','logo','paises'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_pat' => 'required|string|max:255',
            'apellido_mat' => 'required|string|max:255',
            'rut' => 'required',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required', // Asegúrate de que estos valores sean los que usas
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:pacientes,email,' . $id, // Asegúrate de que la tabla sea la correcta
            'direccion' => 'required|string|max:255',
            'id_pais' => 'required|exists:pais,id', // Asegúrate de que esta columna exista
        ]);
    
        try {
            // Valida y guarda el paciente
            $paciente = Paciente::findOrFail($id);

            // Actualiza los datos del paciente
            $paciente->update($request->all());
        
            // Devuelve un mensaje de éxito
            return response()->json(['success' => true, 'message' => 'Paciente actualizado exitosamente.']);

        } catch (\Exception $e) {
            // Devuelve un mensaje de error
            return response()->json(['success' => false, 'message' => 'Error al actualizar el paciente: ' . $e->getMessage()]);
        }
    }
    
}
