<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function all(Request $request)
    {
        $users = User::when($request->has('tipo') && $request->tipo != '', function($query) use ($request){
            $query->where('tipo_usuario', $request->tipo);
        })
        ->orderBy('name')
        ->select('users.*')
        ->get();

        return $this->successResponse($users);
    }

    public function register(Request $request)
    {
        $data = $request ->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->tipo_usuario = $request->tipo;
        $user->save();

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $attrs = $request ->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if(!Auth::attempt($attrs)){
            return response([
                'message' => 'invalid credentials.'
            ], 403);
        }

        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('')->plainTextToken
        ], 200);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }

    public function one($id)
    {
        $user = User::find($id);

        return $this->successResponse($user);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $data = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'min:6'
        ]);

        $user->fill($data);
        $user->tipo = $request->tipo;
        $user->save();

        return $this->successResponse($user);
    }

}
