# Using an Ubuntu Linux Server

Written by [Jack Szwergold][1] on March 20, 2014

## Part 2: Setting Up a LAMP Stack

So in part 1 of my tutorial, I explained how I like to configure a base level Ubuntu server. In part 2 of my tutorial I will explain how to setup useful & solid LAMP stack that can be used as a production server or a development/sandbox server for web development needs.

### Install ‘apache’ & some ‘php’ basics.

    sudo aptitude install apache2 apache2-threaded-dev php5 libapache2-mod-php5 php-pear

### Install the PHP5 modules.

    sudo aptitude install php5-mysql php5-pgsql php5-odbc php5-sybase php5-sqlite php5-xmlrpc php5-json php5-xsl php5-curl php5-geoip php-getid3 php5-imap php5-ldap php5-mcrypt php5-pspell php5-gmp php5-gd

[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"