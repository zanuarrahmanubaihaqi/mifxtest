<?php

namespace App\Http\Controllers;

use App\BookReview;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\Request;
use DB;

class BooksReviewController extends Controller
{
    public function __construct()
    {

    }

    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement
        $bookReview = new BookReview();
        $bookReview->book_id = $bookId;
        $bookReview->user_id = $request->input('user_id');
        $bookReview->review = $request->input('review');
        $bookReview->comment = $request->input('comment');
        $bookReview->save();

        return new BookReviewResource($bookReview);
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $bookReview = BookReview::where(['book_id' => $bookId, 'user_id' => $reviewId])->get();
        $bookReview->delete();
    }
}
