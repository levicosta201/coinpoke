<?php

namespace App\Http\Controllers;

use App\Service\PokemonServiceInterface;
use App\Service\WalletServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $pokemonService;
    protected $walletService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PokemonServiceInterface $pokemonService,
        WalletServiceInterface $walletService
    )
    {
        $this->middleware('auth');
        $this->pokemonService = $pokemonService;
        $this->walletService = $walletService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with([
            'pokemons' => $this->pokemonService->getByUserIdBuyed(auth()->user()->id),
            'totalWallet' => $this->walletService->total(),
            'transactions' => $this->walletService->history()
        ]);
    }
}
