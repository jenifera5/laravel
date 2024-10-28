<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    //
    public function index()
    {
        $materials = Material::with('media')->get();
        return $materials;
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'numero_serie' => 'required',
            'preciocoste',
            'margen',
            'pvp',
            'encurs',
            'observacions'



        ]);
        $data = $request->all();

        //return $data;

        $material = Material::create($data);
        $material['marca'] = $material->marca;
        $material['familia'] = $material->familia;
        $material['proveidor'] = $material->proveidor;
        $response = [
            'sucess' => true,
            'data' => $material,
            'message' => 'material creat correctament'
        ];
        if ($request->hasFile('img')) {
            $material->addMediaFromRequest('img')->preservingOriginal()->toMediaCollection('images-materials');
        }

        $material->media = $material->media;

        return response()->json($response);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'codigo' => 'required',
            'description' => 'required',
            'stock',
            'numero_serie',
            'preciocoste',
            'pvp',
            'encurs',
            'observacions'

        ]);
        $data = $request->all();
        $material =  Material::find($id);
        $material->update($request->all());
        $material['marca'] = $material->marca;
        $material['familia'] = $material->familia;
        $material['proveidor'] = $material->proveidor;
        $response = [
            'success' => true,
            'data' => $material,
            'message' => 'material modificat correctament'
        ];
        if ($request->hasFile('img')) {
            $material->media()->delete();
            $material->addMediaFromRequest('img')->preservingOriginal()->toMediaCollection('images-materials');
        }

        $material->media = $material->media;

        return response()->json($response);
    }

    public function destroy($id)
    {
        $material = Material::find($id);
        $material->delete();
        $response = [
            'success' => true,
            'data' => $material,
            'message' => 'material esborrat correctament'
        ];
        return response()->json($response);
    }
}
