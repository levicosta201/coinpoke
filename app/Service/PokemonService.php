<?php

namespace App\Service;

use App\Repositories\PokemonUserRepository;
use App\Repositories\PokemoRepository;
use GuzzleHttp\Client;

class PokemonService implements PokemonServiceInterface
{
    protected $client;
    protected $results = [];
    protected $next = null;
    protected $pokemonRepository;
    protected $pokemonUserRepository;

    public function __construct(
        PokemoRepository $pokemoRepository,
        PokemonUserRepository $pokemonUserRepository
    )
    {
        $this->client = new Client();
        $this->pokemonRepository = $pokemoRepository;
        $this->pokemonUserRepository = $pokemonUserRepository;
    }

    public function getAllPokemons()
    {
        $getPokemon = $this->client->get($this->next ?? 'https://pokeapi.co/api/v2/pokemon/');
        $response = json_decode($getPokemon->getBody()->getContents());

        foreach ($response->results as $result) {
            $getPokemonData = $this->client->get($result->url);
            $responsePokemonData = json_decode($getPokemonData->getBody()->getContents());

            $this->results[] = [
                'name' => $result->name,
                'url' => $result->url,
                'base_experience' => $responsePokemonData->base_experience,
                'image' => $responsePokemonData->sprites->front_default ?? '#'
            ];

        }

        if (isset($response->count) && $response->count > 0) {
            if (isset($response->next) && $response->next !== '') {
                $this->next = $response->next;
                $this->getAllPokemons();
            }
        }

        $this->storePokemons($this->results);
        return $this->results;
    }

    public function listPokemons()
    {
        return $this->pokemonRepository->orderBy('base_experience', 'DESC')->paginate('100');
    }

    public function getByUserIdBuyed(int $userId)
    {
        return $this->pokemonUserRepository->findWhere([
            'user_id' => $userId
        ], '*');
    }

    protected function storePokemons($pokemons)
    {
        foreach ($pokemons as $pokemon) {
            $this->pokemonRepository->updateOrCreate($pokemon, [
                'name' => $pokemon['name']
            ]);
        }
    }
}