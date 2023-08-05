<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name"      =>  "Active User",
            "email"     =>  "user@user",
            "password"      =>  bcrypt('123456'),
            "status"        =>  "active",
        ]);
        User::create([
            "name"      =>  "Blocked User",
            "email"     =>  "block@user",
            "password"      =>  bcrypt('123456'),
            "status"        =>  "blocked",
        ]);
    }
}
