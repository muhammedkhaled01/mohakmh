<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookImage;
use Illuminate\Http\Request;

class Api_BookImageController extends Controller
{
    public function books(Request $request)
    {
        $books = Book::select('id', 'name', 'category_id', 'paid', 'description', 'updated_at')->with(['firstImage'])->get();
        $response = [
            'status' => true,
            'message' => 'you have all books details',
            'data' => $books
        ];
        return response()->json($response, 200);
    }

    public function bookpages($id)
    {
        $bookid = $id;
        $book_image = BookImage::where('book_id', $bookid)->select('id', 'image')->paginate(5);
        if ($book_image->isEmpty()) {
            $response = [
                'status' => false,
                'message' => 'this book does not exist'
            ];
            return response()->json($response, 404);
        }

        $book = Book::find($bookid);

        $response = [
            'status' => true,
            'message' => 'you will get 5 images',
            'data' => [
                'name' => $book->name,
                'images' => $book_image
            ]
        ];

        return response()->json($response, 200);
    }
}
