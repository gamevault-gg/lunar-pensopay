<?php

namespace Gamevault\Pensopay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gamevault\Pensopay\Pensopay
 */
class Pensopay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamevault\Pensopay\Pensopay::class;
    }
}
