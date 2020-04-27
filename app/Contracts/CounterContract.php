<?php

namespace App\Contracts;

interface  CounterContract
{

    public function update(string $key, array $tags = null) : int;

}
