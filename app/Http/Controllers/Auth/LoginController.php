<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\LoginInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $loginInterface;
    public function __construct(LoginInterface $loginInterface)
    {
        $this->loginInterface = $loginInterface;
    }

    public function login(Request $request)
    {
        return $this->loginInterface->login($request);
    }

    public function createUser(UserRequest $request)
    {
        return $this->loginInterface->register($request);
    }

    public function loginUser(LoginRequest $request)
    {
        return $this->loginInterface->login($request);
    }

    public function LogoutUser(Request $request)
    {
        return $this->loginInterface->logout($request);
    }

}
