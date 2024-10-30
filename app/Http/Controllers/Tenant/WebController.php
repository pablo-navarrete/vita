<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Banner;
use App\Models\Tenant\Logo;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();
        $banners = Banner::where('status', 1)->get();
        return view('tenant.web.welcome',compact('logo','banners'));
    }

    public function about(){
        $logo = Logo::where('status',1)->first();
        return view('tenant.web.about',compact('logo'));
    }

    public function service(){
        $logo = Logo::where('status',1)->first();
        return view('tenant.web.service',compact('logo'));
    }

    public function contact(){
        $logo = Logo::where('status',1)->first();
        return view('tenant.web.contact',compact('logo'));
    }
}
