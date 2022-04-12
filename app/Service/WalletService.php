<?php

namespace App\Service;

use App\Repositories\BuyLogRepository;
use App\Repositories\PokemonUserRepository;

class WalletService implements WalletServiceInterface
{
    protected $pokemonUserRepository;
    protected $coinService;
    protected $buyLogRepository;

    public function __construct(
        PokemonUserRepository $pokemonUserRepository,
        CoinServiceInterface $coinService,
        BuyLogRepository $buyLogRepository
    )
    {
        $this->pokemonUserRepository = $pokemonUserRepository;
        $this->coinService = $coinService;
        $this->buyLogRepository = $buyLogRepository;
    }

    public function total()
    {
        $satoshiToUsd = $this->coinService->satoshiToUsd(1);
        $totalExperienceBuyed = $this->pokemonUserRepository->getToalExpByUserId();

        return ($totalExperienceBuyed[0]->total_experience * $satoshiToUsd->data->quote->USD->price);
    }

    public function history()
    {
        return $this->buyLogRepository->getLog();
    }
}
