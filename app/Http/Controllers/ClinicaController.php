<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Logo;
use App\Models\Tenant; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ClinicaController extends Controller
{
    public function index()
    {
        $logo = Logo::where('status',1)->first();
        // Obtener la única fecha de pago con status en 1
        $paymentDate = DB::table('payment_dates')
           ->select('payment_date')
           ->where('status', 1)
           ->first(); // Obtener solo el primer registro
        return view('admin.clinicas.index',compact('paymentDate','logo'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'titular' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clinicas',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'status' => 'required|boolean',
            'servicio' => 'required',
            'mes_gratis' => 'required',
        ]);

        try {
            
            $databaseName = config('tenancy.database.prefix') . strtolower($validated['nombre']);

            // Crear el inquilino (tenant)
            $tenant = Tenant::create([
                'tenancy_db_name'=>$databaseName,
                'data' => json_encode($validated),
            ]);

            // Crear el dominio para el inquilino (tenant)
            $tenant->domains()->create([
                'domain' => "{$validated['nombre']}." . config('tenancy.hostname.default'),
                'tenant_id' => $tenant->id,
            ]);


            // Crear la clínica en la base de datos del landlord
            $clinica = Clinica::create(array_merge($validated, ['tenant_id' => $tenant->id]));

            // Retornar una respuesta JSON
            return response()->json([
                'message' => 'Clínica creada exitosamente',
                'clinica' => $clinica,
            ]);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al crear la clínica: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getData()
    {
        $clinicas = DB::table('clinicas')
            ->join('tenants', 'clinicas.tenant_id', '=', 'tenants.id')
            ->join('domains', 'tenants.id', '=', 'domains.tenant_id')
            ->select(
                'clinicas.id', 
                'clinicas.nombre', 
                'clinicas.titular', 
                'clinicas.direccion', 
                'clinicas.telefono', 
                'clinicas.email', 
                'clinicas.status', 
                'clinicas.estado_pago', 
                'clinicas.mes_gratis', 
                'clinicas.servicio', 
                'clinicas.updated_at', 
                'domains.domain'
            )->orderBy('clinicas.id', 'desc');
    
        return DataTables::of($clinicas)
            // Filtro por nombre
            ->filterColumn('nombre', function($query, $keyword) {
                $query->where('clinicas.nombre', 'like', "%{$keyword}%");
            })
            // Filtro por titular
            ->filterColumn('titular', function($query, $keyword) {
                $query->where('clinicas.titular', 'like', "%{$keyword}%");
            })
            // Filtro por email
            ->filterColumn('email', function($query, $keyword) {
                $query->where('clinicas.email', 'like', "%{$keyword}%");
            })
            // Filtro por telefono
            ->filterColumn('telefono', function($query, $keyword) {
                $query->where('clinicas.telefono', 'like', "%{$keyword}%");
            })
            // Filtro por direccion
            ->filterColumn('direccion', function($query, $keyword) {
                $query->where('clinicas.direccion', 'like', "%{$keyword}%");
            })
            // Filtro por domain
            ->filterColumn('domain', function($query, $keyword) {
                $query->where('domains.domain', 'like', "%{$keyword}%");
            })
            // Filtro por status
            ->filterColumn('status', function($query, $keyword) {
                $keyword = strtolower(trim($keyword));
                if ($keyword === 'activo') {
                    $query->where('clinicas.status', 1);
                } elseif ($keyword === 'inactivo') {
                    $query->where('clinicas.status', 0);
                }
            })
            // Filtro por estado de pago
            ->filterColumn('estado_pago', function($query, $keyword) {
                $keyword = strtolower(trim($keyword));
                if ($keyword === 'pagado') {
                    $query->where('clinicas.estado_pago', 1);
                } elseif ($keyword === 'pendiente') {
                    $query->where('clinicas.estado_pago', 0);
                }
            })
            // Filtro por estado de pago
            ->filterColumn('servicio', function($query, $keyword) {
                $keyword = strtolower(trim($keyword));
                if ($keyword === 'básico') {
                    $query->where('clinicas.servicio', 1);
                } elseif ($keyword === 'estandar') {
                    $query->where('clinicas.servicio', 2);
                } elseif ($keyword === 'premium') {
                    $query->where('clinicas.servicio', 3);
                }
            })
            // Filtro por mes gratis
            ->filterColumn('mes_gratis', function($query, $keyword) {
                $keyword = strtolower(trim($keyword));
                if ($keyword === 'sí') {
                    $query->where('clinicas.mes_gratis', 1);
                } elseif ($keyword === 'no') {
                    $query->where('clinicas.mes_gratis', 0);
                }
            })
            ->make(true);
    }
    
    public function edit($id)
    {
        $clinica = Clinica::find($id);
        return response()->json($clinica);
    }

    public function update(Request $request, Clinica $clinica)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'titular' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clinicas,email,' . $clinica->id, // Ignorar el email actual
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'status' => 'required|boolean',
            'servicio' => 'required',
            'mes_gratis' => 'required',
        ]);

        try {
            // Buscar el tenant correspondiente a la clínica
            $tenant = Tenant::findOrFail($clinica->tenant_id);

            // Si el nombre cambia, actualizar el tenant y el dominio
            if ($validated['nombre'] !== $clinica->nombre) {
                // Cambiar el nombre de la base de datos del tenant
                $databaseName = config('tenancy.database.prefix') . strtolower($validated['nombre']);
                $tenant->tenancy_db_name = $databaseName;
                $tenant->save();

                // Actualizar el dominio del tenant
                $domain = $tenant->domains()->first();
                if ($domain) {
                    $domain->domain = "{$validated['nombre']}." . config('tenancy.hostname.default');
                    $domain->save();
                }
            }

            // Actualizar los datos de la clínica en la base de datos del landlord
            $clinica->update($validated);

            // Retornar una respuesta JSON
            return response()->json([
                'message' => 'Clínica actualizada exitosamente',
                'clinica' => $clinica,
            ]);

        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al actualizar la clínica: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            // Encontrar la clínica
            $clinica = Clinica::findOrFail($id);
        
            // Encontrar el tenant relacionado
            $tenant = Tenant::findOrFail($clinica->tenant_id);
    
          
            // Eliminar el dominio relacionado
            $tenant->domains()->delete();
        
            // Eliminar el tenant
            $tenant->delete();
        
            // Finalmente, eliminar la clínica
            $clinica->delete();
        
            return response()->json(['message' => 'Clínica y base de datos eliminadas exitosamente.']);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la clínica: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function updateStatus(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);
        $clinica->status = $request->input('status');
        $clinica->save();

        return response()->json(['success' => true]);
    }

    public function updateStatusPago(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);
        
        // Asegúrate de que el nuevo estado no sea nulo
        $newStatus = $request->input('estado_pago');
        
        // Actualiza el estado de pago
        $clinica->estado_pago = $newStatus;
        $clinica->save();
    
        return response()->json(['message' => 'Estado de pago actualizado.']);
    }
    

    public function updateStatusMes(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);
        
        // Asegúrate de que el nuevo estado no sea nulo
        $newStatus = $request->input('mes_gratis');
        
        // Actualiza el estado de pago
        $clinica->mes_gratis = $newStatus;
        $clinica->save();
    
        return response()->json(['message' => 'mes actualizado.']);
    }
    
    public function ver($id)
    {
        $clinica = DB::table('clinicas')
        ->join('tenants', 'clinicas.tenant_id', '=', 'tenants.id')
        ->join('domains', 'tenants.id', '=', 'domains.tenant_id')
        ->select(
            'clinicas.id', 
            'clinicas.nombre', 
            'clinicas.titular', 
            'clinicas.direccion', 
            'clinicas.telefono', 
            'clinicas.email', 
            'clinicas.status', 
            'clinicas.estado_pago', 
            'clinicas.mes_gratis', 
            'clinicas.servicio', 
            'clinicas.updated_at', 
            'domains.domain'
        )->where('clinicas.id', $id)->first();

        return response()->json($clinica);
    }

    
}