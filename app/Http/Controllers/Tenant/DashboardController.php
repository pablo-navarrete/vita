<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Logo;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();
        return view('tenant.dashboard.dashboard',compact('logo'));
    }

}
