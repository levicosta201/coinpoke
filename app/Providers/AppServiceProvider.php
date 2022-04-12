<?php

namespace App\Providers;

use App\Repositories\PokemonRepositoryEloquent;
use App\Repositories\PokemonUserRepository;
use App\Repositories\PokemonUserRepositoryEloquent;
use App\Repositories\PokemoRepository;
use App\Service\CoinService;
use App\Service\CoinServiceInterface;
use App\Service\PokemonService;
use App\Service\PokemonServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PokemoRepository::class,
            PokemonRepositoryEloquent::class
        );

        $this->app->bind(
            PokemonServiceInterface::class,
            PokemonService::class
        );

        $this->app->bind(
            CoinServiceInterface::class,
            CoinService::class
        );

        $this->app->bind(
            PokemonUserRepository::class,
            PokemonUserRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
