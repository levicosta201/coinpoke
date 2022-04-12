<?php

namespace App\Repositories;

use App\Entities\PokemonUser;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Pokemon;

/**
 * Class PokemonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PokemonUserRepositoryEloquent extends BaseRepository implements PokemonUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PokemonUser::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
