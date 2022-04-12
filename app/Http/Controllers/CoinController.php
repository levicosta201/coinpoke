<?php

namespace App\Http\Controllers;

use App\Service\CoinServiceInterface;
use Illuminate\Http\Request;

class CoinController extends Controller
{

    protected $coinService;

    public function __construct(
        CoinServiceInterface $coinService
    )
    {
        $this->coinService = $coinService;
    }

    public function index(Request $request)
    {
        $amountConverted = $this->coinService->satoshiToUsd(1);

        return response()->json([
            'success' => true,
            'data' => [
                'value' => $amountConverted->data->quote->USD,
                'currency' => 'USD'
            ]
        ]);
    }
}
