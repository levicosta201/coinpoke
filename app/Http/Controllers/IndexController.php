<?php

namespace App\Http\Controllers;

use App\Service\PokemonServiceInterface;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    protected $pokemonService;

    public function __construct(
        PokemonServiceInterface $pokemonService
    )
    {
        $this->pokemonService = $pokemonService;
    }

    public function index()
    {
        return view('welcome')->with([
            'pokemons' => $this->pokemonService->listPokemons()
        ]);
    }
}
