<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Likes;
use DB;

class BooksController extends Controller
{
    public function BooksList() {
        $books = Books::with('authors', 'genres', 'langues')->get();

        if (count($books) > 0) {
            return response()->json(["status"=>200, "books"=>$books]);
        } else {
            return response()->json(["status"=>401, "data"=>"No data found"]);
        }
    }

    public function addBook (request $r) {
        $r -> validate([
            'title' => 'required',
            'author_id' => 'required',
            'genre_id' => 'required',
            'langue_id' => 'required',
            'publication_date' => 'required|date',
            'isbn' => 'required',
            'nbr_pages' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,',
            'pdf_file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $img = $r->file('image');
        $img_name = time().'.'.$img->getClientOriginalExtension();
        $img->move(public_path('images'), $img_name);

        $pdf_name = null;
        if ($r->hasFile('pdf_file')) {
            $pdf = $r->file('pdf_file');
            $pdf_name = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('pdfs'), $pdf_name);
        }

        $book = Books::create([
            'title' => $r -> title,
            'author_id' => $r -> author_id,
            'genre_id' => $r -> genre_id,
            'langue_id' => $r -> langue_id,
            'publication_date' => $r -> publication_date,
            'isbn' => $r -> isbn,
            'nbr_pages' => $r -> nbr_pages,
            'description' => $r -> description,
            'image' => $img_name,
            'pdf_file' => $pdf_name,
        ]);

        return response() -> json([
            'status' => 200,
            'book' => $book,
            'retult' => "Book Ajouter",
        ]);
    }

    public function singleBook(Request $r) {
        $id = $r -> id;
        $book = Books::with('authors', 'genres', 'langues')->find($id);
        if ($book) {
            return response() -> json(["status" => 200, "Book" => $book]);
        } else {
            return response() -> json(["status" => 401, "Book" => "No book Found"]);
        }
    }

    public function updateBook(Request $r, $id) {
        $book = Books::find($id);
        if (!$book) {
            return response()->json(['status' => 401, 'message' => 'Book not found']);
        }
        $r->validate([
            'title' => 'required',
            'author_id' => 'required',
            'genre_id' => 'required',
            'langue_id' => 'required',
            'publication_date' => 'required|date',
            'isbn' => 'required',
            'nbr_pages' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($r->hasFile('image')) {
            $img = $r->file('image');
            $img_name = time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('images'), $img_name);
            $book->image = $img_name;
        }
        $book->update([
            'title' => $r->title,
            'author_id' => $r->author_id,
            'genre_id' => $r->genre_id,
            'langue_id' => $r->langue_id,
            'publication_date' => $r->publication_date,
            'isbn' => $r->isbn,
            'nbr_pages' => $r->nbr_pages,
            'description' => $r->description,
        ]);
        return response()->json(['status' => 200, 'book' => $book, 'message' => 'Book updated successfully']);
    }

    public function deleteBook(request $r) {
        $book = Books::find($r->id);
        if($book) {
            $book->delete();
            return response() -> json(["status" => 200, "result" => "Book deleted"]);
        } else {
            return response() -> json(["status" => 401, "book" => "No book found"]);
        }
    }

    public function SearchBook (Request $r) {
        $search = $r->title;
        $books = Books::with('authors', 'genres', 'langues') ->
        where('title', 'like', '%'.$search.'%')->get();
        return response() -> json(["status" => 200, "books" => $books]);
    }

    public function filterBooks(Request $r)
    {
        $authorId = $r->author;
        $genreId = $r->genre;
        $langueId = $r->langue;

        $query = Books::query();

        if ($authorId) {
            $query->where('author_id', $authorId);
        }

        if ($genreId) {
            $query->where('genre_id', $genreId);
        }

        if ($langueId) {
            $query->where('langue_id', $langueId);
        }

        $books = $query->with(['authors', 'genres', 'langues'])->get();

        return response()->json(["count" => count($books),'books' => $books]);
    }

    public function userLikedBooks(Request $request) {
        $userID = $request->userID;

        $likedBooks = DB::table('likes')
            ->join('books', 'likes.book_id', '=', 'books.id')
            ->where('likes.user_id', $userID)
            ->select('books.*')
            ->get();

        if (count($likedBooks) > 0) {
            return response()->json(["status" => 200, "likedBooks" => $likedBooks]);
        } else {
            return response()->json(["status" => 404, "message" => "No liked books found"]);
        }
    }

    public function getBooksComments(Request $r) {
        $bookId = $r -> book_id ;
    
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.book_id', $bookId)
            ->select('comments.*', 'users.nom', 'users.prenom')
            ->get();
    
        if (count($comments) > 0) {
            return response()->json(["status" => 200, "comments" => $comments]);
        } else {
            return response()->json(["status" => 401, "message" => "No comments found"]);
        }
    }

    public function checkLike(Request $request) {
        $like = Likes::where('user_id', $request->user_id)
                    ->where('book_id', $request->book_id)
                    ->first();

        return response()->json(['liked' => $like ? true : false]);
    }
    

}

