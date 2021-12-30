<div id="content">
<h1 class="title">O'Reilly Software Architecture Conference 2019
</h1>
<p>
I wanted to summarize and share all of the notes and takeaways that I
had from the <a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/proceedings">O'Reilly Software Architecture Conference</a>. Below are
pretty much all of the notes I took while I was there.
</p>


<div id="org72010e6" class="figure">
<p><img class="img-fluid" src="../img/DypZgmuXcAAQRCt.jpg" alt="DypZgmuXcAAQRCt.jpg">
</p>
<p><span class="figure-number">Figure 1: </span>It took me a long time to select which ribbons I wanted</p>
</div>

<div id="outline-container-orgc0026cf" class="outline-2">
<h2 id="orgc0026cf"><span class="section-number-2">1</span> Themes</h2>
<div class="outline-text-2" id="text-1">
<ul class="org-ul">
<li>Tech skills are at most 50% of what's needed to succeed</li>
<li>Tech specific obsessions is dangerous</li>
<li><b>Architecture</b> and <b>technology</b> aren't the same thing.</li>
<li><b>Everything is code</b> and the lessons of software need to be applied to
the other domains.</li>
<li>Security is a risk model like home insurance</li>
<li>Everyone wants to be able to move faster. Everyone is talking about
speed</li>
<li>Layers are being broken down in favor of smaller units of
production
<ul class="org-ul">
<li>Reducing meetings, coordiation accross teams is desirable</li>
</ul></li>
<li>Infrastructure teams need to have a product mindset where the
customer is an internal team</li>
<li>The absense of product thinking can lead to disasters. This was a
theme in many talks</li>
<li>The traditional role of the architect is more and less important at
the same time. Less important because we're less able to centrally
plan and design everything, but more important because everything is
software&#x2026; Architects are struggling to figure out how to remain
relevant??</li>
<li>Start with something simple (imperfect) and iterate it and improve</li>
</ul>
</div>
</div>

<div id="outline-container-org53f96f6" class="outline-2">
<h2 id="org53f96f6"><span class="section-number-2">2</span> Architecting IT transformation</h2>
<div class="outline-text-2" id="text-2">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74391">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74391</a></li>
<li><a href="https://twitter.com/praetorian/status/1092789318966489088">https://twitter.com/praetorian/status/1092789318966489088</a></li>
</ul>

<p>
Architects have an image in their head something like "The Architect"
like from the Matrix. But engineers might see architects more like
senile, overpaid, out of touch people that can't code.
</p>

<p>
The role of the architect is to build connections between the "engine
room" and the "penthouse". Basically, we need to connect the people
actually doing stuff with the senior management.
</p>

<p>
In the old model, we used to be able to specify exactly what we want
and build it. Then we would go into maintenance mode. With the new
model, there is no specification. There is no steady state. We're
always changing and moving forward. The idea reminds me of the idea of
the vX. There is no well-defined, well-specified target that we're
actually going to reach.
</p>

<p>
With the old model we were more concerned about specs, budgets and
timelines. With the new model, we're going to speak more in relative
terms like burn rate and cost per hour. The old model put us in a
position where we need to "guess right" and the new model requires
that we <b>learn fast</b>. The old model is really much more structural and
we're moving to a world that's much more dynamic. In the old model,
architects focused most on scale, but now the focus is more on speed.
</p>

<p>
One big change that the speaker mentioned is that as the world moves
faster and faster, the benefits of a layered architecture
decrease.
</p>

<p>
Further reading here: <a href="https://architectelevator.com/blog/">https://architectelevator.com/blog/</a>
</p>
</div>
</div>

<div id="outline-container-orgf074497" class="outline-2">
<h2 id="orgf074497"><span class="section-number-2">3</span> Career advice for architects</h2>
<div class="outline-text-2" id="text-3">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/72255">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/72255</a></li>
<li><a href="https://twitter.com/praetorian/status/1092794465037758468">https://twitter.com/praetorian/status/1092794465037758468</a></li>
</ul>

<p>
This was a brief presentation and she mostly talked about the skills
that you need to be an architect. It was interesting that so few of
the skills were technical in nature. She listed a few things out:
</p>

