<?php

namespace App\Service;

use App\Entities\PokemonUser;
use App\Repositories\PokemonUserRepository;

class SellService implements SellServiceInterface
{

    protected $pokemonUserRepository;

    public function __construct(
        PokemonUserRepository $pokemonUserRepository
    )
    {
        $this->pokemonUserRepository = $pokemonUserRepository;
    }

    public function sell($pokemonId)
    {
        $pokemonUser = PokemonUser::where('pokemon_id', $pokemonId)
            ->where('user_id', auth()->user()->id)->first();

        return $pokemonUser->delete();
    }
}