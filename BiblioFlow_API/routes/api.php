<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;


Route::post("/addAuthor", [AuthorsController::class, "addAuthor"]);
Route::get("/list/authors", [AuthorsController::class, "getAuthors"]);

Route::post("/addGenre", [GenresController::class, "AddGenre"]);
Route::get("/list/genres", [GenresController::class, "getGenres"]);

Route::post("/addLangue", [LanguesController::class, "addLangue"]);
Route::get("/list/langues", [LanguesController::class, "getLangues"]);

Route::get("/list/books", [BooksController::class, "BooksList"]);
Route::post("/addBook", [BooksController::class, "addBook"]);
Route::get("/book/{id}", [BooksController::class, "singleBook"]);
Route::post('/updateBook/{id}', [BooksController::class, 'updateBook']);
Route::delete('/book/delete/{id}', [BooksController::class, 'deleteBook']);
Route::get("/book/search/{title}", [BooksController::class, 'SearchBook']);
Route::get("/list/books/filter", [BooksController::class, "filterBooks"]);
Route::post("/user/books/likes", [BooksController::class, "userLikedBooks"]);
Route::post("/books/list/comments", [BooksController::class, "getBooksComments"]);
Route::post("/books/checkLike", [BooksController::class, "checkLike"]);


Route::post('/auth/register', [AuthController::class, 'Register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/checktoken', [AuthController::class, 'checkToken']);

Route::post("/addComment", [CommentsController::class, "AddComment"]);
Route::get("/list/comments", [CommentsController::class, "getComments"]);

Route::post("/addLike", [LikesController::class, "AddLike"]);
Route::get("/list/likes", [LikesController::class, "getLikes"]);
