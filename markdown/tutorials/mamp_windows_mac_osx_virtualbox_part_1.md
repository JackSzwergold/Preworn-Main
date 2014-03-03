# Connecting to MAMP from Windows on a Mac OS X Install of VirtualBox

Written by [Jack Szwergold][1] on March 2, 2014
## Part 1: Overall Virtualization Host & Guest ConceptsOkay, so if you already understand what emulation, virtualization & VirtualBox is, then you can skip this whole intro. But if you’re a novice who wants to take advantage of the power of virtualization for web development—and engaging in the painful task of Microsoft Internet Explorer web browser cross-platform compatibility testing—then please read on.### What’s emulation versus virtualization?
Simply put, emulation is a software method where one combination of hardware & software to behave like another completely combination of hardware & software.

So if you want to play vintage Atari 2600 video games on a modern computer, you would use emulation software that would emulate the Atari 2600 hardware on your modern system.

But emulation & virtualization is not 100% the same. Virtualization—in contrast to emulation—is software that allows you to better divide & allocate system resources for other purposes.

So in the case of a modern PC—like Apple’s Macintosh computers—which use the same Intel-based x86 CPUs like Windows machines, virtualization allows an Apple Macintosh x86-based hardware running Mac OS X to run Microsoft Windows—which requires x86-based hardware as well—within a virtual environment on the same machine.
### Why is virtualization good for web development?

In this case, I like to work on primarilly on Apple Macintosh hardware running Mac OS X & need do web browser cross-platform compatibility of my work with Internet Explorer running on Windows.

In the past, I literally had another, separate Windows PC I would use exclusively to do web browser cross-platform compatibility tests with Internet Explorer. But now thanks to emulation software
So instead of having to setup & run a whole separtIf it’s unclear to you what a `host` machine is compared to a `guest` machine: A host machine is the computer running the VirtualBox application itself and a guest machine is a virtual machine that runs within the VirtualBox application itself.
[1]: http://www.preworn.com/ "Preworn • Jack Szwergold’s Online Portfolio"
