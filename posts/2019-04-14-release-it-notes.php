<div id="content">
<h1 class="title">Notes, Quotes, and Thoughts from Release It
</h1>

<div id="org04904f6" class="figure">
<p><img class="img-fluid" "src="../img/release-it.jpg" alt="release-it.jpg">
</p>
</div>

<p>
Last month during the Next Jump engineering book club, we read <a href="https://www.worldcat.org/title/release-it-design-and-deploy-production-ready-software/oclc/1028052156">Release
It</a> by Michael Nygard. The book was jam packed with very useful
insights for building stable systems. It's one of the most useful
software engineering books I've read in a long time. I would highly
recommend it to anyone looking to build distributed systems.
</p>

<p>
I wanted to document my own notes, useful quotes, and various thoughts
from the book as well.
</p>

<p>
The stability patterns and anti patterns are mostly excerpts from the
end of each section within the book. Periodically, I've added some
commentary, but most of the content comes directly from the book.
</p>

<div id="outline-container-orga77be9b" class="outline-2">
<h2 id="orga77be9b"><span class="section-number-2">1</span> Stability Anti-patterns</h2>
<div class="outline-text-2" id="text-1">
</div>
<div id="outline-container-org41d2762" class="outline-3">
<h3 id="org41d2762"><span class="section-number-3">1.1</span> Integration Points</h3>
<div class="outline-text-3" id="text-1-1">
<p>
Integration points are all of the dependencies of our systems. These
integrations are necessary, but present a stability risk.
</p>

<p>
"Integration points are the number-one killer of systems. Every single
one of those feeds present a stability risk. Every socket, process,
pipe, or remote procedure call can and will hang."
</p>
</div>

<div id="outline-container-orgf8e1de6" class="outline-4">
<h4 id="orgf8e1de6"><span class="section-number-4">1.1.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-1-1">
<p>
<i>Beware this necessary evil.</i> Every integration point will eventually
fail in some way, and you need to be prepared for that failure.
</p>

<p>
<i>Prepare for the many forms of failure.</i> Integration point failures
take several forms, ranging from various network errors to semantic
errors. You will not get nice error responses delivered through the
defined protocol; instead, you'll see some kind of protocol violation,
show response, or outright hang.
</p>

<p>
<i>Know when to open up abstractions.</i> Debugging integration point
failures usually requires peeling back a layer of
abstraction. Failures are often difficult to debug at the application
layer because most of them violate the high-level protocols. Packet
sniffers and other network diagnostics can help.
</p>

<p>
<i>Failures propagate quickly.</i> Failure in a remote system quickly
because your problem, usually as a cascading failure when your code
isn't defensive enough.
</p>

<p>
<i>Apply patterns to avert integration point problems.</i> Defensive
programming via Circuit Breaker, Timeouts, Decoupling Middleware, and
Handshaking will all help you avoid the dangers of integration points.
</p>
</div>
</div>
</div>

<div id="outline-container-orgb31b84f" class="outline-3">
<h3 id="orgb31b84f"><span class="section-number-3">1.2</span> Chain Reactions</h3>
<div class="outline-text-3" id="text-1-2">
<p>
A chain reaction is when a single failure makes other types of
failures more likely. For example, when one host fails behind a load
balancer, the load on the rest of the servers in the target group
increases and makes the odds of failure higher.
</p>
</div>

<div id="outline-container-orgc9b7454" class="outline-4">
<h4 id="orgc9b7454"><span class="section-number-4">1.2.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-2-1">
<p>
<i>Recognize that one server down jeopardizes the rest.</i> A chain
reaction happens because the death of one server makes the others pick
up the slack. The increased load makes them more likely to fail. A
chain reaction will quickly bring an entire layer down. Other layers
that depend on it must protect themselves, or they will go down in a
cascading failure.
</p>

<p>
<i>Hunt for resource leaks.</i> Most of the time, a chain reaction happens
when your application has a memory leak. As one server runs out of
memory and goes down, the other servers pick up the dead one's
burden. the increased traffic means they leak memory faster.
</p>

<p>
<i>Hunt for obscure timing bugs.</i> Obscure race conditions can also be
triggered by traffic. Again, if one server goes down to a deadlock,
the increased load on the others makes them more likely to hit the
deadlock too.
</p>

<p>
<i>Use Autoscaling.</i> In the cloud, you should create health checks for
every autoscaling group. The scaler will shut down instances that fail
their health checks and start new ones. As long as the scaler can
react faster than the chain reaction propagates, your service will be
available.
</p>

<p>
<i>Defend with Bulkheads.</i> Partitioning servers with Bulkheads can
prevent chain reactions from taking out the entire service - though
they won't help the callers of whichever partition does go down. Use
Circuit Breaker on the calling side for that.
</p>
</div>
</div>
</div>

<div id="outline-container-org979c378" class="outline-3">
<h3 id="org979c378"><span class="section-number-3">1.3</span> Cascading Failures</h3>
<div class="outline-text-3" id="text-1-3">
<p>
I think of chain reactions horizontally. If there is s system with
multiple nodes of the same time, a chain reaction means that a failure
of one node increases the odds of a failure in the other notes.
</p>

<p>
I think that cascading failures are more vertical. It happens when a
failure at one level of a system causes failures in the other levels
of the system.
</p>
</div>

<div id="outline-container-orga95457b" class="outline-4">
<h4 id="orga95457b"><span class="section-number-4">1.3.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-3-1">
<p>
<i>Stop cracks from jumping the gap.</i> A cascading failure occurs when
cracks jump from one system or layer to another, usually because of
insufficiently paranoid integration points. A cascading failure can
also happen after a chain reaction in a lower layer. Your system
surely calls out to other enterprise systems; make sure you can stay
up when they go down.
</p>

<p>
<i>Scrutinize resource pools.</i> A cascading failure often results from a
resource pool, such as a connection pool, that gets exhausted when
none of its calls return. The threads that get the connections block
forever; all other threads get blocked waiting for connections. Safe
resource pools always limit the time a thread can wait to check out a
resource.
</p>

<p>
<i>Defend with Timeouts and Circuit Breaker.</i> A cascading failure
happens after something else has already gone wrong. Circuit Breaker
protects your system by avoiding calls out to the troubled integration
point. Using Timeouts ensures that you can come back from a call out
to the troubled point.
</p>
</div>
</div>
</div>

