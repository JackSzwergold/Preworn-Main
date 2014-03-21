# Connecting to MAMP from Windows on a Mac OS X Install of VirtualBox

Written by [Jack Szwergold][1] on March 2, 2014


In this tutorial I am going to outline one of the most basic ways to connect to a `host` machine from a `guest` machine within VirtualBox from a fresh Windows `guest` OS install using the main VirtualBox network interface.

This is being done primarily for Microsoft Internet Explorer web browser cross-platform compatibility testing with MAMP-based development tools in Mac OS X. But the basic concepts of this kind of setup can be used for all sorts of things beyond testing web browser cross-platform browser compatibly.

The main drawback of this method is there is no easy way to connect from the `host` machine to the `guest`, but that is not a big issue for basic Internet Explorer testing. If you think you might need that extra level of two-way connectivity, skip to the second part of this tutorial where I explain how you can use dual network interfaces with a special host-only adapter in VirtualBox.
* **MY_MACHINE.local:8888** would be the same as **MY_MACHINE.local:8888**

### Conclusion.

So now you should be able to connect to anything on **MY_MACHINE.local:8888** and view it as if it were being viewed from MAMP on your Mac desktop. But in the case of the localhost equivalent of **MY_MACHINE:8888** depending on the codebase configuration of whatever you are testing, you might need to temporarily adjust the config files in your local MAMP set to reflect the new **MY_MACHINE:8888** address since **localhost:8888** won’t be reachable.
