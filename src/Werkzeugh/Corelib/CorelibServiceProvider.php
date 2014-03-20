<?php namespace Werkzeugh\Corelib;

use Illuminate\Support\ServiceProvider;

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
}
