<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genres;

class GenresController extends Controller
{
    public function getGenres () {
        $genres = genres::all();
        if(count($genres) > 0) {
            return response()->json(["status" => 200, "genres" => $genres]);
        } else {
            return response()->json(["status" => 401, "genres" => "No genres founded"]);
        }
    }

    public function AddGenre(Request $r) {
        
        $r -> validate([
            'name' => 'required'
        ]);

        $genre = genres::create([
            'name' => $r -> name
        ]);

        return response() -> json([
            'status' => 200,
            'genre' => $genre,
            'message' => 'Genre ajouter',
        ]);
        
    }
}
