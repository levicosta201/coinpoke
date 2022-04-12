<?php

namespace App\Http\Controllers;

use App\Service\PokemonServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $pokemonService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PokemonServiceInterface $pokemonService
    )
    {
        $this->middleware('auth');
        $this->pokemonService = $pokemonService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with([
            'pokemons' => $this->pokemonService->getByUserIdBuyed(auth()->user()->id)
        ]);
    }
}
