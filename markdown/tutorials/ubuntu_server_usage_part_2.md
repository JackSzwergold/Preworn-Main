# Using an Ubuntu Linux Server

Written by [Jack Szwergold][1] on March 22, 2014

## Part 2: Setting Up a LAMP Stack

So in part 1 of my tutorial, I explained how I like to configure a base level Ubuntu server. In part 2 of my tutorial I will explain how to setup useful & solid LAMP stack that can be used as a production server or a development/sandbox server for web development needs.

### Install ‘apache’ & some basic ‘php’ stuff.

    sudo aptitude install apache2 apache2-threaded-dev php5 libapache2-mod-php5 php-pear

### Install the ‘php’ modules.

    sudo aptitude install php5-mysql php5-pgsql php5-odbc php5-sybase php5-sqlite php5-xmlrpc php5-json php5-xsl php5-curl php5-geoip php-getid3 php5-imap php5-ldap php5-mcrypt php5-pspell php5-gmp php5-gd
    
### Harden ‘php.’

    sudo nano /etc/php5/apache2/php.ini
    
    expose_php = Off

### Harden ‘apache.’

    sudo nano /etc/apache2/conf.d/security
    
Locate 'ServerTokens' and set to production.

    ServerTokens Prod

Locate 'ServerSignature' and disable.

    ServerSignature Off

Locate 'TraceEnable' and disable.

    TraceEnable Off

### Set the default ‘apache’ config.

    sudo nano /etc/apache2/sites-available/default

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
      include /etc/apache2/sites-available/common.conf

      # Including common ModSecurity related items.
      # include /etc/apache2/sites-available/common_mod_security.conf

    </VirtualHost>

### Set a nicer default ‘php’-based index file instead of the standard “It works!” index file.

    sudo rm /var/www/index.html

    sudo nano /var/www/index.php

    <?php

    # phpinfo();
    # header('Location: http://www.preworn.com/');
    echo $_SERVER['SERVER_NAME'];
    # echo '<br />';
    # echo $_SERVER['SERVER_ADDR'];

    ?>

### Enable ‘apache’ modules.

    sudo a2enmod rewrite headers include proxy proxy_http
    
### Adjust ‘apache’ config to allow group ‘www-readwrite’ access.

Setting Apache2 `umask` in Ubuntu & other Debian setups.

    sudo nano /etc/apache2/envvars

Append this to the end of the file.

    umask 002

Also, in `/etc/apache2/envvars` change the `APACHE_RUN_GROUP` group to `www-readwrite.`

    # export APACHE_RUN_GROUP=www-data
    export APACHE_RUN_GROUP=www-readwrite

### Adjust ‘apache’ logs to allow group ‘www-readwrite’ access.

    sudo chmod o+rx /var/log/apache2

    ls -latr /var/log/apache2/

    ls -la /var/log/apache2/*.log

    sudo chgrp www-readwrite /var/log/apache2/*

    sudo chmod 644 /var/log/apache2/*

    sudo nano /etc/logrotate.d/apache2

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

    apc.enabled = 0
    apc.shm_segments = 1
    apc.shm_size = 32M
    apc.ttl = 0
    apc.user_ttl = 180
    apc.gc_ttl = 180
    apc.num_files_hint = 1024
    apc.mmap_file_mask = /dev/zero
    apc.enable_cli = 0
    apc.max_file_size = 1M

Disable apc.

    ;extension=apc.so

[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"