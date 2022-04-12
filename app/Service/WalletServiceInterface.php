<?php

namespace App\Service;

interface WalletServiceInterface
{
    public function total();

    public function history();
}