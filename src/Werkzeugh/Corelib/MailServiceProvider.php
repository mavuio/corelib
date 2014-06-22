<?php namespace Werkzeugh\Corelib;

use Werkzeugh\Corelib\CorelibSwiftMailer;
use Illuminate\Support\ServiceProvider;
use Swift_SmtpTransport as SmtpTransport;
use Swift_MailTransport as MailTransport;
use Swift_SendmailTransport as SendmailTransport;
use Illuminate\Mail\Mailer;


// copied from  Illuminate\Mail\MailServiceProvider

class MailServiceProvider extends \Illuminate\Mail\MailServiceProvider {


	/**
	 * Register the Swift Mailer instance.
	 *
	 * @return void
	 */
	public function registerSwiftMailer()
	{
		$config = $this->app['config']['mail'];

		$this->registerSwiftTransport($config);

		// Once we have the transporter registered, we will register the actual Swift
		// mailer instance, passing in the transport instances, which allows us to
		// override this transporter instances during app start-up if necessary.
		$this->app['swift.mailer'] = $this->app->share(function($app)
		{
			return new CorelibSwiftMailer($app['swift.transport']);
		});
	}


}
