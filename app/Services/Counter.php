<?php


namespace App\Services;


use Illuminate\Support\Facades\Cache;

class Counter
{

    private $timeout;

    public function __construct(int $timeout)
    {
        $this->timeout = $timeout;
    }

    public function update(string $key, array $tags = null) : int
    {
        $sessionId = session()->getId();
        $counterKey = $key."-counter";
        $usersKey = $key."-users";

        $users = Cache::tags($tags)->get($usersKey,[]);
        $usersUpdate = [];
        $difference = 0;
        $now = now();
        foreach ($users as $session => $lastVisit)
        {
            if($now->diffInMinutes($lastVisit) >= $this->timeout)
            {
                $difference--;
            }else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >= $this->timeout )
            $difference++;

        $usersUpdate[$sessionId] = $now;
        Cache::tags($tags)->forever($usersKey,$usersUpdate);
        if(!Cache::tags($tags)->has($counterKey))
        {
            Cache::tags($tags)->forever($counterKey,1);
        }else{
            Cache::tags($tags)->increment($counterKey,$difference);
        }

        $counter = Cache::tags($tags)->get($counterKey);

        return $counter;
    }

}
