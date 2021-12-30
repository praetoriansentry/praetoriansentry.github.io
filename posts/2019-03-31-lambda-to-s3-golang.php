<div id="content">
<h1 class="title">Creating a Simple Go Lambda Function to Save Data to S3
</h1>

<div id="org4ac538b" class="figure">
<p><img class="img-fluid" src="../img/go-lambda.png" alt="go-lambda.png">
</p>
<p><span class="figure-number">Figure 1: </span>Basic setup for saving data to S3 with Lambda</p>
</div>


<p>
The other day, I was writing a small proof of concept survey tool
based on the HEXACO model of personality. In many cases, I would build
this as a normal three-tier application:
</p>

<ul class="org-ul">
<li>Presentation: HTML/CSS/JavaScript for administering the survey</li>
<li>Service: Some kind of service layer and simple API</li>
<li>Data/Persistence: A way to save the data</li>
</ul>

<p>
Because this was a proof of concept and I'm <a href="http://threevirtues.com/">lazy</a>, I decided to try to
short cut this a little bit.
</p>

<p>
The first short cut is on the front end. Since the page is so simple,
I implemented it as a single page application that could be served
statically out of S3 or any basic file server. Because the
presentation layer was so simple, no advanced application server like
Node or Apache is needed.
</p>

<p>
The biggest shortcut was using lambda to write raw data to S3 rather
than having a database. Normally with an application like this, I
would come up with a schema in MySQL or something like that and have a
Go/Docker service that takes JSON over HTTP input and writes it into
the database. Rather than doing that, I created a lambda function that
validates the input and writes it directly to an S3 bucket.
</p>

<p>
I probably wouldn't do something like this in many cases, but the
implementation is easy to pull together and deploy. Here is the code.
</p>

<script src="https://gist.github.com/praetoriansentry/2410a6d483f2dfa65128f2bbc6660e30.js"></script>

<p>
The other benefit here is that I don't need to run a database just to
store basic content, I can use S3 and just pay for what I'm storing.
</p>

<p>
Once the lambda function was setup and deployed, I used API Gateway to
setup a public endpoint that would call this lambda function. The only
tricky step here was to make sure there was some configuration for
CORS. Since the front-end application is just an HTML/JS site, the
calls to save data were going to be Ajax.
</p>

<p>
At this point everything worked and my data was saving successfully to
S3.
</p>
</div>
