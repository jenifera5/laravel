<?php

namespace App\Http\Controllers\api;

use App\Models\Albaran;
use App\Http\Controllers\Controller;
use App\Models\Orden_trabajo;
use Illuminate\Http\Request;

class AlbaranController extends Controller
{
    //
    public function index()
    {
        $albarans = Albaran::with('orden_trabajo','materials')->get();
        return $albarans;
    }
    public function store(Request $request)
    {
        $request->validate([
            'clients_id',
            'ordenes_trabajo_id',
            'titulo',
            'descripcion',
            'descuentos_id',
            'observacions',
            'precio_id',
            'iva'

        ]);

        $albaran = Albaran::create($request->all());
        $albaran['Orden_trabajo']=$albaran->orden_trabajo;
        $albaran['Material']=$albaran->materials;

        $response = [
            'sucess' => true,
            'data' => $albaran,
            'message' => 'albaran creat correctament'
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'clients_id',
            'ordenes_trabajo_id',
            'titulo',
            'descripcion',
            'descuentos_id',
            'observacions',
            'precio_id',
            'iva'

        ]);
        $albaran =  Albaran::find($id);
        $albaran->update($request->all());
        $albaran['Orden_trabajo']=$albaran->orden_trabajo;
        $albaran['Material']=$albaran->materials;
        $response = [
            'success' => true,
            'data' => $albaran,
            'message' => 'albaran modificat correctament'
        ];
        return response()->json($response);
    }

    public function destroy($id)
    {
        $albaran = Albaran::find($id);
        $albaran->delete();
        $response = [
            'success' => true,
            'data' => $albaran,
            'message' => 'albaran esborrat correctament'
        ];
        return response()->json($response);
    }

}
