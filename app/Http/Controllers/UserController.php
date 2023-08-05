<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\UserInterface;
use App\Models\User;

class UserController extends Controller
{
    public $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function index()
    {
        $users = $this->userInterface->index();
        return view('users.index', compact('users'));
    }

    public function activate($id)
    {
        $status = $this->userInterface->change_status($id , 'active');
        return back()->with('success' , 'Activated Successfully');
    }

    public function block($id)
    {
        $status = $this->userInterface->change_status($id , 'blocked');
        return back()->with('success' , 'Blocked Successfully');
    }
}
