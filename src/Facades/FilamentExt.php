<?php

namespace Joy2fun\FilamentExt\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Joy2fun\FilamentExt\FilamentExt
 */
class FilamentExt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Joy2fun\FilamentExt\FilamentExt::class;
    }
}
