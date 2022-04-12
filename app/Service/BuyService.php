<?php

namespace App\Service;

use App\Repositories\PokemonUserRepository;

class BuyService implements BuyServiceInterface
{

    protected $pokemonUserRepository;

    public function __construct(
        PokemonUserRepository $pokemonUserRepository
    )
    {
        $this->pokemonUserRepository = $pokemonUserRepository;
    }

    public function buy($pokemonId)
    {
        return $this->pokemonUserRepository->create([
            'pokemon_id' => $pokemonId,
            'user_id' => auth()->user()->id
        ]);
    }
}