<div id="outline-container-orga214e39" class="outline-3">
<h3 id="orga214e39"><span class="section-number-3">1.4</span> Users</h3>
<div class="outline-text-3" id="text-1-4">
<p>
Users and usage can cause significant issues. Even something like good
traffic could cause an issue. But there are also scenarios where bots
or malicious traffic can cause a lot of issues.
</p>
</div>

<div id="outline-container-org579f152" class="outline-4">
<h4 id="org579f152"><span class="section-number-4">1.4.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-4-1">
<p>
<i>Users consume memory.</i> Each user's session requires some
memory. Minimize that memory to improve your capacity. Use a session
only for caching so you can purge the session contents if memory gets
tight.
</p>

<p>
<i>Users do weird, random things.</i> Users in the real world do things
that you won't predict (or sometimes understand). If there's a weak
spot in your application, they'll find it through sheer numbers. Test
scripts are useful for functional testing but too predictable for
stability testing. Look into fuzzing toolkits, property-based testing,
or simulation testing.
</p>

<p>
<i>Malicious users are out there.</i> Become intimate with your network
design; it should help avert attacks. Make sure your systems are easy
to patch - you'll be doing a lot of it. Keep your frameworks
up-to-date, and keep yourself educated.
</p>

<p>
<i>Users will gang up on you.</i> Sometimes they come in really, really big
mobs. When Taylor Switch tweets about your site, she's basically
pointing a sword at your servers and crying, "Release the legions!"
Large mobs can trigger hangs, deadlocks, and obscure race
conditions. Run special stress tests to hammer deep links or hot URLs.
</p>
</div>
</div>
</div>

<div id="outline-container-orgdddd102" class="outline-3">
<h3 id="orgdddd102"><span class="section-number-3">1.5</span> Blocked Threads</h3>
<div class="outline-text-3" id="text-1-5">
<p>
Crashes aren't usually the cause of an issue. More common though are
the situations where a process runs and doesn't do anything because
all the threads are blocking waiting for something that's never going
to finish.
</p>
</div>

<div id="outline-container-org42c132c" class="outline-4">
<h4 id="org42c132c"><span class="section-number-4">1.5.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-5-1">
<p>
<i>Recall that the Blocked Threads antipattern is the proximate cause of
most failures.</i> Application failures nearly always relate to the
Blocked Threads in one way or another, including the ever-popular
"gradual slowdown" and "hung server." The Blocked Threads antipattern
leads to Chain Reactions and Cascading Failures antipattern.
</p>

<p>
<i>Scrutinize resource pool.</i> Like Cascading Failures, the Blocked
Threads antipattern usually happens around resource pools,
particularly database connection pools. A deadlock in the database can
cause connections to be lost forever, and so can incorrect exception
handling.
</p>

<p>
<i>Use proven primitives.</i> Learn and apply safe primitives. It might
seem easy to roll your own producer/consumer queue: it isn't. any
library of concurrency utilities has more testing than your newborn
queue.
</p>

<p>
<i>Defend with Timeouts.</i> You cannot prove that your code has no
deadlocks in it, but you can make sure that no deadlock lasts
forever. Avoid infinite waits in function calls; use a version that
takes a timeout parameter. Always use timeouts, even though it means
you need more error-handling code.
</p>

<p>
<i>Beware the code you cannot see.</i> All manner of problems can lurk in
the shadows of their-party code. Be very wary. Test it
yourself. Whenever possible, acquire and investigate the code for
surprises and failure modes. You might also prefer open source
libraries to closed source for this very reason.
</p>
</div>
</div>
</div>

<div id="outline-container-org425d8f4" class="outline-3">
<h3 id="org425d8f4"><span class="section-number-3">1.6</span> Self-Denial Attacks</h3>
<div class="outline-text-3" id="text-1-6">
<p>
A self-denial attack is when the business or the system itself works
against its own stability. A common example is when the marketing team
sends a special offer that might drive a bunch of traffic to a page
that can't handle the load.
</p>

<p>
Another example that I thought of in this category is when there are
hot cache keys. All of the servers in a pool might all need the same
cache key at the same time in a way that brings down the cache
entirely.
</p>
</div>

<div id="outline-container-orgfcdc457" class="outline-4">
<h4 id="orgfcdc457"><span class="section-number-4">1.6.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-6-1">
<p>
<i>Keep the lines of communication open.</i> Self-denial attacks originate
inside your own organization, when people cause self-inflected wounds
by creating their own flash mobs and traffic spikes. You can aid and
abet these marketing efforts and protect your system at the same time,
but only if you know what's coming. Make sure nobody sends mass emails
with deep links. Send mass emails in waves to spread out the peak
load. Create static "landing zone" page for the first click from these
offers. Watch out for embedded session IDs in URLs.
</p>

<p>
<i>Protect shared resources.</i> Programming errors, unexpected scaling
effects, and shared resources all create risks when traffic
surges. Watch out for <i>Fight Club</i> bugs, where increased front-end
load causes exponentially increasing back-end processing.
</p>

<p>
<i>Expect rapid redistribution of any cool or valuable offer.</i> Anybody
who thinks they'll release a special deal for limited distribution is
asking for trouble. There's no such thing as limited
distribution. Even if you limit the number of times a fantastic deal
can be redeemed, you'll still get crushed with people hoping beyond
hope that they, too, can get a PlayStation Twelve for $99.
</p>
</div>
</div>
</div>

<div id="outline-container-org2e9d901" class="outline-3">
<h3 id="org2e9d901"><span class="section-number-3">1.7</span> Scaling Effects</h3>
<div class="outline-text-3" id="text-1-7">
<p>
Scaling effects arise when components in a system scale at different
rates. This is especially important to consider when moving from
development environments to production.
</p>
</div>

<div id="outline-container-org2571814" class="outline-4">
<h4 id="org2571814"><span class="section-number-4">1.7.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-7-1">
<p>
<i>Examine production versus QA environments to spot Scaling Effects.</i>
You get bitten by Scaling Effects when you move from small one-to-one
development and test environments to full-sized production
environments. Patterns that work fine in small environments or
one-to-one environments might slow down or fail completely when you
move to productions sizes.
</p>

<p>
<i>Watch out for point-to-point communication.</i> Point-to-point
communication scales badly, since the number of connections increases
as the square of the number of participants. Consider how large your
system can grow while still using point-to-point connections - it
might be sufficient. Once you're dealing with tens of servers, you
will probably need to replace it with some kind of one-to-many
communication.
</p>
</div>
</div>
</div>

