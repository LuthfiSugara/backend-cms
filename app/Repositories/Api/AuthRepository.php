<?php

namespace App\Repositories\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PersonalAccessToken;

class AuthRepository {
    public function login($data){
        try{
            $user = User::where('email', $data->email)->first();
            if(!$user){
                return response()->json([
                    'status' => 'fail',
                    'message' => 'email is not registered!'
                ], 403);
            }else{
                if($user && Hash::check($data->password, $user->password)){
                    $deleteToken = PersonalAccessToken::where('tokenable_id', $user->id)->delete();
                    $token = $user->createToken($data->device_name)->plainTextToken;

                    return response()->json([
                        'status' => 'success',
                        'token' => $token,
                        'data' => $user,
                        'message' => 'success'
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Wrong email or password!'
                    ], 403);
                }
            }

        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function verify(){
        try{
            $isVerify = auth('sanctum')->check();

            if($isVerify){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Authorized'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Unauthorized!'
                ], 401);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function logout(){
        try{
            $user = auth('sanctum')->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

            if($user){
                return response()->json([
                    'status' => 'success',
                    'message' => 'logout Success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Failed to logout'
                ], 403);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }
}