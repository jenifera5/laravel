<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
class MaterialController extends Controller
{
  
    public function index()
    {
        $materials = Material::all();
        return $materials;
    }

  
    public function create()
    {
        return view('materiales.create');
    }

   
    public function store(Request $request)
    {
        $request->validate(['name'=>'Required|max:10',
        'description'=>'required'
    ]);
    $data = $request->all();
    $materials= Material ::create($data);

    $response = [
    'success'=> true,
    'message'=>' el material se ha creado correctamente',
    'data'=> $materials
    ];
    return response()->json();
    }

   
    public function show(Material $material)
    {
        return view('materiales.show', compact('material'));
    }
 
}
