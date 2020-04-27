<?php


namespace App\Services;


use App\Contracts\CounterContract;

class DummyCounter implements CounterContract
{


    public function update(string $key, array $tags = null): int
    {
        dump('I am a dummy counter not implemented yet');
        return 0;
    }
}
