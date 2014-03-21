# Using Ubuntu Server

Written by [Jack Szwergold][1] on March 19, 2014

## Part 1: Configuration a Base Level Ubuntu Server

The purpose of this tutorial is to explain how I like to configure an Ubuntu server. This doesn’t go into details as to how you got Ubuntu installed on a server to begin with. But begins with the assumption that you have an Ubuntu machine set up to the point you have a basic terminal prompt & you can login as a user with administrator rights.

### Let’s get started.

Before anything else, let’s make sure that `aptitude` is installed. I know some users prefer `apt-get`, but I find `aptitude` to be nicer & easier to use. It appears to be installed by default with Ubuntu 12.04, but in case it isn’t do the following to install `aptitude`:

    sudo apt-get update
    sudo apt-get install aptitude

### Disable the ‘root’ account.

First & foremost depending on how your initial install of Ubuntu went, you were either prompted to create an initial user with administrator rights or you were assigned a user. I’m not going to run down the list how an initial user is generated, but there is one overarching philosophy here: If your administrative user is named `root` that is not good from a security standpoint.

There are are tons of hacks & exploits that explicitly look for—and act on—the `root` account. So you should not use the `root` account directly for any reason & instead handle administrative functions via another user who is assigned administrative rights via `sudo`.

### Create the users.

Okay, so here is where you will create a new administrative user. The name can be anything you like as long as it is not something common & predictable like `admin` or `administrator`. In my case, I like to use the name `sysop` which is short for “system operator” which is a throwback to the old BBS days, but works well for a case like this. Just add the new user using `adduser` like so:

    sudo adduser sysop

I also like to add a standard, non-administrator user to the system as well for configuration testing like so:

    sudo adduser user

For both users, be sure to choose a solid password of some sort. Something easy for you to remember but not easy for someone else to guess.

### Add the new admin user to the ‘sudoers’ file.

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

### Set the server time & related timezone info.

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

When that is done, your server’s time synchronization settings should be all set.

### Edit the ‘sources.list’ to enable partner package updates.

While Ubuntu open source community has tons of good software tools, there are tons of other good software tools available that might not be fully open source yet available for free via Canonical’s `partner` repository. So we want to enable access to that repository—so we have direct access—via `aptitude`—to install those tools. First, open the `sources.list` file so it can be edited like so:

    sudo nano /etc/apt/sources.list

Find the following chunk of configuration code:

    ## Uncomment the following two lines to add software from Canonical's
    ## 'partner' repository.
    ## This software is not part of Ubuntu, but is offered by Canonical and the
    ## respective vendors as a service to Ubuntu users.
    # deb http://archive.canonical.com/ubuntu/ precise partner
    # deb-src http://archive.canonical.com/ubuntu/ precise partner

And uncomment the last two lines of that to enable access to the `partner` repository:

    deb http://archive.canonical.com/ubuntu/ precise partner
    deb-src http://archive.canonical.com/ubuntu/ precise partner

Now with that done, let’s update `aptitude`

    sudo aptitude update

    sudo aptitude upgrade

### Install base level tools & utilities.

At this point you should have a somewhat functional Ubuntu server in place with the bare minimum items needed to do some basic things, but we’re not done yet.

There are lots of other useful tools that should be installed to make your life easier. And here they are! 

    sudo aptitude install dnsutils traceroute nmap bc htop finger curl whois rsync lsof iftop figlet lynx mtr-tiny iperf nload zip unzip attr sshpass dkms mc elinks 

While there are literally tons of tools available for installation in the Ubuntu community, the items listed above are the rock-solid core of the command line system administration tools I rely on on a daily basis. 

I’m not going to do a tool-by-tool breakdown of usage in this tutorial, but if you already know anything about how Unix systems work, you can pretty much understand how these tools are used. But if you don’t know what these tools are, I encourage you to read up on these tools by using the `man` command from the command line like so:

    man htop

That would give you the manual page (aka: `man` page) for `htop`; an excellent open source replacement for the commonly used system tool `top`.

### Install compilers, GIT, SVN & general development related stuff.

If you are going to use your Ubuntu server for code development of any level, you need to install some basic tools to get the job done like so:

    sudo aptitude install build-essential git git-core subversion git-svn

That command will install the whole suite of Debian compilers such as `gcc`/`g++` as well as SCM (source code management) tools such as `git`, `svn` (Subversion) & related utilities like `git-svn` which you can use to bridge & convert `svn` repositories to `git` repositories.

### Setting default UMASK for group writability.

By default, Unix systems are set to only allow users to write to files they themselves have created by using a system-wide UMASK of `022`. But since I like to setup servers which allow users to collaborate when connected to a common group—such as `www-readwrite`—I like to set the system-wide UMASK to `002`.

So the first step in doing this is to open the `login.defs` file for editing like so:

    sudo nano /etc/login.defs

Look for the line with the `UMASK` setting that looks like this:

    UMASK           002

And change it to this:

    # UMASK         022
    UMASK           002

Next, you need to change the pam.d UMASK setting in `common-session` by opening the that file for editing like so:

    sudo nano /etc/pam.d/common-session

Then finding the line that looks like this

    session optional                        pam_umask.so

Change it like so. Note the addition of `umask=0002` at the end of the line:

    session optional                        pam_umask.so    umask=0002

Now with those two settings adjusted, any user who now logs in will be creating files that are group writable. You can test this out with your current user by logging out—and logging back in—and simply creating a dummy test file like so:

    touch test_file.txt

If you do a directory listing in that directory like so:

    ls -la test_file.txt

The file permissions for `test_file.txt` should look like this:

    -rw-rw-r-- 1 sysop www-readwrite 0 Mar 20 05:36 test_file.txt

Note the `rw` for the group permissions which indicates the file can be read from & written to. Which all means that your default user group permissions are properly set to allow group writability.

### Install ‘locate’.

Now we’ll install a tool that will make your life lots easier: `locate`. Simply put, if you know what `Spotlight` is in OS X, then you know what `locate` is. It’s a tool that indexes content on your file system and allows you to quickly find files—including full file paths—with ease.

Your first step in using it is to actually install it like so:

    sudo aptitude install locate

Next, run the `updatedb` command so the `locate` command actually has database to use:

    sudo updatedb

Now do a search for a a file—such as the `test_file.txt` we created above—like so:

    locate test_file.txt

The result returned should be:

    /home/sysop/test_file.txt

Being able to get to content quickly & easily via the command line is invaluable. And `locate` will help make your life working in the command line a bit easier.

### Fix for slow SSH client connections.

Sometimes a fresh install of Ubuntu can have slow a SSH connection when using password authentication. This happens because SSH has `password` authentication set as the last authentication option by default. So you want to edit the SSH config to push `password` authentication closer to the top of the list like so:

    sudo nano /etc/ssh/ssh_config

Now add the following line to the bottom of the configuration options in that file:

    PreferredAuthentications publickey,password,gssapi-with-mic,hostbased,keyboard-interactive

Now restart the SSH daemon like so:

    sudo service ssh restart

And that problem should be cleared up.

### Adjust the MOTD (Message of the Day) header & related info.

    figlet SANDBOX

    sudo nano /etc/motd.tail


[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"