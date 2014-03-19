# Using Ubuntu Server

Written by [Jack Szwergold][1] on March 19, 2014

## Part 1: Configuration a Basic, Useful Ubuntu Server

The purpose of this tutorial is to explain how I like to configure an Ubuntu server. This doesn’t go into details as to how you got Ubuntu installed on a server to begin with, but begins with the assumption that you have an Ubuntu machine setup to the point you have a basic terminal prompt & you can login as a user with administrator rights.

### Let’s get started.

First & foremost depending on how your initial install of Ubuntu went, you were either prompted to create an initial user with administrator rights or you were assigned a user. I’m not going to run down the list how an initial user is generated, but there is one overarching philosophy here: If your administrative user is named `root` that is not good from a security standpoint.

There are are tons of hacks & exploilts that explicitly look for—and act on—the `root` account, so you sould not use that account for any reason & instead handle administrative functions via another user assigned administratives rights via `sudo`.

#### Create the users.

Okay, so here is where you will create a new administrative user. The name can be anything you like as long as it is not something common & predictable like `admin` or `administrator`. In my case, I like to use the name `sysop` which is short for “system operator” which is a throwback to the old BBS days, but works well for a case like this. Just add the new user using `adduser` like so:

    sudo adduser sysop

I also like to add a standard, non-administrator user to the system as well for configuration testing like so:

    sudo adduser user

For both users, be sure to choose a solid password of some sort. Something easy for you to remember but not easy for someone else to guess.

#### Add the new admin user to the ‘sudoers’ file.

So now that you have designated a new user to be an administrator, you have to actually add that user to the `sudoers` file so they can be granyted `sudo` user rights. So let’s open the file like so:

    sudo nano /etc/sudoers

#### Add this entry under: User privilege specification. 

    sysop ALL=(ALL:ALL) ALL

#### Now lock the root account.

    sudo passwd -l root


***



#### Some Ubuntu setups don't have the 'www-readwrite' group in place, so we need to add it.

    sudo groupadd www-readwrite

#### Set user's default group to the 'www-readwrite' group.

    sudo usermod -g www-readwrite sysop

    sudo usermod -g www-readwrite user

#### Add user to the www-readwrite group.

    sudo adduser sysop www-readwrite

    sudo adduser user www-readwrite

#### Set the server time & timezone info.

    sudo ntpdate ntp.ubuntu.com

    sudo dpkg-reconfigure tzdata

#### Set the NTP client to check the server daily.

    sudo nano /etc/cron.daily/ntpdate

#### Add this to that file.

    ntpdate -s ntp.ubuntu.com

#### Make sure the file has executable permissions.

    sudo chmod 755 /etc/cron.daily/ntpdate

#### Update apt-get & install aptitude.

    sudo apt-get update

    sudo apt-get install aptitude

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