<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
class MaterialController extends Controller
{
  
    public function index()
    {
        $materiales = Material::all();
        return $materiales;
    }

  
    public function create()
    {
        return view('materiales.create');
    }

   
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // Crea un nuevo material con los datos del formulario y lo guarda en la base de datos
        Material::create($request->all());

        return redirect()->route('materiales.index')
                         ->with('success', 'Material creado exitosamente.');
    }

   
    public function show(Material $material)
    {
        return view('materiales.show', compact('material'));
    }
 
}
