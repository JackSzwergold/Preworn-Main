# Using an Ubuntu Linux Server

Written by [Jack Szwergold][1] on March 22, 2014

## Part 2: Setting Up a LAMP Stack

So in part 1 of my tutorial, I explained how I like to configure a base level Ubuntu server. In part 2 of my tutorial I will explain how to setup useful & solid LAMP stack that can be used as a production server or a development/sandbox server for web development needs.

### Install ‘apache’ & some basic ‘php’ stuff.

First, let’s install the core of the `apache` & `php` related stuff.

    sudo aptitude install apache2 apache2-threaded-dev php5 libapache2-mod-php5 php-pear

This is a fairly simple set of items that will be installed. `apache2` and `apache2-threaded-dev` are required for basic `apache` functionality. While `php5` and `libapache2-mod-php5` are required for basic `php` functionality on your system. The `php-pear` install is to allow you to do package installs from the `php` extension & application repository, aka: `pear`.

### Install the ‘php’ modules.

Now let’s install a basic set of `php` modules.

    sudo aptitude install php5-mysql php5-pgsql php5-odbc php5-sybase php5-sqlite php5-xmlrpc php5-json php5-xsl php5-curl php5-geoip php-getid3 php5-imap php5-ldap php5-mcrypt php5-pspell php5-gmp php5-gd

I am not going to do a deep breakdown of each module, but from my experience this is the most basic, complete and useful set of `php` modules most any web developer will be using.

### Harden the ‘php’ install.

With that done, let’s “harden” the `php` install by disabling `expose_php`. You want to do harden the install to prevent exposing your server to hacking scripts & other unwanted intrusions:

    sudo nano /etc/php5/apache2/php.ini

Now do a search for `expose_php` and change that setting to `Off`:

    expose_php = Off

### Harden the ‘apache’ install.

Now let’s “harden” the `apache` install by adjusting the values of `ServerTokens`, `ServerSignature` & `TraceEnable`. You want to do harden the install to prevent exposing your server to hacking scripts & other unwanted intrusions. First, open up the main `apache` security configuration file:

    sudo nano /etc/apache2/conf.d/security
    
First, locate `ServerTokens` and set it to the “production” value:

    ServerTokens Prod

Now, locate `ServerSignature` and disable that as well if it isn’t disabled already:

    ServerSignature Off

Locate `TraceEnable` and disable that as well if it isn’t disabled already:

    TraceEnable Off

### Set the default ‘apache’ config.

Now, while `apache` already has a decent `default` config in place, I find it to be excessive & confusing for my purposes. First, open up the `apache` `default` config file like this:

    sudo nano /etc/apache2/sites-available/default

And then replace the contents with the following basic `apache` config I like to use as a `default`:


    <VirtualHost *:80>
      DocumentRoot /var/www

      CustomLog ${APACHE_LOG_DIR}/access.log combined
      ErrorLog ${APACHE_LOG_DIR}/error.log

      # Possible values include: debug, info, notice, warn, error, crit, alert, emerg.
      LogLevel warn

      Alias /phpmyadmin /usr/share/phpmyadmin/
      Alias /munin /var/cache/munin/www

      RedirectMatch 404 /(builds|configs|content)(/|$)

      # Including common items in a common file for ssl & non-ssl.
      # include /etc/apache2/sites-available/common.conf

      # Including common ModSecurity related items.
      # include /etc/apache2/sites-available/common_mod_security.conf

    </VirtualHost>

Note the commented out entries for including the contents of `common.conf` and `common_mod_security.conf` in the config. We’re not going to address those just yet, but those “common” files are there to make the job of including commonly used basic config & security settings easier.

### Set a nicer default ‘php’-based index file instead of the standard “It works!” index file.

And in a similar vein, `apache` installs a default “It works!” page in `index.html` that is fairly useless & problematic from a security standpoint. So let’s get rid of that file like this:

    sudo rm /var/www/index.html

And replace it with a new `php`-based `index.php` file:

    sudo nano /var/www/index.php

    <?php

    # phpinfo();
    # header('Location: http://www.preworn.com/');
    echo $_SERVER['SERVER_NAME'];
    # echo '<br />';
    # echo $_SERVER['SERVER_ADDR'];

    ?>

If you look at the contents of the new `php` file, you see most of the items are commented out. But this is basically the small set of commands I find useful to have at my disposal when setting up a server. The default command I like to set is the `echo $_SERVER['SERVER_NAME'];` which returns the domain or IP address used to connect to the server. It’s very useful for setting up—and debugging—Apache virtual host setups.

### Enable ‘apache’ modules.

Now enable some basic `apache` modules if they are not enabled already:

    sudo a2enmod rewrite headers include proxy proxy_http
    
### Adjust ‘apache’ config to allow group ‘www-readwrite’ access.

Setting Apache2 `umask` in Ubuntu & other Debian setups:

    sudo nano /etc/apache2/envvars

Append this to the end of the file:

    umask 002

Also, in `/etc/apache2/envvars` change the `APACHE_RUN_GROUP` group to `www-readwrite`:

    # export APACHE_RUN_GROUP=www-data
    export APACHE_RUN_GROUP=www-readwrite

### Adjust ‘apache’ logs to allow group ‘www-readwrite’ access.

Since I like to set up servers to be collaborative environments based on a user’s access to the `www-readwrite` group, I also like to give them clear & easy access to the `apache` logs. It’s generally helpful for debugging. And here is how I do it.

First, change the parent permissions on the `apache` log directory so others can read & execute it for basic directory listings:

    sudo chmod o+rx /var/log/apache2

Now, change the group ownership of the contents of the `apache` log directory to the group `www-readwrite`:

    sudo chgrp www-readwrite /var/log/apache2/*

And change the file permissions of the contents of the `apache` log directory to `644`:

    sudo chmod 644 /var/log/apache2/*

Now edit the `log rotate` daemon script for `apache`:

    sudo nano /etc/logrotate.d/apache2

It should look something like this. You can probably just copy & paste this in place to replace what was installed by default. But the key item in this case is the line that reads `create 640 root www-readwrite`:

    /var/log/apache2/*.log {
            weekly
            missingok
            rotate 13
            compress
            delaycompress
            notifempty
            create 640 root www-readwrite
            sharedscripts
            postrotate
                    /etc/init.d/apache2 reload > /dev/null
            endscript
            prerotate
                    if [ -d /etc/logrotate.d/httpd-prerotate ]; then \
                        run-parts /etc/logrotate.d/httpd-prerotate; \
                    fi; \
            endscript
    }

### Install APC for ‘php.’

    sudo pear upgrade pear

    sudo aptitude install php-apc

Start installing.

    sudo aptitude install php5-dev libpcre3-dev

    sudo pecl install -f apc

Edit the apc.ini file.

    sudo nano /etc/php5/conf.d/apc.ini

Nice basic config I use.

    extension=apc.so

    apc.enabled = 1
    apc.shm_segments = 1
    apc.shm_size = 32M
    apc.ttl = 0
    apc.user_ttl = 180
    apc.gc_ttl = 180
    apc.num_files_hint = 1024
    apc.mmap_file_mask = /dev/zero
    apc.enable_cli = 0
    apc.max_file_size = 1M
    apc.num_files_hint = 512

Disable apc.

    ;extension=apc.so

[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"