<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PokemonRepository.
 *
 * @package namespace App\Repositories;
 */
interface BuyLogRepository extends RepositoryInterface
{
    public function saveLog($data);

    public function getLog();
}
