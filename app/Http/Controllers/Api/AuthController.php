<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AuthRequest;
use App\Repositories\Api\AuthRepository;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthRepository $authRepository){
        $this->auth = $authRepository;
    }

    public function login(AuthRequest $request){
        return $this->auth->login($request);
    }

    public function verify(Request $request){
        return $this->auth->verify($request);
    }

    public function logout(Request $request){
        return $this->auth->logout($request);
    }
}
