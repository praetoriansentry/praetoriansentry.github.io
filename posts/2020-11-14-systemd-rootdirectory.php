<div id="content">
<h1 class="title">Sandboxing with systemd
</h1>
<p>
I've worked with systemd for a long time, but I've never really
understood it. I know how to start and stop, enable and disable, and
check the status and logs of a service that's running. I'll often
create very simple services for running my own code.
</p>

<p>
I'm also aware of some the <a href="https://lwn.net/Articles/620878/">controversy and debate</a> surrounding its
integration into distributions like Debian. From my perspective, I
never really understood the big deal. It seemed like a small
change. Instead of running <code>/etc/init.d</code> I would be running something
like <code>systemctl</code>. I suppose that's a very naive point of view, but I
feel pretty pragmatic when it comes to Linux.
</p>

<p>
Getting into Gemini has given me some excuses to get a deeper
understanding of Linux, TLS, and even some basic networking. After
writing my extremely simple Gemini server (Melchior), I wanted to
figure out how to deploy it. My initial pass was to run it as a
systemd service. The Gemini server itself is supposed to be secure and
avoid things like directory traversal. I added some basic checks for
this type of vulnerability, but I've still been nervous about my
deployment. Hardening my Gemini environment has been a useful
playground. How do I protect my server and network if it turns out
Melchior has a serious vulnerability?
</p>

<p>
I considered moving Melchior into a Docker container. A lot of the
benefits of Docker would help alleviate my security fears. The
downside is that docker is a big / complicated beast in its own
right. I don't really want to run / administer Docker if I can avoid
it. I started searching around and ended up finding a very helpful
talk from Lennart Poettering, the creator of systemd: <a href="https://www.youtube.com/watch?v=sqhojVPr7xM">Lennart
Poettering: "Containers without a Container Manager, with systemd"</a>
</p>

<p>
The subject of the talk was exactly what I was looking for. Containers
without a container manager.
</p>

<p>
After watching the first half of the talk, I paused and made some
changes to my systemd setup for Melchior. Most importantly, I added
the <code>RootDirectory=</code> option. This is very similar to doing a
<code>chroot</code>. If I get it setup properly, even if Melchior is setup
poorly, I can avoid leaking information via directory traversal. My
<code>/var/gemini</code> directory like this:
</p>



<p>
One risk here is that my certificate and key directory would still be
accessible via directory traversal possibly, but I'm not super worried
about that.
</p>

<p>
In addition to <code>RootDirectory=</code> there is a option <code>RootImage=</code> which
could work a lot like an image. We could use a tool like <a href="https://github.com/systemd/mkosi">mkosi</a> to
bundle all of our folders and assets together and deploy a full
image. In my case, that didn't seem as convenient.
</p>

<p>
The systemd config that I'm running now is on <a href="https://github.com/praetoriansentry/melchior/blob/main/melchior-daemon.service">Github</a>. The changes were
very small.
</p>


<p>
The only "gotcha" that I ran into here was that Melchior wouldn't run
without being compiled statically. The behavior is very similar to
running a go binary in a <code>FROM scratch</code> image in Docker. Here is the
command I'm using now:
</p>


<div class="org-src-container">
<pre class="src src-bash">go build -ldflags "-linkmode external -extldflags -static" -a melchior.go
</pre>
</div>

<p>
After rebuilding Melchior this way, everything worked prefectly (I think).
</p>

<p>
I'm realizing how little I really know about systemd. Even for this
simple Gemini server, I feel like there's a lot more that I could
leverage. I'm looking forward to learning even more.
</p>
</div>
