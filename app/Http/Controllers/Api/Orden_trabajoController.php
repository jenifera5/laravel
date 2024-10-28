<?php

namespace App\Http\Controllers\api;

use App\Models\Orden_trabajo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Orden_trabajoController extends Controller
{
    //
    public function index()
    {
        $ordres=Orden_trabajo::with('client.direccions', 'direccio','operario')->get();
        return $ordres;

    }
    public function store(Request $request)
    {
        //validació de les dades
        $request->validate([
            'descripcion'=>'required',
            'horas'=>'required',
            'date_open'=>'required',
            'date_close'=>'required',
            'client_id'=>'required',
            'operario_id'=>'required',
            'direccion_id'=>'required',

        ]);


        //creem ordre de traball
        $orden=Orden_trabajo::create($request->all());
        //demanem que ens torni també CLient, Operari i Material
        $orden['client'] = $orden->client;
        $orden['operario'] = $orden->operario;
        $response =[
            'success' => true,
            'data' => $orden,
            'message' => 'Ordre de Traball creada correctament'
        ];
        return response()->json($response);
    }
      //funcio per modificar ordre de traball

      public function update(Request $request, $id)
      {
        $request->validate([
            'descripcion'=>'required',
            'horas'=>'required',
            'date_open'=>'required',
            'date_close'=>'required',
            'client_id'=>'required',
            'operario_id'=>'required',
            'direccion_id'=>'required',
        ]);
          $ordre = Orden_trabajo::find($id);
          $ordre->update($request->all());
          $ordre['client'] = $ordre->client;
          $ordre['operario'] = $ordre->operario;
          $response =[
              'success' => true,
              'data' => $ordre,
              'message' => 'Ordre de Traball modificada correctament'
          ];
          return response()->json($response);
      }
      //funcio per eliminar ordre de traball
      public function destroy($id)
      {
          $ordre = Orden_trabajo::find($id);
          $ordre->delete();
          $response =[
              'success' => true,
              'data' => null,
              'message' => 'Ordre de Traball eliminada correctament'
          ];
          return response()->json($response);
      }

      public function showById($id)
      {

          $clientOrders = Orden_trabajo::where('client_id', $id)->with('client', 'direccio','operario')->get();
          return $clientOrders;
      }
}

