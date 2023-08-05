<?php
namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface LoginInterface
{
    public function register(Request $request);
    public function login(Request $request);
    public function logout(Request $request);
}
