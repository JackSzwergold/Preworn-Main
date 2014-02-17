# Setting up MAMP & MAMP PRO 2.1.4

## Part 2: Setting up Name-Based Virtual Hosts

This part will be short & sweet, but will also be pretty cool.  It shows you how to use the power of Apache name-based virtual hosts to have more than one base root site served  via your local MAMP install.

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