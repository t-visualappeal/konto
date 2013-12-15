# Konto

**Konto** is an application to categorize and display the data from the [Hibiscus Payment-Server](http://www.willuhn.de/products/hibiscus-server/)

## Requirements

* PHP >= 5.3
* NodeJS >= 0.8

## Installation

Set the convig via the `APPLICATION_ENV` environment variable e.g. `development`. Create a directory with the the same name, e.g. `development` in the `app/config` directory. There you can create config files which will merge with the config files in the `app/config` directory. Important is the `database.php` which has to include configurations for the app and hibiscus database server.

```php
<?php
// app/config/development/database.php

return array(
	'connections' => array(
		'app' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'konto',
			'username'  => 'konto_user',
			'password'  => '123456',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'dev_',
		),

		'hibiscus' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'hibiscus',
			'username'  => 'hibiscus_user',
			'password'  => '123456',
			'charset'   => 'utf8',
			'collation' => 'utf8_general_ci',
			'prefix'    => '',
		),
	),
);
```

```php
<?php
// app/config/development/app.php

return array(
	'debug' => true,
	'format' => array(
		'datetime' => 'd.m.Y H:i:s',
		'date' => 'd.m.Y',
	),
	'timezone' => 'UTC',
	'url' => 'http://127.0.0.1/dev/konto/public/',
	'locale' => 'de',
);
```

In the base directory enter `make install` to install some dependencies

* Composer
* NPM Modules
* Bower Modules

locally and migrate the database. Then enter `make` to build the css and javascript files.

## Import Hibiscus Payment-Server data

To import the data from the Hibiscus Payment-Server database enter `php artisan hibiscus:import`. If the Payment-Server is running, it will update it's data from your accounts periodically, so you can create a cronjob to import the data into **Konto** periodically, too.

## Security

At the moment you don't have to login to access **Konto**. Please deny all other requests in your webserver or virtual host configuration!

## Usage

Visit the `public` directory from within your webbrowser to access your accounts and payments.