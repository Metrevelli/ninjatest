<?php

namespace App\Providers;

use App\Repositories\Contracts\UsersRepositoryContract;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    private const REPOSITORIES =[
        UsersRepositoryContract::class => UsersRepository::class
    ];

    public function register(): void
    {
        foreach (self::REPOSITORIES as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
