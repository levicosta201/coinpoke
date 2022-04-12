<?php

namespace App\Providers;

use App\Entities\PokemonUser;
use App\Observers\PokemonUserObserver;
use App\Repositories\BuyLogRepository;
use App\Repositories\BuyLogRepositoryEloquent;
use App\Repositories\PokemonRepositoryEloquent;
use App\Repositories\PokemonUserRepository;
use App\Repositories\PokemonUserRepositoryEloquent;
use App\Repositories\PokemoRepository;
use App\Service\BuyService;
use App\Service\BuyServiceInterface;
use App\Service\CoinService;
use App\Service\CoinServiceInterface;
use App\Service\PokemonService;
use App\Service\PokemonServiceInterface;
use App\Service\SellService;
use App\Service\SellServiceInterface;
use App\Service\WalletService;
use App\Service\WalletServiceInterface;
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

        $this->app->bind(
            BuyServiceInterface::class,
            BuyService::class
        );

        $this->app->bind(
            WalletServiceInterface::class,
            WalletService::class
        );

        $this->app->bind(
            SellServiceInterface::class,
            SellService::class
        );

        $this->app->bind(
            BuyLogRepository::class,
            BuyLogRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PokemonUser::observe(PokemonUserObserver::class);
    }
}
