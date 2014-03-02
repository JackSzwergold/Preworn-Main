# Connecting to MAMP from Windows on a Mac OS X Install of VirtualBox
This document outlines the two main ways I like to connect to a host machine from a guest machine within VirtualBox for web browser testing with MAMP-based development tools in Mac OS X.
If it’s unclear to you what a *host* machine is compared to a *guest* machine: A host machine is the computer running the VirtualBox application itself and a guest machine is a virtual machine that runs within the VirtualBox application itself. The goal of this tutorial is to be able to bridge the host environment with the guest environment so you can use VirtualBox to help debug websites running in MAMP.

The basic concepts of this kind of setup can be used for all sorts of things beyond web page testing. But the focus of this document is the basic needs of a web developer who needs to test browser compatibly against the various flavors of Microsoft Internet Explorer web browser that are out there. Internet Explorer testing can be painful. Nah, let’s face it: Internet Explorer testing *is* painful… And horrible. Hopefully a setup like this can make your life as a web developer easier.***
## Part 1: Connecting to MAMP from Windows on VirtualBox with a Single Network Interface

In this first example I will explain how to get a fresh Windows guest OS install on VirtualBox to connect to the host machine so one can test web development in MAMP via Internet Explorer using the main VirtualBox network interface.

The main drawback of this method is there is no easy way to connect from the host machine to the guest, but that is not a big issue for Internet Explorer testing. If you think you might need that extra level of connectivity, skip to the second part of this tutorial where I explain how you can use dual network interfaces with a special host-only adapter in VirtualBox.The most immediate way you can connect to a host machine is to use the default VirtualBox user network gateway of **10.0.2.2**.So if you were to connect to MAMP on Mac OS X running on port **8888**, the address to connect to would be:	http://10.0.2.2:8888But that is far from ideal since the MAMP setups we use at the Guggenheim use Apaches named virtual hosts to allow for there to be one root at:	http://localhost:8888And then another one based on your machine ID of—for example—**MY_MACHINE** like this:	http://MY_MACHINE.local:8888The problem? Two things. 1. One, since **localhost** is universally considered a machine’s own loopback address, the actual **localhost** on a guest OS in VirtualBox would be the loopback of the guest OS itself. When in reality you want the **localhost** of the host machine. Which is an entirely different machine from a virtualization standpoint. 2. The other issue is that due to the fact that Windows & VirtualBox do not play well together with regards to multicast network packets, let along MDNS (multicast DNS), a machine hostname like **MY_MACHINE.local:8888** will never be visible to Windows in VirtualBox.The solution to both of these issues for our purposes is to simply edit the ‘hosts’ file on the Windows guest OS. The file is located here.	c:\windows\system32\drivers\etcAnd should be edited via a text editor—such as Notepad—run as an administrator.Since the “hosts” file user editable when running Windows in VirtualBox, so you can create hostname aliases of your choice. But for this example I would use **MY_MACHINE** like so.	10.0.2.2	MY_MACHINE	10.0.2.2	MY_MACHINE.localDoing this, you would be able to connect to the equivalent of the following.	MY_MACHINE:8888 would be the same as localhost:8888
	MY_MACHINE.local:8888 would be the same as MY_MACHINE.local:8888So now you should be able to connect to anything on **MY_MACHINE.local:8888** and view it as if it were being viewed from MAMP on your Mac desktop. But in the case of the localhost equivalent of **MY_MACHINE:8888** depending on the codebase configuration of whatever you are testing, you might need to temporarily adjust the config files in your local MAMP set to reflect the new **MY_MACHINE:8888** address since **localhost:8888** won’t be reachable.
***
## Part 2: Connecting to MAMP from Windows on VirtualBox with a Host-Only InterfaceSetting up VirtualBox with an additional host-only interface gives you the flexibility of connecting directly from the host machine to the guest machine. It also helps you eliminate the possibility of any inadvertent networking weirdness that might occur when managing the connections of a whole slew of virtual machines talking to the host machine.But if you don’t care about such things—or if networking issues give you a headache—turn away now & just use the single network interface setup outlined in part 1.
You will basically be setting up a static IP network within the **192.165.65.x** subnet on the host-only adapter. So your virtual machine will have a standard **10.0.2.x** address on the main network interface and another IP address within the **192.165.65.x** subnet on the secondary host-only virtual interface.The first step in setting up a host-only adapter happens in the main VirtualBox interface.

 1. Go to the *VirtualBox* menu.
 2. Then choose *Preferences*.
 2. Within *Preferences*, select *Network*.
 3. And then choose *Host-only Networks*.

There should be at least one item in the pane called *vboxnet0*. If you do not see anything in that list—let alone *vboxnet0*—don’t worry. Just click the small icon that looks like a small PCI network interface card with a green “+” plus symbol to add one.

You only need to add two items to create a new adapter:

 1. The IPv4 address of **192.168.56.1**.
 2. The IPv4 network mask of **255.255.255.0**.

And then click the DHCP pane and make sure the DHCP server is disabled since this will be a static network.
 Okay, got that? When all that is done your base VirtualBox host installation now has a new network interface that can be used for any/all of your virtual machines.

Now to set it up on a guest machine just highlight whatever VirtualBox virtual machine you would like to to have this adapter and: 

 1. Click *Settings*.
 2. Then choose *Network*.

At this point you should see an *Adapter 1* pane and that should be set to NAT. Don’t touch that, but now click the *Adapter 2* pane and:

 1. Check the *Enable Network Adapter* box.
 2. And then for the *Attached to:* pull down select *Host-only Adapter*.
 3. And then under *Name* select *vboxnet0*.
 4. Once that’s all set, just click *OK* and you’re done.Now when you launch your virtual machine, you can connect to the gateway address of the host-only adapter, which is **192.168.56.1**. So if you were connecting to MAMP via this setup, the address would be:	http://192.168.56.1:8888And then when editing the “hosts” file the entries would be something like:	192.168.56.1	MY_MACHINE	192.168.56.1	MY_MACHINE.localThe other benefit of this setup is on your Windows machine you can setup a static IP address—likefor example 192.168.56.10—and use that address to connect from your host setup to your guest setup.

Again, for basic Windows browser compatibility testing, that might not be a factor but it is a nice option to have. And having a separate network interface for host-only traffic can help eliminate the potential issues associated with having all traffic going through the main **10.0.2.2** interface. 