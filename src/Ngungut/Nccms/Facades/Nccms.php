<?php namespace Ngungut\Nccms\Facades;

use Illuminate\Support\Facades\Facade;

class Nccms extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'nccms'; }

}