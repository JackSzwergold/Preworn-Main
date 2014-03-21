# Using an Ubuntu Linux Server

Written by [Jack Szwergold][1] on March 20, 2014

## Part 2: Monitoring & Securing Your Ubuntu Server

So in part 1 of my tutorial, I explained how I like to configure a base level Ubuntu server. In part 2 of my tutorial I will explain how to setup useful monitoring & security tools. You should never be in a situation where you cannot be able to review & assess server health. Being able to monitor & secure your server is the key to running a safe & stable server environment. 

### Install & enable ‘sysstat.’

One great tool to use to collect, report, or save system activity information is `sysstat`; sometimes referred to as `sar` since that is the actual command used to read the data `sysstat` collects. You can install `sysstat` via `aptitude` like this:

    sudo aptitude install sysstat

Now open the `sysstat` config file like so:

    sudo nano /etc/default/sysstat

And set the `ENABLED` value to `true`:

    ENABLED="true"

Once that is done, restart the `sysstat` service:

    sudo service sysstat restart

Now wait about 10-15 minutes to a half hour to allow `sysstat` to actually collect data and run the the `sar` command like so:

    sar -q

The results should be something like this:

    09:55:01 PM   runq-sz  plist-sz   ldavg-1   ldavg-5  ldavg-15   blocked
    10:05:01 PM         2       130      1.18      1.48      1.05         0
    10:15:02 PM         1       126      0.01      0.80      1.11         0
    10:25:01 PM         1       126      0.01      0.18      0.64         0
    10:35:02 PM         2       135      1.58      1.59      1.10         0
    Average:            2       127      0.45      0.83      0.95         0

That output reflects the system load average history & allows you to note when—and if—there was a spike in system activity. Very useful in diagnosing system issues after they happen.

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