<div id="outline-container-org6ce812f" class="outline-3">
<h3 id="org6ce812f"><span class="section-number-3">1.8</span> Unbalanced Capacities</h3>
<div class="outline-text-3" id="text-1-8">
<p>
The Unbalanced Capacity antipattern arises when there are different
levels of capacity at different layers of a system. E.g. if the
front-end servers could handle 1,000 users but the back-end can only
handle 5,00.
</p>
</div>

<div id="outline-container-org61b72ce" class="outline-4">
<h4 id="org61b72ce"><span class="section-number-4">1.8.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-8-1">
<p>
<i>Examine server and thread counts.</i> In development and QA, your system
probably looks like one or two servers, and so do all the QA versions
of other systems you call. In production, the ratio might be more like
ten to one instead of one to one. Check the ratio of front-end to
backend servers, along with the numbers of threads each side can
handle in production, compared to QA.
</p>

<p>
<i>Observe near Scaling Effects and users.</i> Unbalanced Capacities is a
special case of Scaling Effects: one side of a relationship scales up
much more than the other side. A change in traffic patterns - season,
market-drive, or publicity-driven - can cause a usually benign
front-end system to suddenly flood a back-end system, in much the same
way as a hot Reddit post or celebrity tweet causes traffic to suddenly
flood websites.
</p>

<p>
<i>Virtualize QA and scale it up.</i> Even if your production environment
is a fixed size, don't let your QA languish at a measly pair of
servers. Scale it up. Try test cases where you scale the caller and
provider to different ratios. You should be able to automate this
through your data center automation tools.
</p>

<p>
<i>Stress both sides of the interface.</i> If you provide the back-end
system, see what happens if it suddenly gets ten times the
highest-ever demand, hitting the most expensive transaction. Does it
fail completely? Does it slow down and recover? If you provide the
front-end system, see what happens if calls to the bend end stop
responding or get very slow.
</p>
</div>
</div>
</div>

<div id="outline-container-orga22b133" class="outline-3">
<h3 id="orga22b133"><span class="section-number-3">1.9</span> Dogpile</h3>
<div class="outline-text-3" id="text-1-9">
<p>
A dogpile can happen when the steady-state load of an application is
different than periodic or startup load.
</p>

<p>
Examples:
</p>
<ul class="org-ul">
<li>Cache clearing</li>
<li>Jobs</li>
<li>Config changes</li>
</ul>
</div>

<div id="outline-container-org1435834" class="outline-4">
<h4 id="org1435834"><span class="section-number-4">1.9.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-9-1">
<p>
<i>Dogpiles force you to spend too much to handle peak demand.</i> A
dogpile concentrates demands. It requires a higher peak capacity than
you'd need if you spread the surge out.
</p>

<p>
<i>Use random clock slew to diffuse the demand.</i> Don't set all your cron
jobs for midnight or any other on-the-hour time. Mix them up to spread
the load out.
</p>

<p>
<i>Use increasing backoff times to avoid pulsing.</i> A fixed retry
interval will concentrate demand from callers on that period. Instead,
use a backoff algorithm so different callers will be at different
points in their backoff periods/
</p>
</div>
</div>
</div>


<div id="outline-container-org89617f8" class="outline-3">
<h3 id="org89617f8"><span class="section-number-3">1.10</span> Force Multiplier</h3>
<div class="outline-text-3" id="text-1-10">
<p>
Automation can act as a force multiplier in a bad way. When automated
systems go haywire, they can start shutting down services and doing
things that are unexpected.
</p>
</div>

<div id="outline-container-orgfb38bc5" class="outline-4">
<h4 id="orgfb38bc5"><span class="section-number-4">1.10.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-10-1">
<p>
<i>Ask for help before causing havoc.</i> Infrastructure management tools
can make very large impacts very quickly. Build limiters and
safeguards into them so they won't destroy your whole system at once.
</p>

<p>
<i>Beware of lag time and momentum.</i> Actions initiated by automation
take time. That time is usually longer than a monitoring interval, so
make sure to account for some delay in the system's response to
action.
</p>

<p>
<i>Beware of illusions and superstitions.</i> Control systems sense the
environment, but they can be fooled. They compute an expected state
and a "belief" about the current state. Either can be mistaken.
</p>
</div>
</div>
</div>

<div id="outline-container-org9269b79" class="outline-3">
<h3 id="org9269b79"><span class="section-number-3">1.11</span> Slow Responses</h3>
<div class="outline-text-3" id="text-1-11">
<p>
Slow responses can tie up more resources and cause more problems than
a response that fails outright.
</p>
</div>

<div id="outline-container-org78725f6" class="outline-4">
<h4 id="org78725f6"><span class="section-number-4">1.11.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-11-1">
<p>
<i>Slow Responses trigger Cascading Failures.</i> Upstream systems
experiencing Slow Responses will themselves slow down and might be
vulnerable to stability problems when the response times exceed their
own timeouts.
</p>

<p>
<i>For websites, Slow Responses cause more traffic.</i> Users waiting for
pages frequently hit the Reload button, generating even more traffic
to your already overloaded system.
</p>

