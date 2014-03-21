# Connecting to MAMP from Windows on a Mac OS X Install of VirtualBox

Written by [Jack Szwergold][1] on March 2, 2014



So if you want to play vintage Atari 2600 video games on a modern computer, you would use emulation software that would emulate the Atari 2600 hardware on your modern system.

But emulation & virtualization is not 100% the same.

Virtualization—in contrast to emulation—is a software method which allows you to better divide & allocate existing, non-emulated system resources for other purposes.

So in the case of a modern PC—like Apple’s Macintosh computers—which use the same Intel-based x86 CPUs like Windows machines, virtualization allows an Apple Macintosh x86-based hardware running Mac OS X to run Microsoft Windows—which requires x86-based hardware as well—within a virtual environment on the same machine. This is great!


You know why this is great? Because, I like to work on primarily in Mac OS X & regularly need do web browser cross-platform compatibility of my work with Internet Explorer running on Windows.

In the past, I literally had another completely separate Windows PC I would use exclusively to do web browser cross-platform compatibility tests with Internet Explorer. That setup worked, but it’s clunky to say the least. A whole separate machine? One I had to maintain as well? Nope. Not a good setup.

But now thanks to virtualization, I can have Windows in a `guest` machine running on my desktop via VirtualBox right next to my development environment on the `host` machine running MAMP. This is simply great since it streamlines the whole development process.

If it’s unclear to you what a `host` machine is compared to a `guest` machine: A `host` machine is the computer running the VirtualBox application itself and a `guest` machine is a virtual machine that runs within the VirtualBox application itself.
