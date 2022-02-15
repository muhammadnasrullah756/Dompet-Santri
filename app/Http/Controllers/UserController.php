<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
Use App\User;

class UserController extends BaseController
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Login Failed', 422, $validator->errors());
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
           $user = Auth::user();

           $response = [
               'token' => $user->createToken('authToken')->plainTextToken,
               'name' => $user->name
           ];

           return $this->responseOk($response);
       } else {
           return $this->responseError('Wrong Email or Password', 401);
       }
    }

    public function register(Request $request) {
        $validator= Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|confirmed',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Please Fill All Required Fields', 422, $validator->errors());
        }

        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'roles' => $request->roles,
        ];

        if ($user = User::create($params)) {
            $token = $user->createToken('authToken')->plainTextToken;

            $response = [
                'token' => $token,
                'token_type' => 'bearer',
                'user' => $user
            ];
            return $this->responseOk($response);
        } else {
            return $this->responseError('Registration Failed', 400);
        }
    }
}
