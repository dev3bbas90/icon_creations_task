<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\LoginInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginInterface;

    public function __construct(LoginInterface $loginInterface)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->loginInterface = $loginInterface;
    }

    public function login(LoginRequest $request)
    {
        return $this->loginInterface->login($request);
    }

    public function Logout(LogoutRequest $request)
    {
        return $this->loginInterface->logout($request);
    }
}
