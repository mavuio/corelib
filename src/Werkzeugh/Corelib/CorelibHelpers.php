<?php namespace Werkzeugh\Corelib;



class CorelibHelpers
{

    public function dash_case($str)
    {
        return str_replace('_','-',snake_case($str));
    }

}