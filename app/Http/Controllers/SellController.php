<?php

namespace App\Http\Controllers;

use App\Service\SellServiceInterface;
use Illuminate\Http\Request;

class SellController extends Controller
{

    protected $sellService;

    public function __construct(
        SellServiceInterface $sellService
    )
    {
        $this->sellService = $sellService;
    }

    public function sell($pokeId)
    {
        $sellPokemon = $this->sellService->sell($pokeId);

        if ($sellPokemon) {
            \Session::put('success', 'Venda efetuada com sucesso.');
            return redirect()->route('home');
        }

        \Session::put('error', 'Falha ao realizar venda.');
        return redirect()->route('home');
    }
}
