<?php

namespace App\Service;

interface CoinServiceInterface
{
    public function satoshiToUsd($amount);
}