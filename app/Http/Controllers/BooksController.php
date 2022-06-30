<?php

namespace App\Http\Controllers;

use DB;
use App\Book;
use App\User;
use App\Author;
use App\BookReview;
use App\BookAuthor;
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
        dd($request);
        
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
        // dd(DB::select('SELECT * FROM authors'));
        // $user_id = 6;
        $check_isbn = DB::select('SELECT id FROM books WHERE isbn = "' . $request->input('isbn') . '"');
        if ($check_isbn != []) {
            return "book is allready";
        }
        exit;

        $book = new Book();
        $book->isbn = $request->input('isbn');
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->published_year = $request->input('published_year');
        $book->save();

        $last_book_id = DB::select('
                            SELECT id
                            FROM books
                            ORDER BY id DESC LIMIT 1
                        ')[0]->id;

        $author_name = $request->authors[0]['name'];
        $author_surname = $request->authors[0]['surname'];
        $check_author = DB::select('
                            SELECT id
                            FROM authors
                            WHERE name = "' . $author_name . '"'
                        );
        if ($check_author == []) {
            $author = new Author;
            $author->name = $author_name;
            $author->surname = $author_surname;
            $author->save();
        }

        $author_id = DB::select('
                            SELECT id
                            FROM authors
                            WHERE name = "' . $author_name . '"'
                        )[0]->id;
        
        $book_author = new BookAuthor;
        $book_author->book_id = $last_book_id;
        $book_author->author_id = $author_id;
        $book_author->save();

        return new BookResource($book);
    }
}
