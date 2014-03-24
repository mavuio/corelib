<?php namespace Werkzeugh\Corelib\Facades;


use Illuminate\Support\Facades\Facade;

class CorelibHelpersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'werkzeugh.corelibhelpers';
    }
}
