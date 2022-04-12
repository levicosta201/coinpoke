<?php

namespace App\Http\Controllers;

use App\Service\PokemonServiceInterface;
use Illuminate\Http\Request;

class PokemonController extends Controller
{

    protected $pokemonService;

    public function __construct(
        PokemonServiceInterface $pokemonService
    )
    {
        $this->pokemonService = $pokemonService;
    }

    public function get()
    {
        return response()->json($this->pokemonService->getAllPokemons());
    }
}
