<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authors;

class AuthorsController extends Controller
{
    
    public function getAuthors() {
        $authors = authors::all();
        if(count($authors) > 0){
            return response()->json(["status" => 200, "authors" => $authors]);
        } else {
            return response()->json(["status" => 401, "authors" => "No authors founded"]);
        }
    }

    public function addAuthor (request $r) {
        
        $r -> validate([
            'name' => 'required',
            'bio' => 'required',
        ]);

        $author = authors::create([
            'name' => $r -> name,
            'bio' => $r -> bio,
        ]);

        return response() -> json(["status" => 200, "author" => $author, "result" => "author ajouter"]);

    }
}
