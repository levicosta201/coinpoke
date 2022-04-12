<?php

namespace App\Repositories;

use App\Entities\LogBuy;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Pokemon;

/**
 * Class PokemonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BuyLogRepositoryEloquent extends BaseRepository implements BuyLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LogBuy::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function saveLog($data)
    {
        return $this->create($data);
    }

    public function getLog()
    {
        return $this->findWhere([
            'user_id' => auth()->user()->id
        ]);
    }

}
