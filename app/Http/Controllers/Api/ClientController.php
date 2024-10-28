<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //Funció que torna els clients que tenim
    public function index()
    {
        $clients = Client::with('idioma', 'direccions')->get();
        return $clients;
    }
    //FUNCIÓ QUE TORNA UN CLIENT PER ID
    public function show($id)
    {
        $client = Client::with('idioma', 'direccions')->find($id);

        if ($client) {

            return $client;
        } else {
            $client=[];
            return $client;
        }
    }
    //Funció que torna els clients que tenim per nif

    public function showByNif($nif)
    {
        $client = Client::where('nif', $nif)->first();

        if ($client === null) {
            return 0;
        }
        return 1;
    }

    //Funció que guarda una nou client
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname1' => 'required',
            'surname2' => 'required',
            'nif' => 'required',
            'telefon' => 'required',
            'telefon2',
            'email' => 'required',

        ]);
        //return $request->direccions;
        $client = Client::create($request->all());
        //demanem que ens torni també l'idioma
        //$client['idioma'] = $client->idioma;
        //$client['direccion'] = $client->direccion;
        $client->direccions()->delete();
        $client->direccions()->createMany($request->direccions);

        $response = [
            'success' => true,
            'data' => $client,
            'message' => 'client creat correctament'
        ];
        return response()->json($response);
    }

    //Funció que modifica un client
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'surname1' => 'required',
            'surname2' => 'required',
            'nif' => 'required',
            'telefon' => 'required',
            'telefon2',
            'email' => 'required',
        ]);
        // $data = $request->all();
        $client = Client::find($id);
        $client->update($request->all());
        $client->idioma;
        $client->direccions()->delete();
        $client->direccions()->createMany($request->direccions);
        $client->direccions;

        $response = [
            'success' => true,
            'data' => $client,
            'message' => 'client modificat correctament'
        ];
        return response()->json($response);
    }
    //Funció que esborra una client
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        $response = [
            'success' => true,
            'data' => $client,
            'message' => 'client esborrat correctament'
        ];
        return response()->json($response);
    }
}

// public function update(StoreProductRequest $request, Product $product)
//     {
//         // $keywords is come from <textarea></textarea>
//         // format is ['b', 'c', 'd']
//         $keywords = $request->validated()['keywords'];

//         /**
//          * sync product hasMany keywords
//          */

//         // Begin Transaction
//         DB::beginTransaction();
//         try{
//             // 1. delete db record that NotIn request keywords array value
//             $product->productKeywords()->whereNotIn('keyword', $keywords)->delete();

//             // 2. updateOrCreate db exists record
//             foreach ($keywords as $keyword) {
//                 $product->productKeywords()->updateOrCreate(['keyword' => $keyword]);
//             }

//             DB::commit();
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->withErrors(['transaction_error' => $e->getMessage()]);
//         }
