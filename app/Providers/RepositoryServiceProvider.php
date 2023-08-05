<?php

namespace App\Providers;

use App\Http\Interfaces\LoginInterface;
use App\Http\Interfaces\UserInterface;
use App\Http\Repositories\LoginRepositories;
use App\Http\Repositories\UserRepositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoginInterface::class,LoginRepositories::class);
        $this->app->bind(UserInterface::class,UserRepositories::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
