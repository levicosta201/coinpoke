<?php

namespace App\Service;

use Carbon\Carbon;
use CoinMarketCap\Api;

class CoinService implements CoinServiceInterface
{

    protected $coinMarketCap;

    public function __construct()
    {
        $this->coinMarketCap = new Api(env('COIN_API_KEY'));
    }

    public function satoshiToUsd($amount)
    {
        if (!session()->has('satoshiToUsd') || !session()->get('satoshiToUsd')) {
            $amountConverted = $this->coinMarketCap->tools()->priceConversion([
                'amount' => $amount ?? 1,
                'symbol' => 'SATS',
                'convert' => 'USD'
            ]);

            session()->put('satoshiToUsd', $amountConverted);
            return $amountConverted;
        }

        return session()->get('satoshiToUsd');

    }
}