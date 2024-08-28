<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function Register(RegisterRequest $request)

    {
        try{

            $user=User::create([
             'name'=>$request->name,
             'email' => $request->email,
             'password'=>Hash::make($request->password)
            ]);
            $auth_token=JWTAuth::fromUser($user);
             return response()->json([
           'User'=>new UserResource($user),
           'status' =>'Register Done',
            'token'=>$auth_token,
             ]);

        }
        catch(Throwable $th)
        {
            Log::debug($th);
            $e=\Log::error( $th->getMessage());
            return response()->json([
                'status' =>'error',

              ]);
        }
    }

    //Login


     public function login(LoginRequest $request)
     {
        try{
            $credentials = $request->only('email','password');

            if(!$auth_token = Auth::guard('api')->attempt($credentials)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);


            }
            $user=Auth::guard('api')->user();
            return response()->json([
                'status' => 'login',
                'user' => new UserResource($user),
                'token' =>$auth_token
            ], 200);

        }
        catch(Throwable $th)
        {
            Log::debug($th);
            $e=\Log::error( $th->getMessage());
            return response()->json([
                'status' =>'error',

              ]);
        }

     }
}
