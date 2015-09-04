#Laravel5 Starter Kit
===============================
This is abstract laravel 5 application that is ported from version 4.x for easy of use. It comes with basic authentication developed with Sentry library and basic Admin Panel

Developed by Brunogaspar (4.0.x) and since then maintained by me till now. 

I will continue supporting this package for atleast next couple of years until I change here.

Feel free to ping me anytime for support at dakshhmehta@gmail.com


### Installation
Execute the following command on terminal

```bash
composer require dakshhmehta/laravel-starter-kit
```
In order to instal this package, just like other package you install - add a service provider in an array of service provider by editing file config/app.php

```bash
'Kit\Providers\KitServiceProvider'
```

Additional to that, the package utilize the Sentinel and therefore add service provider and alias of the same as well. You can [follow this](https://cartalyst.com/manual/sentinel/2.0#installation) to install.

The Kit comes with installation command that does all the job you need to perform while setting up a new project. But before that, prepare the database and an enviorment file to get started and execute following command on terminal.

```bash
php artisan app:install
```

This will start the installation wizard to complete. On completion, the application is ready.

The application's login page can be accessible from the following URL:
```
http://localhost/public/authenticate/signin
```

Login with the email address and the password you entered in the installation wizard.


# Optionally,
The laravel 5 comes with Authenticate middleware that points to it's own login page, that you might want to change to kit's log in page.

You can do so by editing app/Http/Kernel.php

Find the following near around line #43
```bash
	'auth' => 'App\Http\Middleware\Authenticate',
```
and update with
```bash
	'auth' => 'Kit\Http\Middlewares\Authenticate',
```

That's it!
Have fun.
