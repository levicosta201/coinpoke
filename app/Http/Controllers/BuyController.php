<?php

namespace App\Http\Controllers;

use App\Service\BuyServiceInterface;
use Illuminate\Http\Request;

class BuyController extends Controller
{

    protected $buyService;

    public function __construct(
        BuyServiceInterface $buyService
    )
    {
        $this->buyService = $buyService;
    }

    public function buy($pokeId)
    {
        $buyPokemon = $this->buyService->buy($pokeId);

        if ($buyPokemon) {
            \Session::put('success', 'Compra efetuada com sucesso.');
            return redirect()->route('home');
        }

        \Session::put('error', 'Falha ao realizar compra.');
        return redirect()->route('home');
    }
}
