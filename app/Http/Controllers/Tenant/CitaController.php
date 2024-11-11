<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;

use App\Models\Tenant\Cita;
use App\Models\Tenant\Logo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CitaController extends Controller
{
   public function index(){
    $logo = Logo::where('status',1)->first();
    return view('tenant.citas.index',compact('logo'));
   }

   public function list(){
      $logo = Logo::where('status',1)->first();

      return view('tenant.citas.list',compact('logo'));
   }

   public function getCitas()
   {
       $citas = Cita::with('paciente','medico')
       ->orderBy('created_at', 'DESC')
       ->get();
   
       return DataTables::of($citas)
           ->make(true);
   }
}


