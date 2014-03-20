# Using Ubuntu Server

Written by [Jack Szwergold][1] on March 19, 2014

## Part 1: Configuration a Basic, Useful Ubuntu Server

The purpose of this tutorial is to explain how I like to configure an Ubuntu server. This doesn’t go into details as to how you got Ubuntu installed on a server to begin with, but begins with the assumption that you have an Ubuntu machine setup to the point you have a basic terminal prompt & you can login as a user with administrator rights.

### Let’s get started.

First & foremost depending on how your initial install of Ubuntu went, you were either prompted to create an initial user with administrator rights or you were assigned a user. I’m not going to run down the list how an initial user is generated, but there is one overarching philosophy here: If your administrative user is named `root` that is not good from a security standpoint.

There are are tons of hacks & exploits that explicitly look for—and act on—the `root` account, so you should not use that account for any reason & instead handle administrative functions via another user assigned administrative rights via `sudo`.

### First, make sure ‘aptitude’ is installed.

Before anything else, let’s make sure that `aptitude` is installed. I know some users prefer `apt-get`, but I find `aptitude` to be nicer & easier to use. It appears to be installed by default with Ubuntu 12.04, but in case it isn’t do the following to install `aptitude`:

    sudo apt-get update
    sudo apt-get install aptitude

### Create the users.

Okay, so here is where you will create a new administrative user. The name can be anything you like as long as it is not something common & predictable like `admin` or `administrator`. In my case, I like to use the name `sysop` which is short for “system operator” which is a throwback to the old BBS days, but works well for a case like this. Just add the new user using `adduser` like so:

    sudo adduser sysop

I also like to add a standard, non-administrator user to the system as well for configuration testing like so:

    sudo adduser user

For both users, be sure to choose a solid password of some sort. Something easy for you to remember but not easy for someone else to guess.

#### Add the new admin user to the ‘sudoers’ file.

So now that you have designated a new user to be an administrator, you have to actually add that user to the `sudoers` file so they can be granted `sudo` user rights. So let’s open the file like so:

    sudo nano /etc/sudoers

Look for the section that controls user privileges named “User privilege specification”. It should look like this:

    # User privilege specification
    root   ALL=(ALL:ALL) ALL

Now comment out the `root` user, and add another line for the `sysop` user like so:

    # User privilege specification
    #root   ALL=(ALL:ALL) ALL
    sysop ALL=(ALL:ALL) ALL

Okay, have that set? Then go ahead & lock the `root` user’s account like so:

    sudo passwd -l root

And you should now be all set to use `sysop` as your new administrative user with rights granted via `sudo`!

### Create the ‘www-readwrite’ group.

Since I do a lot of web development & systems administration on collaborative Ubuntu servers, I like to create a unique group which I assign users to. This allows me to retain system administrator’s privileges while allowing other non-administrator users to have access to web-specific areas & resources without having to system administrator rights.

    sudo groupadd www-readwrite

First, add the user’s to the `www-readwrite` group:

    sudo adduser sysop www-readwrite
    sudo adduser user www-readwrite

And now, let’s set the user’s default group to `www-readwrite` so every file they create is actually assigned the group of `www-readwrite` like so:

    sudo usermod -g www-readwrite sysop
    sudo usermod -g www-readwrite user

With the user & group basics set, let’s move onto the more sundry server setup things.

### Set the server time & timezone info.

Okay, now it’s time to set your server’s time with data pulled from a remote time server by running `ntpdate` like so:

    sudo ntpdate ntp.ubuntu.com

Now ensure your timezone is set correctly by configuring `tzdata` like so:

    sudo dpkg-reconfigure tzdata

Now let’s set up a daily cron job to check the NTP server to make sure the time is correct and not affected by accidental drifting caused by system reboots or other factors. First, create the `ntpdate` file like so:

    sudo nano /etc/cron.daily/ntpdate

And add this line to that file:

    ntpdate -s ntp.ubuntu.com

Then make sure the file has executable permissions:

    sudo chmod 755 /etc/cron.daily/ntpdate

That said, as of 2012 `ntupdate` is slowly being depreciated. So while the above—which is the traditional way of syncing to a time server—works as expected, the new preferred way is to sync with an ntp server is to use `ntpd` which can be installed as follows:

    sudo aptitude install ntp

The `ntpd` options can be edited here:

    sudo nano /etc/ntp.conf







#### Edit the 'sources.list' to enable partner package updates.

    sudo nano /etc/apt/sources.list

#### Uncomment the following lines to add Canonical's 'partner' repository.

    deb http://archive.canonical.com/ubuntu/ precise partner
    deb-src http://archive.canonical.com/ubuntu/ precise partner

    sudo aptitude update

    sudo aptitude upgrade







#### Install & enable sysstat.

    sudo aptitude install sysstat

#### Edit sysstat.

    sudo nano /etc/default/sysstat

#### Enable sysstat.

    ENABLED="true"

#### Restart sysstat.

    sudo service sysstat restart

#### Install more base level tools.

    sudo aptitude install dnsutils traceroute nmap bc htop finger curl whois rsync lsof iftop figlet lynx mtr-tiny iperf nload zip unzip attr sshpass dkms mc elinks
                      
#### Run 'update-locale'.

    sudo update-locale

#### Might need to set the locale file to this.

    sudo nano /etc/default/locale

    LANG="en_US.UTF-8"

#### Install the 'build-essential' tools to allow compiling source code.

    sudo aptitude install build-essential

#### Install Subversion & GIT related stuff.

    sudo aptitude install git git-core subversion git-svn

#### Install POSTFIX.

    sudo aptitude install postfix

#### In SOME cases, this is a better option if POSTFIX chokes.

    sudo aptitude install mailutils

#### Check the postfix config.

    sudo nano /etc/postfix/main.cf

#### Change these to match your server settings.

    myhostname = sandbox.local
    mydestination = sandbox.local, localhost.localdomain, localhost

#### Set the MOTD header.

    figlet SANDBOX

    sudo nano /etc/motd.tail

#### Setting default UMASK in Ubuntu & other Debian setups.

    sudo nano /etc/login.defs

    # UMASK         022
    UMASK           002


#### Setting pam.d UMASK in Ubuntu & other Debian setups.

    sudo nano /etc/pam.d/common-session

#### Find the line that reads.

    session optional                        pam_umask.so

#### Change it to.

    session optional                        pam_umask.so	umask=0002


#### Fix for slow SSH client connections by changing the prefered order of authetications

#### This changes it for all users on a system level.

    sudo nano /etc/ssh/ssh_config

    PreferredAuthentications publickey,password,gssapi-with-mic,hostbased,keyboard-interactive


#### Install locate & update the database.

    sudo aptitude install locate

    sudo updatedb


##### Install iptables & iptables-persistent & import iptables.conf.

    sudo aptitude install iptables iptables-persistent

    sudo iptables-restore < iptables.conf

    sudo cp ~/iptables.conf /etc/iptables/rules.v4

[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"