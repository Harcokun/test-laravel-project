<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookType;

class BookTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(BookType::all(), 200);
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
        $book_type = new BookType();
        $book_type->name = $name;
        $book_type->save();
        return response()->json($book_type, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book_type = BookType::findOrFail($id);
        return response()->json($book_type, 200);
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
        $book_type = BookType::findOrFail($id);
        $name = $request->input('name');
        if(empty($name)) {
            return response()->json('The name should not be null', 400);
        }
        if($book_type) {
            $book_type->name = $name;
            $book_type->touch();
            return response()->json($book_type, 200);
        }
        else {
            return response()->json('Cannot find the book type with this id', 404);
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
        $book_type = BookType::findOrFail($id);
        if($book_type) {
            $book_type = BookType::destroy($id);
            return response()->json('Successfully delete the book type', 200);
        }
        else {
            return response()->json('Cannot find the book type with this id', 404);
        }
    }
}
