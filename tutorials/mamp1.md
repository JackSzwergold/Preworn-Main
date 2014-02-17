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

Also, as you can see, I like to comment out changes that I make & leave them in place insetad of deleting them. In general, you should get into the habit of commenting out small tweaks like this & leaving them in place for future reference instead of ouright overwritung or deleting them. In a case like this it might seem superflous, but remember: What might seem like a simple change now, might be the cause of a debugging issue months or years from now.

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
