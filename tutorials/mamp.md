# Setting up MAMP & MAMP PRO 2.1.4

## Part 1: Setting Up a Basic, Useful MAMP Environment

Before anything else, you need to figure out which version of the PHP ini configuration file—commonly refered to as *php.ini*—your setup is using. For this example, I am using PHP version 5.4.10 which is part of the standard MAMP 2.1.4 install.

You can determine which version of PHP is being used by looking through the output of [phpinfo()](http://us3.php.net/phpinfo) which is easily done in MAMP by choosing *phpInfo* item from the menu of the main MAMP page:

	http://localhost:8888/MAMP/

Or you can just get to it directly via this URL:

	http://localhost:8888/MAMP/phpinfo.php

Once you figure out which PHP ini configuration file you are using, you can then edit the config file like so. I like to use [BBEdit](http://www.barebones.com/products/bbedit/), so this is how I call it from the command line:

	bbedit /Applications/MAMP/bin/php/php5.4.10/conf/php.ini

That will open BBEdit via the command line & open the *php.ini* at the same time. Or if you are more comfortable doing it all in the command line, you can open the file with [GNU nano](http://www.nano-editor.org)—the command line editor I like to use which comes with all Mac OS X installs—like so:

	nano /Applications/MAMP/bin/php/php5.4.10/conf/php.ini

Whatever editor you coose to use is not important. So don’t feel tied to my examples of BBEdit and GNU nano. You’re ultmate goal is to simply edit a text file to change configuration values. But you should be comfortable with whatever text editor you use.

### Changing the PHP install time zone.

Out of the box, MAMP 2.1.4 is compiled to the original development team’s timezone of *Europe/Berlin* like so:

	date.timezone = "Europe/Berlin"

Unless you are actually in Berlin—or have a need to have your time zone set to Berlin—the `date.timezone` value should be changed to whatever your actual working time zone actually is like so:

	; date.timezone = "Europe/Berlin"
	date.timezone = "America/New_York"

Also, as you can see, I like to comment out changes that I make & leave them in place insetad of deleting them. In a case like this it might seem superflous. But in general, you should get into the habit of commenting out small tweaks like this.

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


## Part 3: Installing the PHP Pear Library for MAMP

Now we'll install the whole PHP Pear library under MAMP. Yes, the whole library. Why? Easy. Because when I use MAMP for a test environment, I often deal with developers or  projects that make use of PEAR. And I don’t have the time to really install individual Pear items via the command line each time I launch MAMP. Much better to just install them all & just develop.

