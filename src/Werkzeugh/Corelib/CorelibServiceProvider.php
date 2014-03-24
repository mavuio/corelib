<?php namespace Werkzeugh\Corelib;

use Illuminate\Support\ServiceProvider;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;


class CorelibServiceProvider extends ServiceProvider
{

       /**
	   * Indicates if loading of the provider is deferred.
	   *
	   * @var bool
	   */
       protected $defer = false;

       /**
	   * Register the service provider.
	   *
	   * @return void
	   */
   public function register()
   {
       $this->registerSqlShellCommand();
       error_reporting(E_ALL ^ E_NOTICE); // Ignores notices and reports all other kinds

       $this->app->bindShared('werkzeugh.corelibhelpers', function ($app) {
           return new CorelibHelpers();
       });

       // Shortcut so developers don't need to add an Alias in app/config/app.php
       $this->app->booting(function()
       {
           $loader = \Illuminate\Foundation\AliasLoader::getInstance();
           $loader->alias('Core', 'Werkzeugh\Corelib\Facades\CorelibHelpersFacade');
       });


   }
    
    public function boot()
    {
        $this->customizeWhoops($this->app);

    }
    

    public function registerSqlShellCommand()
    {
        $this->app['sqlshell'] = $this->app->share(function ($app) {
            return new Commands\SqlShellCommand($app);
        });
        $this->commands(array('sqlshell'));
    }

       /**
	   * Get the services provided by the provider.
	   *
	   * @return array
	   */
    public function provides()
    {
        return array();
    }
    
    public function customizeWhoops($app)
    {
        if($app->bound("whoops")) {
            $whoopsDisplayHandler = $app->make("whoops.handler");

            if($whoopsDisplayHandler instanceof JsonResponseHandler) {

                $app['whoops.handler'] = $app->share(function()
                {
                    return new PrettyPageHandler;
                });

            }

             $whoopsDisplayHandler = $app->make("whoops.handler");
             
            if($whoopsDisplayHandler instanceof PrettyPageHandler) {
                
                // $whoopsDisplayHandler->setEditor("textmate");
                $whoopsDisplayHandler->setResourcesPath( __DIR__ . '/Resources/Whoops');
            }
        }
    }
    
    
}
