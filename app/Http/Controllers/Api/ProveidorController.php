<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Proveidor;
use Illuminate\Http\Request;

class ProveidorController extends Controller
{
    //
    public function index()
    {
        $proveidors = Proveidor::with('direccions_proveidors')->get();
        return $proveidors;
    }
    public function show($id)
    {
        $proveidor = Proveidor::with( 'direccions_proveidors')->find($id);

        if ($proveidor) {

            return  $proveidor;
        } else {
            $proveidor=[];
            return  $proveidor;
        }
    }
        //Funció que torna els proveidors que tenim per nif

        public function showByNif($nif)
        {
            $proveidor = Proveidor::where('nif', $nif) ->first();

            if ($proveidor === null) {
                return 0;
            }
            return 1;
        }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nif'=>'required',
            'telefon'=>'required',
            'telefon2',
            'email'=>'required',
            'contacte',
            'encurs',
            'diacobrament',
            'observacions'

        ]);
        $proveidor= Proveidor::create($request->all());
        $proveidor->direccions_proveidors()->delete();
        $proveidor->direccions_proveidors()->createMany($request->direccions_proveidors);

        $response=[
            'sucess'=>true,
            'data'=>$proveidor,
            'message'=>'proveidor creat correctament'
        ];
        return response()->json($response);
    }

    public function update(Request $request,$id)
    {

        $request->validate([
            'name' => 'required',
             'nif'=>'required',
            'telefon'=>'required',
            'telefon2',
            'email'=>'required',
            'contacte',
            'encurs',
            'diacobrament',
            'observacions'

        ]);
        //$data = $request->all();
        $proveidor= Proveidor::find($id);
        $proveidor->update($request->all());
        $response = [
            'success'=> true,
            'data'=>$proveidor,
            'message'=>'proveidor modificat correctament'
        ];
        return response()->json($response);
    }

    public function destroy($id)
    {
        $proveidor = Proveidor::find($id);
        $proveidor->delete();
        $response = [
            'success' => true,
            'data' => $proveidor,
            'message' => 'proveidor esborrat correctament'
        ];
        return response()->json($response);
    }

}
