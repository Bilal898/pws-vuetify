<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class UserController extends Controller
{
    public function login(Request $request){
        // echo json_encode($request->all()); exit;
        // $username = $request->email;
        // $password = bcrypt($request->password);
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $token = Str::random(80);
            Auth::user()->api_token = $token;
            Auth::user()->save();
            return response()->json(['token' => $token], 200);
        }
        // $user = User::where('email', $username)->where('password', $password)->first();
        // if($user){
        //     $token = Hash::make($request->password);
        //     $user->api_token = $token;
        //     $user->save();
        // }
        return response()->json(['status' => 'Email or Password is wrong'], 403);
    }

    public function verify(Request $request){
        return $request->user()->only('name', 'email');
    }
}
