# Using an Ubuntu Linux Server

Written by [Jack Szwergold][1] on March 20, 2014

## Part 2: Monitoring & Securing Your Ubuntu Server

The purpose of this tutorial is to explain how I like to configure an Ubuntu server. This doesn’t go into details as to how you got Ubuntu installed on a server to begin with, but begins with the assumption that you have an Ubuntu machine setup to the point you have a basic terminal prompt & you can login as a user with administrator rights.

### Let’s get started.

### Install & enable sysstat.

Systat—commonly accessed via the command line command `sar`—is a great tool to use to collect, report, or save system activity information.

    sudo aptitude install sysstat

Now open the `sysstat` config file like so:

    sudo nano /etc/default/sysstat

And set the `ENABLED` value to `true`:

    ENABLED="true"

Once that is done, restart `sys stat`:

    sudo service sysstat restart

Now wait about 10-15 minutes to a half hour and run the following command:

    sar -q

The output should be something like this:

    09:55:01 PM   runq-sz  plist-sz   ldavg-1   ldavg-5  ldavg-15   blocked
    10:05:01 PM         2       130      1.18      1.48      1.05         0
    10:15:02 PM         1       126      0.01      0.80      1.11         0
    10:25:01 PM         1       126      0.01      0.18      0.64         0
    10:35:02 PM         2       135      1.58      1.59      1.10         0
    Average:            2       127      0.45      0.83      0.95         0

That reflects the system load average history & allows you to note when—and if—there was a spike in system activity. Very useful in diagnosing system issues after they happen.

### Install POSTFIX & related mail utilities.

    sudo aptitude install postfix

In SOME cases, this is a better option if POSTFIX chokes.

    sudo aptitude install mailutils

Check the postfix config.

    sudo nano /etc/postfix/main.cf

Change these to match your server settings.

    myhostname = sandbox.local
    mydestination = sandbox.local, localhost.localdomain, localhost

### Install iptables & iptables-persistent & import iptables.conf.

    sudo aptitude install iptables iptables-persistent

    sudo iptables-restore < iptables.conf

    sudo cp ~/iptables.conf /etc/iptables/rules.v4

Run 'update-locale'.

    sudo update-locale

Might need to set the locale file to this.

    sudo nano /etc/default/locale

    LANG="en_US.UTF-8"

[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"