<ol class="org-ol">
<li>Asking questions (and listening)</li>
<li>Good communication skills</li>
<li>Adaptability and being open minded</li>
<li>Prioritization</li>
<li>Tech Skills</li>
</ol>

<p>
She came up with an interesting metaphor as it related to tech
skills. Upgrading your own tech skills is like buying a faster
computer. But Ideally you want to go distributed which means training
others. The fastest path to being 10x is to train 9 others.
</p>

<p>
In terms of training others she listed out a few things:
</p>

<ol class="org-ol">
<li>Pair programming (this was her number 1)</li>
<li>Community Support&#x2026; Open source involvement</li>
<li>Internal learning sessions</li>
<li>Book Clubs</li>
<li>Conferences</li>
</ol>

<p>
She really did emphasize the importance of pair programming. She also
suggested an alternative for peole who don't really want to do a lot
of pair programming which is <b>mob programming</b>. Pair programming for
NxJ is actually a good fit because of TPs, but I've never really done
it for more than a few hours.
</p>

<p>
The details of her talks in general are at <a href="https://bit.ly/careerFP">https://bit.ly/careerFP</a>
</p>
</div>
</div>

<div id="outline-container-org73a3ad2" class="outline-2">
<h2 id="org73a3ad2"><span class="section-number-2">4</span> Beyond accidental architecture</h2>
<div class="outline-text-2" id="text-4">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71774">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71774</a></li>
<li><a href="https://twitter.com/praetorian/status/1092815198686232576">https://twitter.com/praetorian/status/1092815198686232576</a></li>
<li><a href="https://twitter.com/praetorian/status/1092829282156593153">https://twitter.com/praetorian/status/1092829282156593153</a></li>
</ul>

<p>
"Accidental architecture" is the tendency of complex systems to
degrade over time due to various reasons. The accidental architecture
is an <b>emergent</b> phenomenon that occurs when we lose sight of the
important stuff that went into the original architecture.
</p>

<p>
A very interesting distinction is that there is a difference between
technology and architecture. Technology is more based on <b>preference</b>
and architecture is focused on the important stuff for the business.
</p>

<p>
He had some cool ideas from other authors I think. In particular
from Neal Ford: "Meta-work is more interesting than work. If there
isn't a problem in front of us, we'll create one."
</p>

<p>
The idea is similar to concepts like navel gazing and pontification.
</p>

<p>
An interesting idea that this guy mentioned is that he rails against
the hobbyist mindset. I.e. when engineers pick technologies because
they think it will be cool and they're personally interested in it. I
think it's situational, but I understand where he is coming from. I
think the hobbyist mindset can be helpful to keep engineers
interested, active and engaged.
</p>

<p>
He also reference this type of diagramming which might be easier for
people to learn than traditional UML.
</p>

<p>
<a href="https://c4model.com/">https://c4model.com/</a>
</p>
</div>
</div>

<div id="outline-container-org53b40d3" class="outline-2">
<h2 id="org53b40d3"><span class="section-number-2">5</span> Building a service delivery infrastructure</h2>
<div class="outline-text-2" id="text-5">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74523">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74523</a></li>
<li><a href="https://twitter.com/praetorian/status/1092856655346388992">https://twitter.com/praetorian/status/1092856655346388992</a></li>
<li><a href="https://twitter.com/praetorian/status/1092856655346388992">https://twitter.com/praetorian/status/1092856655346388992</a></li>
<li><a href="https://twitter.com/praetorian/status/1092861234666450944">https://twitter.com/praetorian/status/1092861234666450944</a></li>
</ul>

<p>
I enjoyed this talk. Lots of good ideas.
</p>

<p>
One of the key ideas is that "service delivery" can be a "product"
within the organization. We're organized around the idea of "release
engineering" but the idea hasn't really worked well. But there is the
idea that there is infrastructure needed to take code from
development, and get it into production. That process should be
thought of as a product.
</p>

<p>
The role of the "architect" has expanded greatly because everything is
software now. The interesting thing is not that infrastructure people now
need to code, but that infrastructure folks now can use the best
practices from software: thin slicing, yagni, pairing, acceptance
criteria, DDD, and TDD.
</p>

