<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

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
        $name = $request->input('name');
        $user = $request->user();
        $store = new Store();
        $store->name = $name;
        $store->save();
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
        $store = Store::where('id', $id)->firstOrFail();
        if(!$store) {
            return response()->json('Cannot find the store with this id', 404);
        }
        return response()->json($store, 200);
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
        $store = Store::findOrFail($id);
        if(!$store) {
            return response()->json('Cannot find the store with this id', 404);
        }
        $unauthorized_response = $request->user()->cannot('update', $store);
        if (!$unauthorized_response) {
            $name = $request->input('name');
            if(empty($name)) {
                return response()->json('The name should not be null', 400);
            }
            $store->name = $name;
            $store->touch();
            return response()->json($store, 200);
        }
        else {
            return response()->json('You are not authorized to update the others\' store', 401); 
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
        $store = Store::findOrFail($id);
        if(!$store) {
            return response()->json('Cannot find the store with this id', 404);
        }
        $unauthorized_response = $request->user()->cannot('update', $store);
        if (!$unauthorized_response) {
            $store = Store::destroy($id);
            return response()->json('Successfully delete the store', 200);
        }
        else {
            return response()->json('You are not authorized to delete the others\' store', 401); 
        }
    }
}
