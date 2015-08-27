<?php namespace Kit\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Sentinel;
use Activation;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class AppInstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installs the application by setting up all the necessary resources.';

	/**
	 * Holds the user information.
	 *
	 * @var array
	 */
	protected $userData = array(
		'first_name' => null,
		'last_name'  => null,
		'email'      => null,
		'password'   => null
	);

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		$this->comment('=====================================');
		$this->comment('');
		$this->info('  Step: 1');
		$this->comment('');
		$this->info('    Please follow the following');
		$this->info('    instructions to create your');
		$this->info('    default user.');
		$this->comment('');
		$this->comment('-------------------------------------');
		$this->comment('');


		// Let's ask the user some questions, shall we?
		$this->askUserFirstName();
		$this->askUserLastName();
		$this->askUserEmail();
		$this->askUserPassword();


		$this->comment('');
		$this->comment('');
		$this->comment('=====================================');
		$this->comment('');
		$this->info('  Step: 2');
		$this->comment('');
		$this->info('    Preparing your Application');
		$this->comment('');
		$this->comment('-------------------------------------');
		$this->comment('');

		// Generate the Application Encryption key
		$this->call('key:generate');

		// Create the migrations table
		$this->call('migrate:install');

		// Publish the packages.
		$this->call('vendor:publish');

		// Run the Migrations
		$this->call('migrate');

		// Create the default user and default groups.
		$this->sentryRunner();

		// Seed the tables with dummy data
		$this->call('db:seed', ['--class' => 'KitDatabaseSeeder']);
		$this->call('db:seed');
	}
	/**
	 * Asks the user for the first name.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserFirstName()
	{
		do
		{
			// Ask the user to input the first name
			$first_name = $this->ask('Please enter your first name: ');

			// Check if the first name is valid
			if ($first_name == '')
			{
				// Return an error message
				$this->error('Your first name is invalid. Please try again.');
			}

			// Store the user first name
			$this->userData['first_name'] = $first_name;
		}
		while( ! $first_name);
	}

	/**
	 * Asks the user for the last name.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserLastName()
	{
		do
		{
			// Ask the user to input the last name
			$last_name = $this->ask('Please enter your last name: ');

			// Check if the last name is valid.
			if ($last_name == '')
			{
				// Return an error message
				$this->error('Your last name is invalid. Please try again.');
			}

			// Store the user last name
			$this->userData['last_name'] = $last_name;
		}
		while( ! $last_name);
	}

	/**
	 * Asks the user for the user email address.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserEmail()
	{
		do
		{
			// Ask the user to input the email address
			$email = $this->ask('Please enter your user email: ');

			// Check if email is valid
			if ($email == '')
			{
				// Return an error message
				$this->error('Email is invalid. Please try again.');
			}

			// Store the email address
			$this->userData['email'] = $email;
		}
		while ( ! $email);
	}

	/**
	 * Asks the user for the user password.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserPassword()
	{
		do
		{
			// Ask the user to input the user password
			$password = $this->ask('Please enter your user password: ');

			// Check if email is valid
			if ($password == '')
			{
				// Return an error message
				$this->error('Password is invalid. Please try again.');
			}

			// Store the password
			$this->userData['password'] = $password;
		}
		while( ! $password);
	}

	/**
	 * Runs all the necessary Sentry commands.
	 *
	 * @return void
	 */
	protected function sentryRunner()
	{
		// Create the default groups
		$this->sentinelCreateDefaultGroups();

		// Create the user
		$this->sentinelCreateUser();
	}

	/**
	 * Creates the default groups.
	 *
	 * @return void
	 */
	protected function sentinelCreateDefaultGroups()
	{
		// Create the admin group
		$group = Sentinel::getRoleRepository()->createModel()->create(array(
			'name'        => 'Admin',
			'slug'			=> 'admin',
			'permissions' => array(
				'admin' => 1,
				'users' => 1
			)
		));

		// Show the success message.
		$this->comment('');
		$this->info('Admin group created successfully.');
	}

	/**
	 * Create the user and associates the admin group to that user.
	 *
	 * @return void
	 */
	protected function sentinelCreateUser()
	{
		// Prepare the user data array.
		$data = array_merge($this->userData, array(
			'permissions' => array(
				'admin' => 1,
				'user'  => 1,
			),
		));

		// Create the user
		$user = Sentinel::getUserRepository()->create($data);

		// Associate the Admin group to this user
		$group = Sentinel::getRoleRepository()->findById(1);
		$group->users()->attach($user);

		// Activate the user
		$activation = Activation::create($user);
		$activation->fill([
            'completed'    => true,
            'completed_at' => Carbon::now(),
        ]);
        $activation->save();

		// Show the success message
		$this->comment('');
		$this->info('Your user was created successfully.');
		$this->comment('');
	}
}