<p>
In their talk they mentioned this article that they wrote which interests me a lot:
<a href="https://www.thoughtworks.com/insights/blog/fitness-function-driven-development">https://www.thoughtworks.com/insights/blog/fitness-function-driven-development</a>
</p>

<p>
They also reference some of these IT spend number's.
<a href="https://www.spiceworks.com/marketing/state-of-it/report/">https://www.spiceworks.com/marketing/state-of-it/report/</a>
</p>

<p>
They basically said that everything is code at all levels. The only
part that can't be coded away is the CxO level stuff. And for that
level they had some metrics in mind like:
</p>

<ul class="org-ul">
<li>Evolvability</li>
<li>Mean time to resolution</li>
<li>Time to market</li>
</ul>
</div>
</div>

<div id="outline-container-org6f8cae0" class="outline-2">
<h2 id="org6f8cae0"><span class="section-number-2">6</span> Security principles for the working architect</h2>
<div class="outline-text-2" id="text-6">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71632">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71632</a></li>
<li><a href="https://twitter.com/praetorian/status/1092861234666450944">https://twitter.com/praetorian/status/1092861234666450944</a></li>
<li><a href="https://twitter.com/praetorian/status/1092861234666450944">https://twitter.com/praetorian/status/1092861234666450944</a></li>
</ul>

<p>
Security is our protection against 3 M's: Malice, Mistakes, and Mischance.
</p>

<p>
Traditionally, there has been a separation between security
engineering and software engineering. In the gulf between the two,
there is this desert of responsibility where no one wants to take
responsibility for stuff.
</p>

<p>
For the most part, this presentation was a compilation of security
principles. Nothing really earth shattering. I think tht being
familiar with OWASP and NIST would be similar.
</p>

<p>
One of the interesting ideas that he did bring up was related to
auditing. During the talk he really stressed the importance of being
able to audit and went so far as to say if the audit fills up, the
system should stop responding rather than losing the logs. I haven't
really thought that much about this, but it's a helpful perspective.
</p>

<p>
Random, I had never heard of <a href="https://en.wikipedia.org/wiki/Port_knocking">port knocking</a>. It's a super interesting
idea.
</p>

<p>
He also had an iterative approach for security which I liked. Threat
model, find the weakest link, make it more secure, start over. It
could be an interesting iteration loop for the security team at Next
Jump to go into.
</p>

<p>
He showed this real time threat map to illustrate how much stuff is
going on <a href="https://cybermap.kaspersky.com/">https://cybermap.kaspersky.com/</a>
</p>

<p>
This was also a powerful illustration of the amount of data that's being lost
<a href="https://informationisbeautiful.net/visualizations/worlds-biggest-data-breaches-hacks/">https://informationisbeautiful.net/visualizations/worlds-biggest-data-breaches-hacks/</a>
</p>

<p>
This is book and some reference materials
<a href="https://www.viewpoints-and-perspectives.info">https://www.viewpoints-and-perspectives.info</a>
</p>
</div>
</div>

<div id="outline-container-org3778983" class="outline-2">
<h2 id="org3778983"><span class="section-number-2">7</span> Challenges with reuse within a large and diverse engineering organization: A case study</h2>
<div class="outline-text-2" id="text-7">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71572">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71572</a></li>
<li><a href="https://twitter.com/praetorian/status/1092861234666450944">https://twitter.com/praetorian/status/1092861234666450944</a></li>
</ul>

<p>
The gist of this talk is that Capital One moved to microservices and
AWS. In that journey they went from basically wild west anything goes
to having standards of some kind.
</p>

<p>
They found that vertical teams have much better ownership compared to
horizontal ones. Horizontal teams want to know the requirements and
vertical teams want to add value and satisfy the customer needs.
</p>

<p>
"We don't make money by building more pipelines" This is a common
refrain I think. Architects don't like technology for no good
reason.
</p>

<p>
Capital One's journey is super interesting and instructive. They
started with no rules and then had to rein it in. When they did rein
it in, the focus was largely on their code pipelines and their
processes for generating new skeletons.
</p>
</div>
</div>

