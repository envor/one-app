<?php

namespace Envor\OneApp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Envor\OneApp\OneApp
 */
class OneApp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Envor\OneApp\OneApp::class;
    }
}
