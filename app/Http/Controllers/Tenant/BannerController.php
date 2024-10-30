<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Banner;
use App\Models\Tenant\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class BannerController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();
        
       
        return view('tenant.banner.index', compact('logo'));
    }

    public function getBanner()
    {
        $banners = Banner::all()->map(function ($banner) {
            // Aquí generamos la URL completa para la imagen
            $banner->image_url = asset($banner->image_url); 
            return $banner;
        });
    
        return DataTables::of($banners)->make(true);
    }

    public function create(){
        $logo = Logo::where('status',1)->first();
        return view('tenant.banner.create', compact('logo'));
    }

    public function store(Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|string',
            'name_button' => 'required|string',
            'filepond' => 'required|file|mimes:jpeg,png',
            'status' => 'required|string',
        ]);
    
        // Retornar errores de validación
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->messages()
            ], 422);
        }
        
    
        // Guardar la imagen en la carpeta específica para el usuario
        $imagePath = $request->file('filepond')->store("images/banner", 'public');
    
    
        // Crear el banner en la base de datos
        $banner = new Banner();
        $banner->title = $request->input('title');
        $banner->description = $request->input('description');
        $banner->url = $request->input('url');
        $banner->name_button = $request->input('name_button');
        $banner->image_url = $imagePath;
        $banner->status = $request->input('status');
        $banner->save();
    
        return response()->json([
            'message' => 'El banner se ha guardado correctamente.',
            'redirect_url' => route('tenant.banner.index')
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = $request->input('status');
        $banner->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::delete('public/' . $banner->image_url);
        $banner->delete();

        return response()->json(['message' => 'Banner eliminado exitosamente.']);
    }
}
