<?php

namespace Succinct\Chronos;

class Time extends Chronos
{
    public function __construct($date)
    {
        $this->resolve($date)
    }
}
