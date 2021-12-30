<div id="content">
<h1 class="title">Postfix Postqueue Parser
</h1>
<p>
I'm starting to learn a bit more about Postfix. It's one of those
things that I've treated as a black box for a long time. We've been
running with basically the same configuration for a very long
time. This week we noticed that the active queue backed up with tens
of thousands of emails across a few different domains. After waiting
for a few hours, we decided to try to purge the emails that were
queued up.
</p>

<p>
By default Postfix has a bunch of commands to give you insight into
the queues and where emails are backing up. E.g. <a href="https://tecadmin.net/flush-postfix-mail-queue/">https://tecadmin.net/flush-postfix-mail-queue/</a> <a href="http://www.postfix.org/QSHAPE_README.html">http://www.postfix.org/QSHAPE_README.html</a>
</p>

<p>
I really like the way the <a href="http://www.postfix.org/qshape.1.html">qshape</a> tool illustrates where the
bottleneck in the queue is by pivoting domain and age. My goal was to
make a simple script to easily purge emails from any queue based on
the age of the email. The easiest starting point is to leverage the
output from the <a href="http://www.postfix.org/postqueue.1.html">postqueue</a> tool.
</p>

<p>
When you run <code>postqueue</code> you get output that looks a bit like this:
</p>

<p>
The output is a little unusual because records are actually separated
an empty line. The other thing that's a little unusual about this
output is the format of the date. There is no year. My script won't
work very well on January first. Right now it's just a maintenance
script, but if I wanted to run this all the time in order to regularly
purge old emails, I would need to handled that particular situation
better.
</p>

<p>
Here is the initial script:
</p>


<script src="https://gist.github.com/praetoriansentry/7e0dfdcb45f96fe55d0344f85fca3eca.js"></script>


<p>
I was considering writing it in perl, but changed my mind because I
didn't want to figure out how to parse a date on our production
system. I have no idea if any date handling modules or if cpan is
available on that system. Go in this instance is helpful because it
can be cross compiled and deployed very easily.
</p>

<p>
In order to purge our queues of old emails I ran something like this:
</p>


<div class="org-src-container">
<pre class="src src-bash">postqueue -p -c /etc/postfix-02 | ./postqueueparse-linux-amd64 -m 1000 | \
  postsuper -c /etc/postfix-02 -d -
</pre>
</div>

<p>
First, I'm getting all of the emails are in the queue for the 02
instance of Postfix. Our system runs multiple instances of Postfix, so
the tools need to know which instance I'm working with. I pass that
output into the parser script. That will filter down so that it's only
outputting the queue IDs of emails that have an arrival time more than
1000 minutes ago. At that point, I can pass the queue IDs into
<code>postsuper -d -</code> in order to purge the queue and delete any stale
emails.
</p>
</div>