<p>
<i>Consider Fail Fast.</i> If your system tracks its own responsiveness,
then it can tell when it's getting slow. consider sending an immediate
error response when the average response time exceeds the system's
allowed time (or at the very least, when the average response time
exceeds the caller's timeout!).
</p>

<p>
<i>Hunt for memory leaks or resource contention.</i> Contention for an
inadequate supply of database connections produces Slow
Responses. Slow Responses also aggravate that contention, leading to a
self-reinforcing cycle. Memory leaks cause excessive effort in the
garbage collector, resulting in Slow Responses. Inefficient low-level
protocols can cause network stalls, also resulting in Slow Responses.
</p>
</div>
</div>
</div>

<div id="outline-container-orgc738f90" class="outline-3">
<h3 id="orgc738f90"><span class="section-number-3">1.12</span> Unbounded Result Sets</h3>
<div class="outline-text-3" id="text-1-12">
<p>
This is a common problem when working in development and not bothering
to check the bounds of a result set. Then when you get to production,
the result set is much bigger and causes issues.
</p>
</div>

<div id="outline-container-org18c09e8" class="outline-4">
<h4 id="org18c09e8"><span class="section-number-4">1.12.1</span> Remember This</h4>
<div class="outline-text-4" id="text-1-12-1">
<p>
<i>Use realistic data volumes.</i> Typical development and test data sets
are too small to exhibit this problem. You need production-sized data
sets to see what happens when your query returns a million rows that
turn into objects. As a side benefit, you'll also get better
information from your performance testing when you use production
sized test data.
</p>

<p>
<i>Paginate at the front end.</i> Build pagination details into your
service call. The request should include a parameter for the first
item and the count. The reply should indicate (roughly) how many
results there are.
</p>

<p>
<i>Don't rely on the data producers.</i> Even if you think a query will
never have more than an handful of results, beware: it could change
without warning because of some other part of the system. The only
sensible numbers are "zero," "one," and lots," so unless you query
selects exactly one row, it has potential to return too many. Don't
rely on the data producers to create a limited amount of data. Sooner
or later, they'll go berserk and fill up a table for no reason, and
then where will you be?
</p>

<p>
<i>Put limits into other application-level protocols.</i> Service calls,
RMI, DCOM, XML-RPC, and any other kind of request/reply call are
vulnerable to returning huge collections of objects, thereby consuming
too much memory.
</p>
</div>
</div>
</div>
</div>

<div id="outline-container-org97a3683" class="outline-2">
<h2 id="org97a3683"><span class="section-number-2">2</span> Stability patterns</h2>
<div class="outline-text-2" id="text-2">
</div>
<div id="outline-container-orgf64180b" class="outline-3">
<h3 id="orgf64180b"><span class="section-number-3">2.1</span> Timeouts</h3>
<div class="outline-text-3" id="text-2-1">
<p>
Timeouts are a very basic and fundamental pattern for
stability. Rather than waiting forever, timeout eventually and handle
the issue rather that consuming resourcing waiting.
</p>
</div>

<div id="outline-container-org3da4191" class="outline-4">
<h4 id="org3da4191"><span class="section-number-4">2.1.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-1-1">
<p>
<i>Apply Timeouts to Integration Points, Blocked Threads, and Slow
Responses.</i> The Timeouts pattern prevents calls to Integration Points
from becoming Blocked threads. thus, timeouts avert Cascading
Failures.
</p>

<p>
<i>Apply Timeouts to recover from unexpected failures.</i> When an
operation is taking too long, sometimes we don't care why&#x2026; we just
need to give up and keep moving. The Timeouts pattern lets us do that.
</p>

<p>
<i>Consider delayed retires.</i> Most of the explanations for timeout
involve problems in the network or the remote that won't be resolved
right away. Immediate retries are liable to hit the same problem and
result in another timeout. That just makes the user wait even longer
for her error message. Most of the time, you should just queue the
operation and retry it later.
</p>
</div>
</div>
</div>

<div id="outline-container-org20740f4" class="outline-3">
<h3 id="org20740f4"><span class="section-number-3">2.2</span> Circuit Breaker</h3>
<div class="outline-text-3" id="text-2-2">
<p>
The circuit breaker patter is a plan to stop excess failures and fail
fast. E.g. if the database is down, trip the circuit breaker and stop
trying for some period of time. It could be helpful to avoid a more
catastrophic failure and a dogpile.
</p>

<p>
Release It, advocates that circuit breakers should be built at the
scope of a single process.
</p>

<p>
Another relevant pattern here is the leaky bucket. The idea is that
you keep track of each fault with a counter. The counter can decrement
on a timer. If the counter goes too high we'll know that faults are
arriving too quickly and we should flip the circuit breaker.
</p>
</div>

<div id="outline-container-orge563709" class="outline-4">
<h4 id="orge563709"><span class="section-number-4">2.2.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-2-1">
<p>
<i>Don't do it if it hurts.</i> Circuit Breaker is the fundamental pattern
for protecting your system from all manner of Integration Points
problems. When there's a difficulty with Integration points, stop
calling it!
</p>

<p>
<i>Use together with Timeouts.</i> Circuit Breaker is good at avoiding
calls when Integration Points has a problem. The Timeouts pattern
indicates that there's a problem in Integration Points.
</p>

<p>
<i>Expose, track, and report state changes.</i> Popping a Circuit Breaker
always indicates something abnormal. It should be visible to
Operations. It should be reported, recorded, trended, and correlated.
</p>
</div>
</div>
</div>

<div id="outline-container-orgf2defc8" class="outline-3">
<h3 id="orgf2defc8"><span class="section-number-3">2.3</span> Bulkheads</h3>
<div class="outline-text-3" id="text-2-3">
<p>
Bulkheads are the partitions for sealing a ship. If one partition
floods, the bulkheads stop the entire ship from flooding. The software
equivalent is to partition a pool of servers into different pools so
that one pool being overloaded won't affect the entire pool.
</p>
</div>

<div id="outline-container-orgafc09a1" class="outline-4">
<h4 id="orgafc09a1"><span class="section-number-4">2.3.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-3-1">
<p>
<i>Save part of the ship.</i> The Bulkheads pattern partitions capacity to
preserve partial functionality when bad things happen.
</p>

<p>
<i>Pick a useful granularity.</i> You can partition thread pools inside an
application, CPUs in a server, or servers in a cluster.
</p>

<p>
<i>Consider Bulkheads particular with shared services models.</i> Failures
in service-oriented or microservice architectures can propagate very
quickly. If your service goes down because of a Chain Reaction, does
the entire company come to a halt? Then you'd better put in some
Bulkheads.
</p>
</div>
</div>
</div>

<div id="outline-container-org934ec45" class="outline-3">
<h3 id="org934ec45"><span class="section-number-3">2.4</span> Steady State</h3>
<div class="outline-text-3" id="text-2-4">
<p>
Production systems can run for a long time. Logs fill up, memory leaks
lead to a crash, etc. These things don't happen in QA.
</p>

<p>
Steady state is about being able to manage resources over time. " The
Steady State pattern says that for every mechanism that accumulates a
resource, some other mechanism must recycle that resource."
</p>
</div>

<div id="outline-container-org28fa93a" class="outline-4">
<h4 id="org28fa93a"><span class="section-number-4">2.4.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-4-1">
<p>
<i>Avoid fiddling.</i> Human intervention leads to problems. Eliminate the
need for recurring human intervention. Your system should run for at
least a typical deployment cycle without manual disk cleanups or
nightly restarts.
</p>

<p>
<i>Purge data with application logic.</i> DBAs can create scripts to purge
data, but they don't always know how the application behaves when data
is removed. Maintaining logical integrity, especially if you use an
ORM tool, requires the application to purge its own data.
</p>

<p>
<i>Limit caching.</i> In-memory caching speeds up applications, until it
slows them down. Limit the amount of memory a cache can consume.
</p>

<p>
<i>Roll the logs.</i> Don't keep an unlimited amount of log
files. Configure log file rotation based on size. If you need to
retain them for compliance, do it on a non-production server.
</p>
</div>
</div>
</div>

<div id="outline-container-org8fbafec" class="outline-3">
<h3 id="org8fbafec"><span class="section-number-3">2.5</span> Fail Fast</h3>
<div class="outline-text-3" id="text-2-5">
<p>
When your service isn't going to meet its SLA, it's better to fail
fast.
</p>
</div>

<div id="outline-container-orga2820b6" class="outline-4">
<h4 id="orga2820b6"><span class="section-number-4">2.5.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-5-1">
<p>
<i>Avoid Slow Responses and Fail Fast.</i> If your system cannot meet its
SLA, inform callers quickly. Don't make them wait for an error
message, and don't make them wait until they time out. That just makes
your problem into their problem.
</p>

<p>
<i>Reserve resources, verify Integration Points early.</i> In the them of
"don't do useless work," make sure you'll be able to complete the
transaction before you start. If critical resources aren't avaiable -
for example, a popped Circuit Breaker on a required callout - then
don't waste work by getting to that point. The odds of it changing
between the beginning and the middle of the transaction are slim.
</p>

<p>
<i>Use for input validation.</i> Do basic user input validatoin even before
your reserve resources. Don't bother checking out a databse
connection, fetching domain objects, populating them, and calling
<code>validate()</code> just to find out that a required parameter wasn't
entered.
</p>
</div>
</div>
</div>

<div id="outline-container-org2ddd83d" class="outline-3">
<h3 id="org2ddd83d"><span class="section-number-3">2.6</span> Let It Crash</h3>
<div class="outline-text-3" id="text-2-6">
<p>
When we get into a weird state, sometimes the best thing to do to
create stability is to crash.
</p>

<p>
There are a few preconditions for embracing the "let it crash
philosophy."
</p>

<ul class="org-ul">
<li>Limited Granularity: needs to be a boundary for crashes</li>
<li>Fast Replacement: need to be able to get to clean state quickly</li>
<li>Supervision: need to use something like <code>systemd</code> or <code>supervisord</code>
to restart a service that crashes</li>
<li>Reintegration: After restarting, we need to be able to add back into
the pool</li>
</ul>
</div>

<div id="outline-container-org8c425a0" class="outline-4">
<h4 id="org8c425a0"><span class="section-number-4">2.6.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-6-1">
<p>
<i>Crash components to save systems.</i> It may seem counterintuitive to
create system-level stability through component-level
instability. Even so, it may be the best way to get back to a known
good state.
</p>

<p>
<i>Restart fast and reintegrate.</i> The key to crashing well is to get
back up quickly. Otherwise you risk loss of service when too many
components are bouncing. Once a component is back up, it should be
reintegrated automatically.
</p>

<p>
<i>Isolate components to crash independently.</i> Use Circuit Breakers to
isolate callers from components that crash. use supervisors to
determine what the span of restarts should be. Design your supervision
tree so that crashes are isolated and don't affect unrelated
functionality.
</p>

<p>
<i>Don't crash monoliths.</i> Large processes with heavy runtimes or long
startups are not the right place to apply this pattern. applications
that couple many features into a single process are also a poor
choice.
</p>
</div>
</div>
</div>

<div id="outline-container-orgd3058d8" class="outline-3">
<h3 id="orgd3058d8"><span class="section-number-3">2.7</span> Handshaking</h3>
<div class="outline-text-3" id="text-2-7">
<p>
Handshaking is very normal in low level protocols, but less common at
the API level. Handshaking at the API level would mean that we would
check to see if an API is okay before we invoke it. In practice this
could be achieved through good health checks and load balancing.
</p>
</div>


<div id="outline-container-org9834a62" class="outline-4">
<h4 id="org9834a62"><span class="section-number-4">2.7.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-7-1">
<p>
<i>Create cooperative demand control.</i> Handshaking between a client and
a server permits demand throttling to serviceable levels. Both the
client and the server must be built to perform handshaking. Most
common application-level protocols do not perform handshaking.
</p>

<p>
<i>Consider health checks.</i> Use health checks in clustered or
load-balanced services as a way for instances to handshake with the
load balancer.
</p>

<p>
<i>Build handshaking into your own low-level protocols.</i> If you create
your own socket-based protocol, build handshaking into it so that the
endpoints can each inform the other when they are not ready to accept
work.
</p>
</div>
</div>
</div>

<div id="outline-container-orgce1179c" class="outline-3">
<h3 id="orgce1179c"><span class="section-number-3">2.8</span> Test Harnesses</h3>
<div class="outline-text-3" id="text-2-8">
<p>
Test harness is a tool that could be used to test various failure
conditions that violate various protocols. It's a service that's
purpose built to misbehave. Each port could exhibit a different
behavior. The books lists a bunch of failures that a socket could exhibit:
</p>

<ul class="org-ul">
<li>It can be refused.</li>
<li>It can sit in a listen queue until the caller times out.</li>
<li>The remote end can reply with a SYN/ACK and then never send any
data.</li>
<li>The remote end can send nothing but RESET packets.</li>
<li>The remote end can report a full received window and never drain the
data.</li>
<li>The connection can be established, but the remote end never sends a
byte of data.</li>
<li>The connection can be established, but packets could be lost,
causing retransmit delays.</li>
<li>The connection can be established, but the remote end never
acknowledges receiving a packet, causing endless retransmits</li>
<li>The service can accept a request, send response headers (supposing
HTTP), and never send the response body.</li>
<li>The service can send one byte of the response every thirty seconds.</li>
<li>The service can send a response of HTML instead of the expected XML.</li>
<li>The service can send megabytes when kilobytes are expected.</li>
<li>The service can refuse all authentication credentials.</li>
</ul>
</div>

<div id="outline-container-orgdaf3347" class="outline-4">
<h4 id="orgdaf3347"><span class="section-number-4">2.8.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-8-1">
<p>
<i>Emulate out-of-spec failures.</i> Calling real aplications lets you test
only those errors that the real application can deliberately
produce. A good test harness lets you simulate all sorts of messy,
real-world failures.
</p>

<p>
<i>Stress the caller.</i> The test harness can produce slow responses, no
responses, or garbage responses. then you can see how your application
reacts.
</p>

<p>
<i>Leverage shared harnesses for common failures.</i> You don't necessarily
need a separate test harness for each integration point. A "killer"
server can listen to several ports, creating different failure modes
depending on which port you connect to.
</p>

<p>
<i>Supplement, don't replace, other testing methods.</i> The Test Harness
pattern augments other testing methods. It does not replace unit
tests, acceptance tests, penetration tests, and so on. Each of those
techniques help verify functional behavior. A test harness helps
verify "nonfunctional" behavior while maintaining isolation from the
remote systems.
</p>
</div>
</div>
</div>

<div id="outline-container-org0d53db8" class="outline-3">
<h3 id="org0d53db8"><span class="section-number-3">2.9</span> Decoupling Middleware</h3>
<div class="outline-text-3" id="text-2-9">
<p>
The idea behind decoupling middleware is that we would no longer need
to rely on synchronous communications. HTTP APIs can cause cascading
failures in scenarios where everyone is sitting around waiting for
something.
</p>
</div>

<div id="outline-container-org288336b" class="outline-4">
<h4 id="org288336b"><span class="section-number-4">2.9.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-9-1">
<p>
<i>Decide at the last responsible moment.</i> Other stability patterns can
be implemented without large-scale changes to the design or
architecture. Decoupling middleware is an architecture decision. It
ripples into every part of the system. This is one of the nearly
irreversible decisions that should be made early rather than late.
</p>

<p>
<i>Avoid many failure modes through total decoupling.</i> The more fully
you decouple individual servers, layers, and applications, the fewer
problems you will observe with Integration Points, Cascading Failures,
Slow Responses, and Blocked Threads. You'll find that decoupled
applications are also more adaptable, since you can change any of the
participants independently of others.
</p>

<p>
<i>Learn many architectures, and choose among them</i>. Not every system
needs to look like a three-tier application with a relational
database. Learn many architectural styles, and select the best
architecture for the problem at hand.
</p>
</div>
</div>
</div>

<div id="outline-container-org44d8874" class="outline-3">
<h3 id="org44d8874"><span class="section-number-3">2.10</span> Shed Load</h3>
<div class="outline-text-3" id="text-2-10">
<p>
"When load gets too high, start to refuse new requests for work." In
order to avoid slow responses, we can take action to drop traffic when
we're failing to meet SLA.
</p>
</div>

<div id="outline-container-org8565fad" class="outline-4">
<h4 id="org8565fad"><span class="section-number-4">2.10.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-10-1">
<p>
<i>You can't out-scale the world.</i> No matter how large your
infrastructure or how fast you can scale it, the world has more people
and devices than you can support. If your service is exposed to
uncontrolled demand, then you need to be able to shed load when the
world goes crazy on you.
</p>

<p>
<i>Avoid slow responses using Shed Load.</i> Creating slow responses is
being a bad citizen. Keep your response times under control rather
than getting so slow that callers time out.
</p>

<p>
<i>Use load balancers as shock absorbers.</i> Individual instances can
report HTTP 503 to get some breathing room. Load balancers are good at
recycling connections very quickly.
</p>
</div>
</div>
</div>

<div id="outline-container-org9406bda" class="outline-3">
<h3 id="org9406bda"><span class="section-number-3">2.11</span> Create Back Pressure</h3>
<div class="outline-text-3" id="text-2-11">
<p>
With unbounded queues, we can run into issues because as the queue
fills, response time increases. One way to help combat this is to use
bounded queues when handling transactions. If the queue is bounded, we
have to decide what to do with requests once the queue has filled and
those are options are what will create back pressure.
</p>

<ul class="org-ul">
<li>Pretend to accept the new item but actually drop it on the floor.</li>
<li>Actually accept the new item and drop something else from the queue
on the floor.</li>
<li>Refuse the item.</li>
<li>Block the producer until there is room in the queue.</li>
</ul>
</div>

<div id="outline-container-org2e8e69e" class="outline-4">
<h4 id="org2e8e69e"><span class="section-number-4">2.11.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-11-1">
<p>
<i>Back Pressure creates safety by slowing down consumers.</i> Consumers
will experience slowdowns. The only alternative is to let them crash
the provider.
</p>

<p>
<i>Apply Back Pressure with a system boundary.</i> Across boundaries, look
at load shedding instead. This is especially true when the Internet at
large is your user base.
</p>

<p>
<i>Queues must be finite for response times to be finite.</i> You only have
a few options when a queue is full. All of them are unpleasant: drop
data, refuse work, or block. Consumers must be careful not to block
forever.
</p>
</div>
</div>
</div>

<div id="outline-container-org69a41d1" class="outline-3">
<h3 id="org69a41d1"><span class="section-number-3">2.12</span> Governor</h3>
<div class="outline-text-3" id="text-2-12">
<p>
The idea behind the governor is to slow automations down enough for
humans to get involved and prevent catastrophe.
</p>
</div>

<div id="outline-container-org1308a93" class="outline-4">
<h4 id="org1308a93"><span class="section-number-4">2.12.1</span> Remember This</h4>
<div class="outline-text-4" id="text-2-12-1">
<p>
<i>Slow things down to allow intervention.</i> When things are about to go
off the rails, we often find automation tools pushing the throttle to
its limit. Humans are better at situational thinking, so we need to
create opportunities for us to intervene.
</p>

<p>
<i>Apply resistance in the unsafe direction.</i> Some actions are
inherently unsafe. Shutting down, deleting, blocking things&#x2026;these
are all likely to interrupt service. Automation will make them go
fast, so you should apply Governor to provide humans with time to
intervene.
</p>

<p>
<i>Consider a response curve.</i> Actions may be safe within a defined
range. Outside that range they should encounter increasing resistance
by slowing down the rate by which they can occur.
</p>
</div>
</div>
</div>
</div>

<div id="outline-container-orgd1b8945" class="outline-2">
<h2 id="orgd1b8945"><span class="section-number-2">3</span> Themes</h2>
<div class="outline-text-2" id="text-3">
</div>
<div id="outline-container-org4524bec" class="outline-3">
<h3 id="org4524bec"><span class="section-number-3">3.1</span> QA</h3>
<div class="outline-text-3" id="text-3-1">
<ul class="org-ul">
<li>Testing and QA isn't enough to "prove that software is ready for the
real world."</li>
<li>Software needs to be designed for production. Most development "aims
to survive the artificial realm of QA, not the real world of
production."</li>
<li>"Systems built for QA often require so much ongoing expense, in the
form of operations cost, downtime, and software maintenance that
they never reach profitability"</li>
<li>Bugs are going to happen. It's not realistic to drive them all
out. Since we can't eliminate all of the bugs, we need to make sure
that we can "survive" the bugs.</li>
<li>"Unbalanced capacities are another problem rarely observed during
QA"</li>
<li>Stability Patterns will not help your product pass QA</li>
<li>"Undeployed code is unfinished inventory. It has unknown bugs. It
may break scaling or cause production downtime"</li>
</ul>
</div>
</div>


<div id="outline-container-orgf4a6f89" class="outline-3">
<h3 id="orgf4a6f89"><span class="section-number-3">3.2</span> Clutter</h3>
<div class="outline-text-3" id="text-3-2">
<p>
Is all the clutter necessary? The clutter and hairy code becomes
necessary when the target is making for "production" rather than QA.
</p>
</div>
</div>

<div id="outline-container-org2b88669" class="outline-3">
<h3 id="org2b88669"><span class="section-number-3">3.3</span> Learning</h3>
<div class="outline-text-3" id="text-3-3">
<ul class="org-ul">
<li>Deploying to production begins the "learning process" much faster</li>
<li>In the beginning of a project, we're most ignorant, but that's when
we have to make some of the most important decisions. The idea
reminds me of Dunning Krueger effect</li>
</ul>
</div>
</div>

<div id="outline-container-org120c4aa" class="outline-3">
<h3 id="org120c4aa"><span class="section-number-3">3.4</span> Networking</h3>
<div class="outline-text-3" id="text-3-4">
<p>
A lot of the content in the book makes me think that there's a lot of
power in developers being aware of network design and networking in
general. E.g. a service that listens on port 8080 could more
sophisticated if it listens on port 8080 for a specific adapter. In
that case, we could handle different adapters differently and there
could be different access and permissions for different
adapters. E.g. The control plane could respond specifically on certain
networks.
</p>
</div>
</div>

<div id="outline-container-orge72e0f6" class="outline-3">
<h3 id="orge72e0f6"><span class="section-number-3">3.5</span> DevOps</h3>
<div class="outline-text-3" id="text-3-5">
<p>
"There is a mental shift from ownership of the domain to offering a
service to customers." This is something we're still really trying
adopt. It's hard to go from owning "releases" to thinking about
offering a release service to customers.
</p>
</div>
</div>
</div>



<div id="outline-container-org9fbe3ea" class="outline-2">
<h2 id="org9fbe3ea"><span class="section-number-2">4</span> Thoughts / Random Notes</h2>
<div class="outline-text-2" id="text-4">
<p>
"Enterprise software must be cynical. Cynical software expects bad
things to happen and is never surprised when they do." I really like
the idea of "cynical software." My default is often to by optimistic
(assuming the network will work, assume the API will respond, assume
the database will be up). A major theme of the book is that in order
to have stable systems, you have to write code that plans for the
worst. "Cynical software should handle violations of form and
function, such as badly formed headers or abruptly closed
connections."
</p>

<p>
If we design software without thinking about and planning for the
various failure modes, we'll get unpredictable failure modes. The book
talks about the idea of "crumple zones" in cars. The crumple zone in
the car protects the passengers by failing.
</p>

<p>
There are two different camps of thought on how to handle <i>faults</i>:
</p>

<ul class="org-ul">
<li>Fault Tolerance: We should catch exceptions, check error-codes and
try to keep faults from turning to errors.</li>
<li>Let it Crash: Fault-tolerance is probably too hard and it would be
better to restart and return to a known state.</li>
</ul>

<p>
The book mentions the idea of a <a href="https://en.wikipedia.org/wiki/Weak_reference">weak reference</a>. I hadn't heard of that
concept before but it seems like it could be very useful. It seems
especially useful in the situation when we might be storing a session
or other caching scenarios.
</p>

<p>
Software engineering and development is more than just adding
features. We have to have software that doesn't crash, lose data,
violate privacy, etc.
</p>

<p>
In an incident, restoring service has to take priority over doing an
investigation. E.g. it might make more sense to "just restart" if
there is a chance it would bring back a system. We can do
investigation later.
</p>

<p>
Launching a new system can be like having a newborn. You can't sleep
because it wakes you up at night. I like that concept. In the early
phases of a new system, stuff is going to go wrong and wake you up.
</p>

<p>
Avoid using HTTP client libraries that try to map directly to
objects. Treat responses as raw data until we've confirmed it meets
expectations.
</p>

<p>
<code>TIME_WAIT</code> is a delay period before a socket can be reused. It's
apparently to prevent <a href="https://en.wikipedia.org/wiki/Bogon_filtering">Bogons</a>.
</p>

<p>
"Do the simplest thing that will work." Is an XP idea that I hadn't
heard in a while. <a href="http://wiki.c2.com/?DoTheSimplestThingThatCouldPossiblyWork">More info</a>.
</p>

<p>
Recovery-Oriented Computing:
</p>
<ul class="org-ul">
<li>Failures are inevitable, in both hardware and software.</li>
<li>Modeling and analysis can never be sufficiently complete. A priori
prediction of all failure modes is not possible.</li>
<li>Human action is a major source of system failures</li>
</ul>

<p>
Layers of concern:
</p>
<ul class="org-ul">
<li>Operations: Security, availability, capacity, status, communication</li>
<li>Control Plane: System monitoring, deployment, anomaly detection, features</li>
<li>Interconnect: Routing, load balancing, failover, traffic management</li>
<li>Instances: Service, processes, components, instance monitoring,</li>
<li>Hardware, VMs, IP addresses, physical network</li>
</ul>

<p>
"Only make production builds on a CI server, and have it put the
binary into a safe repository that nobody can write into."
</p>

<p>
"If your organization treats load balancers as "those things over
there" that some other team manages, then you might even think about
implementing a layer of software load balancing under your control,
entirely behind the hardware load balancers in the network"
</p>

<p>
Things to log and monitor:
</p>
<ul class="org-ul">
<li>Traffic indicators: Page requests, page requests total, transaction
counts, concurrent sessions</li>
<li>Business transaction, for each type: Number processed, number
aborted, dollar value, transaction aging, conversion rate,
completion rate.</li>
<li>Users: Demographics or classification, technographics, percentage of
users who are registered, number of users, usage patterns, errors
encountered, successful logins, unsuccessful logins</li>
<li>Resource pool health: Enable state, total resources, resources
checked out, high water mark, number of resources created, number of
resource destroyed, number of times checked out, number of threads
blocked waiting for a resource, number of times a thread has blocked
waiting.</li>
<li>Database connection health: Number of SQL Exceptions thrown, number
of queries, average response time to queries</li>
<li>Data consumption: Number of entities or rows present, footprint in
memory and on disk</li>
<li>Integration point health: State of circuit breaker, number of
timeouts, number of requests, average response time, number of good
responses, number of network errors, number of protocol errors,
number of application errors, actual IP address of the remote
endpoint, current number of concurrent requests, concurrent request
high water mark.</li>
<li>Cache health: Items in cache, memory used by cache, cache hit rate,
items flushed by garbage collector, configured upper limit, time
spend creating items</li>
</ul>

<p>
"In many organizations deployment is ridiculously painful, so it's a
good place to start making life better."
</p>

<p>
<a href="https://tools.ietf.org/html/rfc761#section-2.10">Postel's</a> robustness principle, "Be conservative in what you do, be
liberal in what you accept from others." The robustness principle can
be articulated for services by talking about what changes are
acceptable and unacceptable
</p>

<ul class="org-ul">
<li>Unacceptable
<ul class="org-ul">
<li>Rejecting a network protocol that previously worked</li>
<li>Rejecting request framing or content encoding that previously worked</li>
<li>Rejecting request syntax that previously worked</li>
<li>Rejecting request routing (whether URL or queue) that previously worked</li>
<li>Adding required fields to the request</li>
<li>Forbidding optional information in the request that was allowed before</li>
<li>Removing information from the response that was previously guaranteed</li>
<li>Requiring an increased level of authorization</li>
</ul></li>
<li>Acceptable
<ul class="org-ul">
<li>Require a subset of the previously required parameters</li>
<li>Accept a superset of the previously accepted parameters</li>
<li>Return a superset of the previously returned values</li>
<li>Enforce a subset of the previously required constrained on the parameters</li>
</ul></li>
</ul>

<p>
"Thrashing" is an interesting term that came up in reference to pilot
induced oscilation. When there is a delay between your test/impulse
and observable behavior it can cause thrashing.
</p>

<p>
"Paradoxically, the key to making evolutionary architecture work is
failure. You have to try different approaches to similar problems and
kill the ones that are less successful." If you two products or
services and one is working and one is not there are some options we
can take:
</p>

<ul class="org-ul">
<li>Keep both services running</li>
<li>Take resources from the successful product and make the broken product better</li>
<li>Delete the broken product and move the resources somewhere else</li>
</ul>

<p>
I'll often end up doing the 2nd option inadvertently. It's helpful to
think that if we're evolutionary, we should strongly consider killing
the broken things.
</p>

<p>
"No Coordinated Deployments"&#x2026; "If you ever find that you need to
update both the provider and caller of a service interface at the same
time, it's a warning sign that those services are strongly coupled."
</p>

<p>
The idea behind the two pizza team isn't to have a small group of
coders, it's to have a completely self-sufficient team that can push
things all the way to production.
</p>

<p>
The idea of <i>Explicit Context</i> was useful. One example is to change
from using an "itemId" that's a number to one that's a full URL that
could be resolved to find out more information. It's also more
flexible in scenarios where IDs need to be merged from different
providers.
</p>

<p>
Drift: In systems there are three forces: safety, capacity, and
economy. There is always business pressure to increase economic
return. People are lazy so there is always pressure to not work at the
capacity limit. That means the system as a whole will drift toward the
safety limit. Chaos engineering fits here by stressing the systems so
there is a force to make things safer.
</p>
</div>
</div>

<div id="outline-container-orgaf4fd50" class="outline-2">
<h2 id="orgaf4fd50"><span class="section-number-2">5</span> Useful Definitions</h2>
<div class="outline-text-2" id="text-5">
<p>
<i>Transaction</i>: An abstract unit of work processed by the system.
</p>

<p>
<i>System</i>: The complete, interdependent set of hardware, applications,
and services required to process transactions for users
</p>

<p>
<i>Dedicated System</i>: A system that processes only one type of
transaction.
</p>

<p>
<i>Mixed Workload</i>: a combination of different transaction types
processed by a system.
</p>

<p>
<i>Impulse</i>: A rapid shock to a system
</p>

<p>
<i>Stress</i>: Force applied to a system over time
</p>

<p>
<i>Strain</i>: A change in shape due to stress (higher RAM, excess I/O,
etc)
</p>

<p>
<i>Fault</i>: A condition that creates an incorrect internal state
</p>

<p>
<i>Error</i>: Visibly incorrect behavior
</p>

<p>
<i>Failure</i>: An unresponsive system
</p>

<p>
<i>Capacity</i>: The maximum throughput your system can sustain under a
given workload while maintaining acceptable performance.
</p>

<p>
<i>Control Plane</i>: Software that exists to help manage the
infrastructure and applications rather than directly delivering user
functionality.
</p>

<p>
<i>Service</i>: A collection of processes across machines that work
together to deliver a unit of functionality.
</p>

<p>
<i>Instance</i>: An installation on a single machine (container, virtual,
or physical) out of a load-balanced array of the same executable.
</p>

<p>
<i>Executable</i>: An artifact that a machine can launch as a process and
created by a build process.
</p>

<p>
<i>Process</i>: An operating system process running on a machine; the
runtime image of an executable.
</p>

<p>
<i>Installation</i>: The ececutable of any attendant directories,
configuration files, and other resource as they exist on a machine.
</p>

<p>
<i>Deployment</i>: The act of creatin an installation on a machine.
</p>
</div>
</div>

<div id="outline-container-org82abe0a" class="outline-2">
<h2 id="org82abe0a"><span class="section-number-2">6</span> Further Reading List</h2>
<div class="outline-text-2" id="text-6">
<ul class="org-ul">
<li><a href="https://www.osha.gov/dts/osta/otm/otm_iv/otm_iv_4.html#5">https://www.osha.gov/dts/osta/otm/otm_iv/otm_iv_4.html#5</a></li>
<li><a href="https://en.wikipedia.org/wiki/Little%27s_law">https://en.wikipedia.org/wiki/Little%27s_law</a></li>
<li><a href="http://roc.cs.berkeley.edu/">http://roc.cs.berkeley.edu/</a></li>
<li><a href="http://www.openapis.org">http://www.openapis.org</a> + <a href="http://swagger.io/swagger-ui">http://swagger.io/swagger-ui</a></li>
<li><a href="https://dl.acm.org/citation.cfm?id=361623">https://dl.acm.org/citation.cfm?id=361623</a></li>
<li>Drift into Failure - Sidney Dekker</li>
</ul>
</div>
</div>
</div>