<div id="outline-container-org732f182" class="outline-2">
<h2 id="org732f182"><span class="section-number-2">8</span> Realigning DevOps practices to support microservices: A Capital One case study</h2>
<div class="outline-text-2" id="text-8">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71960">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71960</a></li>
<li><a href="https://www.slideshare.net/secret/uNMEnkOb1QzZgH">https://www.slideshare.net/secret/uNMEnkOb1QzZgH</a></li>
</ul>

<p>
The core premise I think of this talk was that microservices allow
Capital One to move faster. They cited a lot of materials and
books. They operate out of this need to follow regulations and they
talk a lot about going to jail. E.g. if this doesn't follow the
regulations someone goes to jail. So it's very important.
</p>

<p>
They talked a lot about the false choice of speed or quality. They
invested alot in their code pipeline. Their code pipelines are the
full release process including the various environments like dev,
stage, pre-prod etc.
</p>

<p>
These guys also talked about reducing layers in order to speed things
up which goes back to the inital keynote.
</p>

<p>
The idea of code pipelines as a product is super interesting because
we could create various pipelines for different types of products with
different quality requirements. I.e a FedRAMP pipeline, a PCI pipeline,
a Sandbox Pipeline etc. These pipelines could have different processes
in various situations. E.g. the PCI pipeline requires senior approval,
but the general pipeline just requires a peer review.
</p>
</div>
</div>

<div id="outline-container-org2f103c1" class="outline-2">
<h2 id="org2f103c1"><span class="section-number-2">9</span> Design and architecture: Special dumpster fire unit</h2>
<div class="outline-text-2" id="text-9">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74392">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74392</a></li>
<li><a href="https://twitter.com/praetorian/status/1093152292524703745">https://twitter.com/praetorian/status/1093152292524703745</a></li>
</ul>

<p>
The main themes of this particular talk are summarized pretty well in
the tweet. There are some common threads that connect the big software
failures from this guy's background. In particular:
</p>

<ul class="org-ul">
<li>no incremental delivery</li>
<li>arrogant architects</li>
<li>big architecture up front</li>
<li>operating in silo (no feedback)</li>
<li>lack of product thinking</li>
<li>overly focused on cool tech</li>
</ul>

<p>
The lack of "product" thinking seems to be a common pitfall for
software teams. Another lens on this is that teams that are overly
focused on tech and perfect solutions are doomed. It's not that
different than how NxJ talks about stuff.
</p>
</div>
</div>

<div id="outline-container-org1111a04" class="outline-2">
<h2 id="org1111a04"><span class="section-number-2">10</span> Design after Agile: How to succeed by trying less</h2>
<div class="outline-text-2" id="text-10">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/72241">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/72241</a></li>
<li><a href="https://twitter.com/praetorian/status/1093158772569186304">https://twitter.com/praetorian/status/1093158772569186304</a></li>
</ul>

<p>
The main theme of this talk is that planning is important. Agile
emphasizes adaptability over planning and suffers because of this.
</p>

<p>
The basic thesis of this talk I think is that iteration and agile are
limited. Without planning you can't really make big changes. E.g. you
can't iterate your way from SVN to Git. You need planning. He also
mentioned that design itself is agile because you can plan much faster
than you can do. Doing the plan is an order of magnitude faster than
building the wrong thing. I mostly agree, but it is
situational. Planning for something that's very experimental and might
be thrown away doesn't seem like a good idea.
</p>

<p>
He quoted Eisenhower: "Plans are useless, but planing is indispensable."
</p>

<p>
He referenced this particular <a href="https://www.infoq.com/presentations/Design-Composition-Performance">talk</a>.
</p>

<p>
He put a really big emphasis on diagrams and the c4 model of
diagramming. UML is too strict in his view and ends up being
distracting and causing people to think about the wrong things. C4
Model I guess is more opened ended and easier to use to convey
information. He also advocated keeping version of the diagram in the
code so that you can see how the diagrams evolve along with the code.
</p>

