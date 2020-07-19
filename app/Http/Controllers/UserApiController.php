<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserApiController extends Controller
{
    public function all()
    {
        return response(['users' => User::all()]);
    }
    public function authenticate(Request $req){
        $credentials = $req->only('email', 'password');
        try{
            
        if(! $token = JWTAuth::attempt($credentials))  {
            return response()->json(['error'=>'invalid_credentials'], 401);
        }
        }catch(JWTException $e) {
            return response()->json(['error'=> 'could not create a token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function getAuthenticatedUser(User $user){
        try {
            if(! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error'=>'user not found'], 404);
            }
        } catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token expired'], $e->getStatusCode());

        } catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token invalid'], $e->getStatusCode());

        }catch( \Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token absent'], $e->getStatusCode());


        }
        return response()->json(compact('user'));
    }
    public function register( Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson());
        }
        $user = User::create(['email'=> $req->email, 'password'=> Hash::make($req->password), 'name'=> $req->name]);
       return response()->json([
           'user'=> $user,
           'token'=> JWTAuth::fromUser($user),
       ], 201);
    }
}
