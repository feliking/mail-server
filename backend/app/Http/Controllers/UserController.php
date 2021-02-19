<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->all());
        return $user->email;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
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
        $user->fill($request->all());
        $user->save();
        return $user;
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
        $user->delete();
        return $user;
    }

    public function change_password(Request $request)
    {
        $hashedPassword = User::findOrFail($request->id)->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            $user = User::findOrFail($request->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                "message" => "Contraseña cambiada"
            ]);
        } else {
            abort(500, 'Contraseña incorrecta');
        }
    }

    public function find_email (Request $request) {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
