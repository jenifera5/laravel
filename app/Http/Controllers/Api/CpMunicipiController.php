<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cp;
use Illuminate\Http\Request;

class CpMunicipiController extends Controller
{
    public function getCp($codi)
    {


        // Obté les dades del codi postal específic amb la relació 'municipi.provincia'
        $postalCode = Cp::with('municipi.provincia')
                        ->where('cp', $codi) // Filtra per codi postal
                        ->first(); // Obté el primer resultat trobat

        // Comprova si s'ha trobat un codi postal amb aquest codi
        if ($postalCode) {
            // Retorna les dades amb la informació del municipi i la província
            return $postalCode;
        } else {
            // En cas que no es trobi cap codi postal amb aquest codi, retorna una resposta adequada (pots canviar aquesta part segons la teva necessitat)
            return response()->json(['message' => 'Codi postal no trobat'], 404);
        }
    }
}
