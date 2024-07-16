<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langues;

class LanguesController extends Controller
{

    public function getLangues() {
        $langues = Langues::all();
        return response() -> json(["status" => 200, "langues" => $langues]);
    }

    public function addLangue(Request $r) {
        $r -> validate([
            'langue' => 'required|string',
        ]);

        $langue = Langues::create([
            'langue' => $r -> langue,
        ]);

        return response() -> json(["status" => 200, "message" => "Langue Ajouter", "langue" => $langue]);
    }
}
