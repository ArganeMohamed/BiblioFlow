<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function getComments () { 
        $comments = Comments::with('user', 'books.authors', 'books.langues', 'books.genres')->get();
        return response() -> json(["status" => 200, "comments" => $comments]);
    }

    public function AddComment (Request $r) {
        $userID = $r->user_id;
        $bookID = $r->book_id;
        $content = $r->comment;

        $comment = Comments::create([
            "user_id" => $userID,
            "book_id" => $bookID,
            "comment" => $content
        ]);

        return response() -> json(["status" => 200,"result" => "comment Added" ,"comment" => $comment]);

    }
}
