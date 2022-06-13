<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Models\Book;
use App\Models\Telephone;

class StoreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Store::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
      
        $store = Store::create($validated);

        // $name = $request->input('name');
        $user = $request->user();
        // $store = new Store();
        // $store->name = $name;
        // $store->save();
        $store->owners()->attach($user->id);
        return response()->json($store, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::with('owners')->find($id);
        if(!$store) {
            return response()->json('Cannot find the store with this id', 404);
        }
        //$store->load('owners');
        //$store->owners() //This is query
        //$store->owners //This will list all owners
        return response()->json(['store' => $store], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $this->authorize('update', $store); // Check authorization before validate for security, prevent from parameter guessing
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        /*$store = Store::find($id);
        if(!$store) {
            return response()->json('Cannot find the store with this id', 404);
        }*/
        $name = $request->input('name');
        $store->name = $name;
        $store->save();
        return response()->json($store, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $store = Store::find($id);
        if(!$store) {
            return response()->json('Cannot find the store with this id', 404);
        }
        $unauthorized_response = $request->user()->cannot('update', $store);
        if (!$unauthorized_response) {
            if($store->books->isNotEmpty()) {
                foreach($store->books as $book) {
                    $book->store()->dissociate();
                    $book->save();
                }
            }
            if($store->telephones->isNotEmpty()) {
                foreach($store->telephones as $telephone) {
                    $telephone->store()->dissociate();
                    $telephone->save();
                }
            }
            $store->owners()->detach($request->user()->id);
            $store = Store::destroy($id);
            return response()->json('Successfully delete the store', 200);
        }
        else {
            return response()->json('You are not authorized to delete the others\' store', 401); 
        }
    }
}


