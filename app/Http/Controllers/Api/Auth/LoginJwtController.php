<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginJwtController extends Controller
{
    public function login(Request $request){

        $credentials = $request->only(['email', 'password']);

        if(!$token = auth('api')->attempt($credentials)){ //Usando o JWT para tentar autenticar o usuário //Se o usuário não conseguir se autenticar
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessege(), 401);
        }

        return response()->json([
            'token' => $token
        ]);

    }

    public function logout(){
        auth('api')->logout();

        return response()->json(['message' => 'Logout successfully!'], 200);
    }

    public function refresh(){
        $token = auth('api')->refresh();

        return response()->json([
            'token' => $token
        ]);
    }
}
