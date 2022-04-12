<?php

namespace App\Service;

use GuzzleHttp\Client;

interface PokemonServiceInterface
{
    public function getAllPokemons();

    public function listPokemons();

    public function getByUserIdBuyed(int $userId);
}