<p>
His teams focus a lot on writing very clear and detailed problem
statements. They use prose as part of their design process. We've
heard of other people doing stuff like this e.g. writing a press
release before the development of your feature or product. It's also
very similar to Amazon's ideas around creating powerful narratives in
general.
</p>
</div>
</div>

<div id="outline-container-org36822af" class="outline-2">
<h2 id="org36822af"><span class="section-number-2">11</span> Roaming free: The power of reading beyond your field</h2>
<div class="outline-text-2" id="text-11">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74393">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/74393</a></li>
</ul>

<p>
The main point of this talk was to encourage software architects to
read books outside of the traditional realm of computer / technical
books. Reading outside of our own fields exposes us to new ideas that
can be useful within our own jobs.
</p>

<p>
He referenced this full Steve Jobs quote which gets at the same idea
more or less:
</p>

<blockquote>
<p>
Creativity is just connecting things. When you ask creative people how
they did something, they feel a little guilty because they didn't
really do it, they just saw something. It seemed obvious to them after
a while. That's because they were able to connect experiences they've
had and synthesize new things. And the reason they were able to do
that was that they've had more experiences or they have thought more
about their experiences than other people.
</p>

<p>
Unfortunately, that's too rare a commodity. A lot of people in our
industry haven't had very diverse experiences. So they don't have
enough dots to connect, and they end up with very linear solutions
without a broad perspective on the problem. The broader one's
understanding of the human experience, the better design we will have.
</p>
</blockquote>

<p>
Beyond that, most of the talk a list of books or examples where
software engineers came up with good ideas after being exposed to
books or ideas outside of their own field.
</p>

<p>
One of the ideas that he mentioned came from the Marine's Warfighting
book. Basically the idea is that in combat situations, the marines
push autonomy down the org chart. It sounds like a very cool idea that
I want to learn more about
</p>

<p>
There were two other ideas that he mentioned that I thought were
interesting. One is the idea of <a href="https://en.wikipedia.org/wiki/Tacit_knowledge">Tacit</a> vs Explicit knowledge. Some
things can explicitly be taught. Other stuff has to be learned by
doing. E.g. you can't really explain to someone how to ride a bike so
that's tacit knowledge. This seems like a very useful distinction.
</p>

<p>
The other idea that he mentioned which seems very interesting is this
<a href="https://en.wikipedia.org/wiki/Dreyfus_model_of_skill_acquisition">Dreyfus model</a>. The basic idea is that it's a pretty clear model for
levels of skill:
</p>

<table>


<colgroup>
<col  class="org-left">

<col  class="org-left">

<col  class="org-left">

<col  class="org-left">

<col  class="org-left">

<col  class="org-left">
</colgroup>
<thead>
<tr>
<th scope="col" class="org-left">Skill Level/ Mental Function</th>
<th scope="col" class="org-left">Novice</th>
<th scope="col" class="org-left">Advance Beginner</th>
<th scope="col" class="org-left">Competence</th>
<th scope="col" class="org-left">Proficient</th>
<th scope="col" class="org-left">Master</th>
</tr>
</thead>
<tbody>
<tr>
<td class="org-left">Recollection</td>
<td class="org-left">Non-Situational</td>
<td class="org-left">Situational</td>
<td class="org-left">Situational</td>
<td class="org-left">Situational</td>
<td class="org-left">Situational</td>
</tr>

<tr>
<td class="org-left">Recognition</td>
<td class="org-left">Decomposed</td>
<td class="org-left">Decomposed</td>
<td class="org-left">Holistic</td>
<td class="org-left">Holistic</td>
<td class="org-left">Holistic</td>
</tr>

<tr>
<td class="org-left">Decision</td>
<td class="org-left">Analytical</td>
<td class="org-left">Analytical</td>
<td class="org-left">Analytical</td>
<td class="org-left">Intuitive</td>
<td class="org-left">Intuitive</td>
</tr>

<tr>
<td class="org-left">Awareness</td>
<td class="org-left">Monitoring</td>
<td class="org-left">Monitoring</td>
<td class="org-left">Monitoring</td>
<td class="org-left">Monitoring</td>
<td class="org-left">Absorbed</td>
</tr>
</tbody>
</table>
</div>
</div>

