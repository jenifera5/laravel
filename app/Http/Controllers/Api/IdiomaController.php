<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Idioma;
use Illuminate\Http\Request;

class IdiomaController extends Controller
{
    //Funció que torna els idiomes que tenim a BBDD
    public function index()
    {
        $idioma = Idioma::all();
        return $idioma;
    }

}
