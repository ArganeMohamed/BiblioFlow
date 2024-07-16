<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Likes;

class LikesController extends Controller
{
    public function getLikes () { 
        $likes = Likes::with('user', 'books.authors', 'books.langues', 'books.genres')->get();
        return response() -> json(["status" => 200, "likes" => $likes]);
    }

    public function AddLike (Request $r) {
        $userID = $r->user_id;
        $bookID = $r->book_id;

        $like = Likes::create([
            "user_id" => $userID,
            "book_id" => $bookID
        ]);

        return response() -> json(["status" => 200, "like" => $like]);

    }

}
