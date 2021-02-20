<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecoveryPassword;

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
        $request['recovery_password'] = uniqid();
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

    public function recovery_password (Request $request) {
        $user = User::where('email', $request['email'])->first();
        Mail::to($user->email)->send(new RecoveryPassword($user));
        return $user->email;
    }

    public function verify_code (Request $request) {
        return User::where('recovery_password', $request['code'])->get();
    }

    public function reset_password (Request $request) {
        $user = User::findOrFail($request['id']);
        $request['password'] = bcrypt($request['password']);
        $request['recovery_password'] = uniqid();
        $user->fill($request->all());
        $user->save();
        return $user->email;
    }
}
