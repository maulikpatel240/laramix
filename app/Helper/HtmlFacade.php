<?php

namespace App\Helper;
use Illuminate\Support\Facades\Facade;

class HtmlFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'html';
    }
}
