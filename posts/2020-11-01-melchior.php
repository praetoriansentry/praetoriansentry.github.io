<div id="content">
<h1 class="title">Creating a Basic Gemini Server
</h1>
<p>
I learned about the Gemini protocol last week. I don't know why, but
the idea seemed very appealing to me. I like the idea of a simpler
network where you don't feel like you're being tracked and monitored
all of the time.
</p>

<p>
I did some looking around at the various servers that were
available. Some of them seemed more full featured and
configurable. Others were bare bones. Since my installation was going
to run inside my own home network there were a few considerations:
</p>

<ul class="org-ul">
<li>I wanted to be able to verify the code myself</li>
<li>Generally, I want it to seem secure</li>
<li>I didn't want any CGI or scripting</li>
</ul>

<p>
Those might seem like odd considerations, but I really just wanted an
extremely simple server that can run Gemini.
</p>

<div id="outline-container-orgce5736f" class="outline-2">
<h2 id="orgce5736f"><span class="section-number-2">1</span> Implementation Notes</h2>
<div class="outline-text-2" id="text-1">
<p>
<a href="https://github.com/praetoriansentry/melchior">https://github.com/praetoriansentry/melchior</a>
</p>

<p>
Based on what I wanted, I figured it was just easier to make my own
server. Part of what's so awesome about the Gemini protocol is how
simple it is. I feel like the simplicity of the protocol will
encourage innovation and development.
</p>

<p>
In the case of a simple static Gemini server, there is very little
that needs to be implemented. Basically comes down to:
</p>

<ul class="org-ul">
<li>Security</li>
<li>URL Parsing</li>
<li>Error Handing</li>
<li>Mime Types</li>
<li>Responses</li>
</ul>

<p>
The nice part about using Go is a lot can be borrowed from the
standard libraries.
</p>

<p>
In my own deployment, there isn't a huge risk really. I guess if an
attacker was able to totally own the box that's running Gemini, it
could be a problem, but I have other controls to manage that. Even
still, I'd like to minimize the risk of buffer over flows, directory
traversal, remote code exec, remote/local file inclusion etc. By
default Go helps with memory safety and had some decent control and
libraries to help with some of the other risks. There are two main
things that I used to help: <code>net/http.Dir</code> and <code>path/filepath.Clean</code>.
</p>

<ul class="org-ul">
<li><a href="https://golang.org/pkg/net/http/#Dir">https://golang.org/pkg/net/http/#Dir</a></li>
<li><a href="https://golang.org/pkg/path/filepath/#Clean">https://golang.org/pkg/path/filepath/#Clean</a></li>
</ul>

<p>
The <code>Dir</code> type within the <code>http</code> package is almost like a chroot. It's
able to open files at a certain directory. I had never used this type
before, but I did some poking around within the go library to see how
they implement the static file server, and they used this
approach. It's a little odd that it's part of the HTTP library to be
honest, but as far as I can tell, this particular type can be used for
many purposes.
</p>

<p>
The other function I used was the <code>Clean</code> function in <code>filepath</code>. I
had never used this before either. I believe the combination of this
method along with <code>Dir</code> should help with any risk of directory
traversal. But, it's hard to say for sure. My own basic tests seem to
look okay.
</p>

<p>
Here is an example from the Go HTTP library where they use
<code>path.Clean</code>:
</p>

<div class="org-src-container">
<pre class="src src-golang">func (f *fileHandler) ServeHTTP(w ResponseWriter, r *Request) {
        upath := r.URL.Path
        if !strings.HasPrefix(upath, "/") {
                upath = "/" + upath
                r.URL.Path = upath
        }
        serveFile(w, r, f.root, path.Clean(upath), true)
}
</pre>
</div>

<p>
URL parsing for my server is handled entirely by Golang. I didn't
really have to do anything special:  <a href="https://golang.org/pkg/net/url/">https://golang.org/pkg/net/url/</a>
</p>

<p>
In terms of detecting the content type and setting a response type
header in Gemini, I ended up using another Go HTTP function: <a href="https://golang.org/pkg/net/http/#DetectContentType">DetectContentType</a>.
</p>

<p>
This approach isn't perfect, but it will work well enough for me since
I don't plan on doing anything fancy.
</p>

<p>
I think with these few basic functions, we can hack together a pretty
simple but secure (finger's crossed) server in very few lines of code.
</p>
</div>
</div>
</div>
