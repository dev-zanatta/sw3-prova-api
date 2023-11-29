<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function all()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    public function register(Request $request)
    {
        $attrs = $request ->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        $user = new User();
        $user->name = $attrs['name'];
        $user->email = $attrs['email'];
        $user->password = bcrypt($attrs['password']);
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

}
