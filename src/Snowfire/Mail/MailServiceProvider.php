<?php namespace Snowfire\Mail;

use Openbuildings\Postmark\Swift_PostmarkTransport;

class MailServiceProvider extends \Illuminate\Mail\MailServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('snowfire/mail');
	}

	/**
	 * Register the Swift Transport instance.
	 *
	 * @param  array  $config
	 * @return void
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function registerSwiftTransport($config)
	{
		switch ($config['driver'])
		{
			case 'smtp':
				return $this->registerSmtpTransport($config);

			case 'sendmail':
				return $this->registerSendmailTransport($config);

			case 'mail':
				return $this->registerMailTransport($config);

			case 'mailgun':
				return $this->registerMailgunTransport($config);

			case 'mandrill':
				return $this->registerMandrillTransport($config);

			case 'postmark':
				return $this->registerPostmarkTransport($config);

			case 'log':
				return $this->registerLogTransport($config);

			default:
				throw new \InvalidArgumentException('Invalid mail driver.');
		}
	}

	/**
	 * Register the Postmark Swift Transport instance.
	 *
	 * @param  array  $config
	 * @return void
	 */
	protected function registerPostmarkTransport($config)
	{
		$postmark = $this->app['config']->get('services.postmark', array());

		$this->app->bindShared('swift.transport', function() use ($postmark)
		{
			return new Swift_PostmarkTransport($postmark['api_key']);
		});
	}

}