<div id="outline-container-orgdc11a42" class="outline-2">
<h2 id="orgdc11a42"><span class="section-number-2">12</span> RESTful web microservices from the ground up</h2>
<div class="outline-text-2" id="text-12">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71663">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71663</a></li>
<li><a href="https://twitter.com/praetorian/status/1093193020265193477">https://twitter.com/praetorian/status/1093193020265193477</a></li>
<li><a href="https://twitter.com/praetorian/status/1093187898856349696">https://twitter.com/praetorian/status/1093187898856349696</a></li>
<li><a href="https://twitter.com/praetorian/status/1093181375975428097">https://twitter.com/praetorian/status/1093181375975428097</a></li>
</ul>

<p>
I enjoyed this talk. Some of the ideas were very "ivory tower" toward
the end. But there were a lot of strong ideas throughout.
</p>

<p>
He talked about APIs as a landscape and documentation like Swgger is
a way to map that landscape. His point of view is that APIs need to
have a low barrier. You shouldn't have to jump through lots of hoops.
</p>

<p>
One idea that was interesting was that the Unix philosophy applies
microservices. The high level principles and justifications are the
same as ever. Another interesting justification of microservices is
that they allow us to do a release without having a meeting.
</p>

<p>
In the old days of the monolith, the architect was the monarch. We
don't have that anymore.
</p>

<p>
One of the books that was referenced in this talk a lot was "Release
It". I think this could be a great basis for our own check list of an
"Enterprise Service". The basic gist of it is that there are a few
ideas that should be baked into the services that are critical for us:
</p>
<ul class="org-ul">
<li>Failfast</li>
<li>Timeouts</li>
<li>Circuit Breakers</li>
<li>Steady State</li>
<li>Handshaking</li>
<li>Bulkhead</li>
</ul>


<p>
I liked the way that he went on to breakdown various classes of microservices:
</p>

<ul class="org-ul">
<li>Stateless Microservices</li>
<li>Persistence Microservices</li>
<li>Aggregator microsercices</li>
</ul>

<p>
He mentioned some classes of problems like affinity (when you start a
transaction on a particular server and need to stay with that server
for the duration) that I think are important, but he didn't talk much
about solutions.
</p>

<p>
He made reference to this <a href="https://en.wikipedia.org/wiki/Fallacies_of_distributed_computing">list</a> (fallacies of distributed computing)
which I thought was really helpful and I know we can make lots of
mistakes related to this.
</p>

<p>
He also mentioned the idea of a saga which I'm pretty sure I didn't
understand at the time. It's basically a transaction pattern for long
running transactions. E.g. it's something we could be much more
deliberate about in our cart infrastructure.
</p>

<p>
<a href="https://en.wikipedia.org/wiki/Compensating_transaction">https://en.wikipedia.org/wiki/Compensating_transaction</a>
</p>

<p>
The end of the presentation got theoretical where he talked about
how there should be semantic meaning in our APIs. This means, that
like the internet it should be possible to understand / comprehend an
API that you've never seen before. He mentioned some standards for
this.
</p>

<ul class="org-ul">
<li><a href="http://stateless.co/hal_specification.html">HAL Json</a></li>
<li><a href="http://www.open-disco.org/">Open-disco</a></li>
<li><a href="http://amundsen.com/media-types/collection/">Collection Json</a></li>
</ul>
</div>
</div>

<div id="outline-container-org3950750" class="outline-2">
<h2 id="org3950750"><span class="section-number-2">13</span> Developing great architects: Creating the right environment for growth</h2>
<div class="outline-text-2" id="text-13">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71934">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71934</a></li>
</ul>

<p>
This was a very straight foward for helpful talk. For the most part,
the speaker talked about a bunch of programs that they've run within
their company and gave insights from what worked and what didn't. He
covered:
</p>

<ul class="org-ul">
<li>Book Clubs</li>
<li>Round Tables</li>
<li>Training Sessions</li>
<li>Hackathons</li>
<li>Katas</li>
<li>Shadowing</li>
</ul>

<p>
The thing I liked about the presentation is that he covered a bunch of
things that they've actively tried or are doing currently. I think a
lot of the ideas aren't particularly crazy, but it gives a solid
starting point in terms software engineering development programs.
</p>
</div>
</div>

