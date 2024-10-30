<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class LogoController extends Controller
{
    public function index(){
        $logo = Logo::where('status',1)->first();

        return view('tenant.logo.index', compact('logo'));
    }

    public function store(Request $request)
    {
     
          // Validación
        $validator = Validator::make($request->all(), [
            'filepond' => 'required|file|mimes:jpeg,png,svg,jpg',
            'status' => 'required|string',
        ]);
    
        // Retornar errores de validación
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->messages()
            ], 422);
        }
      
         // Guardar la imagen en la carpeta específica 
         $imagePath = $request->file('filepond')->store("images/logo", 'public');
      
         $logo = new Logo();
         $logo->image_url = $imagePath;
         $logo->status = $request->input('status');
         $logo->save();
     
         return response()->json([
             'message' => 'El logo se ha guardado correctamente.',
             'redirect_url' => route('tenant.logo.index')
         ]);
      
    }
    
    
}
