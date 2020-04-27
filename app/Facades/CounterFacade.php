<?php


namespace App\Facades;
use Illuminate\Support\Facades\Facade;


/**
 * Class CounterFacade
 * @package App\Facades
 * @method static int update(string $key, array $tags=null)
 */
class CounterFacade extends Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'App\Contracts\CounterContract';
    }

}
