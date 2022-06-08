<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Telephone;
use App\Models\Store;

class TelephoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Telephone::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $request->input('model');
        $price = $request->input('price');
        $store_id = $request->input('store_id');
        $telephone = new Telephone();
        if(!empty($model) && ($price > 0) && Store::findOrFail($store_id)) {
            $telephone->model = $model;
            $telephone->price = $price;
            $telephone->store_id = $store_id;
            $telephone->save();
            return response()->json($telephone, 200);
        }
        else {
            return response()->json('Cannot store a new telephone, please fill the correct input', 400);
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
        $telephone = Telephone::findOrFail($id);
        return response()->json($telephone, 200);
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
        $telephone = Telephone::findOrFail($id);
        $model = $request->input('model');
        $price = $request->input('price');
        $store_id = $request->input('store_id');
        if($telephone) {
            if(!empty($model)) {
                $telephone->model = $model;
            }
            if(isset($price) && $price > 0) {
                $telephone->price = $price;
            }
            if(isset($store_id) && Store::findOrFail($store_id)) {
                $telephone->store_id = $store_id;
            }
            $telephone->touch();
            return response()->json($telephone, 200);
        }
        else {
            return response()->json('Cannot find the telephone with this id', 404);
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
        $telephone = Telephone::findOrFail($id);
        if($telephone) {
            $telephone = Telephone::destroy($id);
            return response()->json('Successfully delete the telephone', 200);
        }
        else {
            return response()->json('Cannot find the telephone with this id', 404);
        }
    }
}
