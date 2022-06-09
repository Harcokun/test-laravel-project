<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $password = $request->input('password');
        $user = new User();
        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            return response()->json($user, 200);
        }
        else {
            return response()->json('Cannot store a new user, please fill the correct input', 400);
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
        $user = User::findOrFail($id);
        if(!$user) {
            return response()->json('Cannot find the user with this ID', 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::findOrFail($id);
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $password = $request->input('password');
        if($user) {
            if(!empty($firstname)) {
                $user->firstname = $firstname;
            }
            if(!empty($lastname)) {
                $user->lastname = $lastname;
            }
            if(!empty($email)) {
                $user->email = $email;
            }
            if(!empty($password)) {
                $user->password = Hash::make($password);
            }
            $user->touch();
            return response()->json($user, 200);
        }
        else {
            return response()->json('Cannot find the user with this id', 404);
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
        $user = User::findOrFail($id);
        if($user) {
            $user = User::destroy($id);
            return response()->json('Successfully delete the user', 200);
        }
        else {
            return response()->json('Cannot find the user with this id', 404);
        }
    }
}
