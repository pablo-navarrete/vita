<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $clinicasTotal= Clinica::all()->count();
        $clinicasStatusActive= Clinica::all()->where('status',1)->count();
        $clinicasStatusInactive= Clinica::all()->where('status',0)->count();
        $clinicasPagados= Clinica::all()->where('estado_pago',1)->count();
        $clinicasAtrasados= Clinica::all()->where('estado_pago',0)->count();
        $clinicasMes= Clinica::all()->where('mes_gratis',1)->count();
  
        return view('admin.dashboard.index', compact('clinicasTotal','clinicasStatusActive','clinicasStatusInactive','clinicasPagados','clinicasAtrasados','clinicasMes'));
    }

    
    //grafico circular servicio
    public function getServicioData()
    {
        // Mapa de servicios
        $servicioMap = [
            1 => 'Básico',
            2 => 'Estándar',
            3 => 'Premium'
        ];
    
        // Obtén los servicios y cuenta las clínicas por servicio
        $servicios = DB::table('clinicas')
            ->select('servicio', DB::raw('count(*) as total'))
            ->groupBy('servicio')
            ->get();
    
        // Reemplaza los valores numéricos por sus descripciones
        $result = $servicios->map(function($item) use ($servicioMap) {
            return [
                'servicio' => $servicioMap[$item->servicio] ?? 'Desconocido', // Mapea el servicio
                'total' => $item->total
            ];
        });
    
        return response()->json($result);
    }
    
    //grafico barra clinicas 
    public function getClinicasData(Request $request) {
        $year = $request->input('year');
    
        $clinicas = DB::table('clinicas')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        return response()->json($clinicas);
    }
}
