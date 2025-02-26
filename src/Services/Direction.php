<?php

namespace Director\Services;

use Director\Accessible;
use Illuminate\Support\Facades\Facade;

class Direction extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return Accessible::class;
    }
}