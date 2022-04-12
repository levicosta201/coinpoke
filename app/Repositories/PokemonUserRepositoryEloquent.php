<?php

namespace App\Repositories;

use App\Entities\PokemonUser;
use Illuminate\Support\Facades\DB;
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

    public function getToalExpByUserId()
    {
        return DB::select("
            SELECT 
                SUM(p.base_experience) as total_experience
            FROM
                pokemons_user pu
            INNER JOIN pokemons p
                ON pu.pokemon_id = p.id
            WHERE
                pu.user_id = ". auth()->user()->id .";
        ");
    }

}
