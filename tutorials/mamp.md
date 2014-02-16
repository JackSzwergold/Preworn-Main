# Setting up MAMP & MAMP PRO 2.1.4

## Part 1: Setting Up a Basic, Useful MAMP Environment

Before anything else, you need to figure out which version of the PHP ini file (php.ini) you are using. For this example, I am using PHP version 5.4.10 which is part of the standard MAMP 2.1.4 install.

You can easily determine which version of PHP is being used by choosing “phpInfo” from the main MAMP start page:

	http://localhost:8888/MAMP/

Or you can just go here:

	http://localhost:8888/MAMP/phpinfo.php

Once you install it, edit the config file:

	bedit /Applications/MAMP/bin/php/php5.4.10/conf/php.ini


### Changing the PHP install time zone.

It is set to this.

	date.timezone = "Europe/Berlin"

Unless you are in Berlin, this should be changed to whatever your actual time zone is.

	; date.timezone = "Europe/Berlin"
	; date.timezone = "US/Eastern"
	date.timezone = "America/New_York"


### Adjusting resource limits & error reporting.

In general, the simplest resource limit adjustment you should make is to 'memory_limit'.

	max_execution_time = 30     ; Maximum execution time of each script, in seconds
	max_input_time = 60	; Maximum amount of time each script may spend parsing request data
	memory_limit = 32M      ; Maximum amount of memory a script may consume (8MB)

Change 'memory_limit' to something like 64M

	; memory_limit = 32M      ; Maximum amount of memory a script may consume (8MB)
	memory_limit = 64M      ; Maximum amount of memory a script may consume (8MB)


Adjusting 'error_reporting' so you don’t go nuts when debugging.

	error_reporting = E_ALL

I generally change that to be anything but 'strict' notices.

	; error_reporting = E_ALL
	error_reporting = E_ALL & ~E_STRICT


Adjusting 'display_errors' to 'On' so you can actually see errors in the browser.

	display_errors = Off

Not much else to say about that.

	; display_errors = Off
	display_errors = On


Now with all that done, restart MAMP & then edit the main index.php file on the page.

	bbedit /Applications/MAMP/htdocs/index.php

	<?php

	echo "Hello world!";

	?>

And now you’re done setting up your basic MAMP setup!

## Part 2: Setting up Name-Based Virtual Hosts

This part will be short & sweet, but will also be pretty cool.  It shows you how to use 
the power of Apache name-based virtual hosts to have more than one base root site served 
via your local MAMP install.

You can read up on Name-based virtual hosts here:

	http://httpd.apache.org/docs/2.2/vhosts/name-based.html

First determine what your local machine’s hostname is by going to the command line & typing 'hostname' like so.

	hostname

Now make note of the hostname, which is something like 'microman.local'

Now, create a new directory inside the main MAMP htdocs called 'test_host'…

	mkdir /Applications/MAMP/htdocs/test_host

And now create an index file in that directory.

	bbedit /Applications/MAMP/htdocs/index.php

	<?php

	echo "Hello world! I am the root of a name-based virtual host.";

	?>

Okay with that done, add these lines to the bottom of your Apache 'httpd.conf' like so.

	bbedit /Applications/MAMP/conf/apache/httpd.conf

	NameVirtualHost *

	<VirtualHost *>
	  DocumentRoot "/Applications/MAMP/htdocs"
	  ServerName localhost
	  ServerAlias localhost
	</VirtualHost>

	<VirtualHost *>
	  DocumentRoot "/Applications/MAMP/htdocs/test_host"
	  ServerName *.local
	  ServerAlias *.local
	</VirtualHost>

Now restart MAMP and go to this URL.

	http://microman.local:8888

And compare to the basic 'localhost' setup URL.

	http://microman.local:8888

The index page you created previously should now be loaded. What’s happing now is thanks to the flexibility of name-based virtual hosts, Apache essentially sees 'microman.local:8888' & 'localhost:8888' as two distinct web servers.


### Part 3: Installing the PHP Pear Library for MAMP

Now we'll install the whole PHP Pear library under MAMP. Yes, the whole library. Why? Easy. Because when I use MAMP for a test environment, I often deal with developers or  projects that make use of PEAR. And I don’t have the time to really install individual Pear items via the command line each time I launch MAMP. Much better to just install them all & just develop.

