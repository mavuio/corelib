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
       error_reporting(E_ALL ^ E_NOTICE); // Ignores notices and reports all other kinds
       $this->registerCommands();

       $this->app->bindShared('werkzeugh.corelibhelpers', function ($app) {
           return new CorelibHelpers();
       });

       $this->app->bindShared('werkzeugh.ngform', function ($app) {
           return new NgForm();
       });

       // Shortcut so developers don't need to add an Alias in app/config/app.php
       $this->app->booting(function()
       {
           $loader = \Illuminate\Foundation\AliasLoader::getInstance();
           $loader->alias('Core', 'Werkzeugh\Corelib\Facades\CorelibHelpersFacade');
           $loader->alias('NgForm', 'Werkzeugh\Corelib\Facades\NgFormFacade');
           $loader->alias('CarbonDate', 'Carbon\Carbon');
           $loader->alias('Sentry','Cartalyst\Sentry\Facades\Laravel\Sentry');
           //$loader->alias('Clockwork','Clockwork\Support\Laravel\Facade');
       });

       $this->app->register('Way\Generators\GeneratorsServiceProvider');
     //  $this->app->register('Werkzeugh\Corelib\MailServiceProvider');
       //$this->app->register('Clockwork\Support\Laravel\ClockworkServiceProvider');
       $this->app->register('Cartalyst\Sentry\SentryServiceProvider');
       $this->app->register('Mrjuliuss\Syntara\SyntaraServiceProvider');
       $this->app->register('Werkzeugh\Listr\ListrServiceProvider');

   }

    public function boot()
    {
        $this->package('werkzeugh/corelib');

        $this->customizeWhoops($this->app);
        $this->setupLogFiles($this->app);
        $this->setupDbLogging($this->app);
    }

   public function setupLogFiles($app)
   {

    $logFile = 'log.txt';

    \Log::useDailyFiles(storage_path().'/logs/'.$logFile);


    // \Log::listen(function($level, $message, $context) {

    //     // Save the php sapi and date, because the closure needs to be serialized
    //   $apiName = php_sapi_name();
    //   $date = new \DateTime;

    //   \Queue::push(function() use ($level, $message, $context, $apiName, $date){
    //     \DB::insert("INSERT INTO logs (php_sapi_name, level, message, context, created_at) VALUES (?, ?, ?, ?, ?)", array(
    //       $apiName,
    //       $level,
    //       $message,
    //       json_encode($context),
    //       $date
    //       ));
    //   });

    // });

  }





    public function setupDbLogging($app)
    {
        \Event::listen('illuminate.query', function($sql,$bindings)
        {

          if($GLOBALS['debugsql']) { $x=Array($sql,$bindings); $x=(print_r($x,1));echo "\n<li>query: <pre>$x</pre>"; }($sql);
        });

    }


    public function registerCommands()
    {
        $this->app['sqlshell'] = $this->app->share(function ($app) {
            return new Commands\SqlShellCommand($app);
        });
        $this->commands(array('sqlshell'));


        $this->app['sqldump'] = $this->app->share(function ($app) {
            return new Commands\SqlDumpCommand($app);
        });
        $this->commands(array('sqldump'));

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
