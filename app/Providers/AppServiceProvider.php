<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    PlayerRepositoryInterface,
    PlayerSkillRepositoryInterface
};
use App\Repositories\Eloquent\{
    PlayerEloquentORM,
    PlayerSkillEloquentORM
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PlayerRepositoryInterface::class, PlayerEloquentORM::class);
        $this->app->bind(PlayerSkillRepositoryInterface::class, PlayerSkillEloquentORM::class);
    }
}
