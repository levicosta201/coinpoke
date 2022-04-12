<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pokemon.
 *
 * @package namespace App\Entities;
 */
class LogBuy extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'pokemon_id',
        'experience',
        'coin_price',
        'operation'
    ];

    protected $table = 'log_buy';

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
