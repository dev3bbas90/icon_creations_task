<?php
namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function index();
    public function change_status(int $user_id , string $status = 'active');
}
