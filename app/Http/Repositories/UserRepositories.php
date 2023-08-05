<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepositories implements UserInterface
{
    public function index()
    {
        $users = User::withoutGlobalScope('active')->orderByRaw('email asc, id asc')->get();
        return $users;
    }
    public function change_status($user_id , $status = 'active')
    {
        User::withoutGlobalScope('active')->where('id' , $user_id)->update(['status' => $status]);
        return true;
    }
}
