<?php

namespace App\Observers;

use App\Entities\PokemonUser;
use App\Repositories\BuyLogRepository;
use App\Repositories\PokemonUserRepository;
use App\Service\CoinServiceInterface;

class PokemonUserObserver
{

    protected $buyLogReository;
    protected $coinService;

    public function __construct(
        BuyLogRepository $buyLogReository,
        CoinServiceInterface $coinService
    )
    {
        $this->buyLogReository = $buyLogReository;
        $this->coinService = $coinService;
    }

    /**
     * Handle the post "created" event.
     *
     * @param  PokemonUser $pokemonUser
     * @return void
     */
    public function created(PokemonUser $pokemonUser)
    {
        $this->saveLog($pokemonUser, 'buy');
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  PokemonUser $pokemonUser
     * @return void
     */
    public function deleted(PokemonUser $pokemonUser)
    {
        $this->saveLog($pokemonUser, 'sell');
    }

    protected function saveLog(PokemonUser $pokemonUser, string $operation)
    {
        $satoshiToUsd = $this->coinService->satoshiToUsd(1);
        $this->buyLogReository->saveLog([
            'user_id' => $pokemonUser->user_id,
            'pokemon_id' => $pokemonUser->pokemon_id,
            'experience' => $pokemonUser->pokemon->base_experience,
            'coin_price' => $satoshiToUsd->data->quote->USD->price,
            'operation' => $operation
        ]);
    }
}