<div id="outline-container-org22608b8" class="outline-2">
<h2 id="org22608b8"><span class="section-number-2">14</span> The well-rounded architect</h2>
<div class="outline-text-2" id="text-14">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71796">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71796</a></li>
<li><a href="https://twitter.com/praetorian/status/1093237942854782976">https://twitter.com/praetorian/status/1093237942854782976</a></li>
<li><a href="https://twitter.com/praetorian/status/1093232557385310208">https://twitter.com/praetorian/status/1093232557385310208</a></li>
<li><a href="https://twitter.com/praetorian/status/1093230434950045697">https://twitter.com/praetorian/status/1093230434950045697</a></li>
</ul>

<p>
I thought this was an interesting talk that covered basic theoretical
models of what an architect is or should be. From his point of view,
he described the architect as a role and not necessarily just a single
person. In that role, it's also possible that more than one person is
the architect or that there is no architect at all. The basic idea I
think was that the architect helps shepherd the teams and helps them
make the right choices.
</p>

<p>
He brought up the C4 Diagramming approach as well. It came up a few
times while at this conference, so I feel like it could be something
to add to our tech radar.
</p>

<p>
I tweeted the biggest punchlines I think from this particular talk,
but basically he viewd that there were 6 dimensions for an architect
and that when those dimensions are out of whack you end up with
certain problematic balances. The main qualities are:
</p>

<ul class="org-ul">
<li>Communicator</li>
<li>Leader</li>
<li>Strategic Technologist</li>
<li>Entreprenuer</li>
<li>System Focused</li>
<li>Developer</li>
</ul>

<p>
There are 4 failure patterns when these dimension get out of balance:
</p>
<ul class="org-ul">
<li>The Salesperson</li>
<li>The Ivory Tower Architect</li>
<li>The Tinkerer</li>
<li>The ADD Architect</li>
</ul>

<p>
The only other idea that he talked about that was kind of interesting
is that hey had an model of skill acquistion like the Dreyfus Model,
but felt a little easier to understand and grasp.
</p>

<ul class="org-ul">
<li>Just Starting</li>
<li>Improving</li>
<li>Capable</li>
<li>Well Known</li>
<li>Industry Leader</li>
</ul>

<p>
I'm not sure how important to is to be well-known. It's possible that
you're well known, but not that capable. Does that matter?
</p>
</div>
</div>


<div id="outline-container-orgc429cb7" class="outline-2">
<h2 id="orgc429cb7"><span class="section-number-2">15</span> 7 years of DDD: Tackling complexity in large-scale marketing systems</h2>
<div class="outline-text-2" id="text-15">
<ul class="org-ul">
<li><a href="https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71366">https://conferences.oreilly.com/software-architecture/sa-ny/public/schedule/detail/71366</a></li>
<li><a href="https://twitter.com/praetorian/status/1093278025154772993">https://twitter.com/praetorian/status/1093278025154772993</a></li>
</ul>

<p>
This talk was really interesting because it covered the evolution of
this particular architecture as they evolved in their business needs
and understanding of <a href="https://en.wikipedia.org/wiki/Domain-driven_design">Domain Driven Design</a>. I'm not particularly
familar with DDD so this was new territory for me, but it did get my
very interested. Some of the keywords like ubiquitous language and
bounded contexts seemed very powerful for designing some complicated
systems.
</p>

<p>
I liked the breakdown of layers in a system that he had:
</p>

<ul class="org-ul">
<li>Infrastructure</li>
<li>Domain Model</li>
<li>Service Layer</li>
<li>Presentation Layer</li>
</ul>

<p>
He made an interesting point about how using stored procedures caused
a big problem with their architecture at some point because it created
and implicitly bound context between DBA and developers. Duplication
was required and things could break down and get out of sync.
</p>

<p>
He used a term "distributed monolith" which was interesting. It's an
good antipattern for us to keep in mind as we develop our
microservice. Are we keeping true to the intent of microservices or
have we developed a distributed monolith.
</p>
</div>
</div>
</div>
