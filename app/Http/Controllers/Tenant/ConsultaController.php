<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Consulta;
use Illuminate\Http\Request;
use App\Models\Tenant\Logo;
use Yajra\DataTables\DataTables;

class ConsultaController extends Controller
{
   public function index(){

    $logo = Logo::where('status',1)->first();
    return view('tenant.consultas.index',compact('logo'));
   }

   public function getConsultas()
   {
       $consultas = Consulta::with(['paciente', 'medico'])->get(); // Carga las relaciones
   
       return DataTables::of($consultas)->make(true);
   }
}
