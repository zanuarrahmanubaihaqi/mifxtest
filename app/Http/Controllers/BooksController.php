<?php

namespace App\Http\Controllers;

use DB;
use App\Book;
use App\User;
use App\Author;
use App\BookReview;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // @TODO implement
        $id = "";
        $count = "";
        $avg = "";
        
        $book = Book::all();
        foreach ($book as $key => $value) {
            $author = DB::select('
                        SELECT a.*
                        FROM authors a
                        LEFT JOIN book_author b ON b.author_id = a.id
                        LEFT JOIN books c ON c.id = b.book_id
                        WHERE c.id = ' . $value->id
                    );

            $ravg = DB::table('books')
                        ->leftJoin('book_reviews AS b', 'b.book_id', '=', 'books.id')
                        ->where('books.id', '=', $value->id)
                        ->avg('b.book_id');

            $rcount = DB::table('books')
                        ->leftJoin('book_reviews AS b', 'b.book_id', '=', 'books.id')
                        ->where('books.id', '=', $value->id)
                        ->count();
                    
            $book[$key]->authors = $author;
            $book[$key]->review = ['avg' => $ravg, 'count' => $rcount];
        }

        return BookResource::collection($book);
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = new Book();
        $book->isbn = $request->input('isbn');
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->authors = $request->input('authors');
        $book->published_year = $request->input('published_year');
        $book->save();

        return new BookResource($book);
    }
}
