<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Cita;
use App\Models\Tenant\Consulta;
use App\Models\Tenant\Logo;
use App\Models\Tenant\Paciente;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();
        $pacientesTotal= Paciente::all()->count();
        $userTotal= User::all()->count();
        $pacientesHoy = Paciente::whereDate('created_at', Carbon::today())->count();
        $consultasTotal = Consulta::all()->count();
        $consultasHoy = Consulta::whereDate('created_at', Carbon::today())->count();
        $citasTotal= Cita::all()->count();
        return view('tenant.dashboard.dashboard',compact('logo','pacientesTotal','userTotal','pacientesHoy',
                                                            'consultasTotal','consultasHoy','citasTotal'));
    }
    //grafico barra pacientes 
    public function getPacientesData(Request $request) {
        $year = $request->input('year');

        $pacientes = DB::table('pacientes')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($pacientes);
    }
}
