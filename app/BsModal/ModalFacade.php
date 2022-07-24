<?php

namespace App\BsModal;
use Illuminate\Support\Facades\Facade;

class ModalFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'modal';
    }
}
