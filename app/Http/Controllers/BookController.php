<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookType;
use App\Models\Store;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $book_type_id = $request->input('book_type_id');
        $store_id = $request->input('store_id');
        $book = new Book();
        if(!empty($name) && ($price > 0) && BookType::find($book_type_id)) {
            $book->name = $name;
            $book->price = $price;
            $book->book_type_id = $book_type_id;
            $store = Store::find($store_id);
            if($store) {
                // this->authorize('create', [Book::class, $store]);
                // $book->store_id = $store_id;
                $unauthorized_response = $request->user()->cannot('create', [Book::class, $store]);
                if(!$unauthorized_response) {
                    $book->store_id = $store_id;
                }
                else {
                    return response()->json('Cannot store a new book: You are not authorized to add a new book to the others\' store', 403);
            
                }
            }
            else {
                return response()->json('Cannot store a new book: Invalid store_id'. 400);
            }
            $book->save();
            return response()->json($book, 200);
        }
        else {
            return response()->json('Cannot store a new book: Incorrect input', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $name = $request->input('name');
        $price = $request->input('price');
        $book_type_id = $request->input('book_type_id');
        $store_id = $request->input('store_id');
        if($book) {
            if(!empty($name)) {
                $book->name = $name;
            }
            if(isset($price) && $price > 0) {
                $book->price = $price;
            }
            if(isset($book_type_id) && BookType::find($book_type_id)) {
                $book->book_type_id = $book_type_id;
            }
            if(isset($store_id) && Store::find($store_id)) {
                $book->store_id = $store_id;
            }
            $book->touch();
            return response()->json($book, 200);
        }
        else {
            return response()->json('Cannot find the book with this id', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if($book) {
            $book = Book::destroy($id);
            return response()->json('Successfully delete the book', 200);
        }
        else {
            return response()->json('Cannot find the book with this id', 404);
        }
    }
}
