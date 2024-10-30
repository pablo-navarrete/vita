<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Logo;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();
        $banners = Banner::where('status', 1)->get();
        return view('admin.web.home',compact('logo','banners'));
    }

    public function about(){
        $logo = Logo::where('status',1)->first();
        return view('admin.web.about',compact('logo'));
    }

    public function service(){
        $logo = Logo::where('status',1)->first();
        return view('admin.web.service',compact('logo'));
    }

    public function contact(){
        $logo = Logo::where('status',1)->first();
        return view('admin.web.contact',compact('logo'));
    }
}
