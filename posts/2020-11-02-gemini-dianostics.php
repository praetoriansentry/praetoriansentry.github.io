<div id="content">
<h1 class="title">Testing with Gemini Diagnostics
</h1>
<p>
I saw that the Gemini documentation has a client torture test. That
made me curious if there was a server torture test as well. I found a
reference to a test in the Gemini mailing list: <a href="https://lists.orbitalfox.eu/archives/gemini/2020/000296.html">Script to test gemini servers</a> &amp; <a href="https://github.com/michael-lazar/jetforce/blob/master/jetforce_diagnostics.py">jetforce_diagnostics.py</a>
</p>

<p>
I went to look at <code>jetforce_diagnostics.py</code> and of course encountered
a 404. After looking through the git history and release notes, I was
able to find that the diagnostics script was pulled into it's own
repo.
</p>

<p>
<a href="https://github.com/michael-lazar/gemini-diagnostics">https://github.com/michael-lazar/gemini-diagnostics</a>
</p>

<p>
After taking a quick look at the code I tried it out and tested my
server. The script found a lot of issues with my own server
implementation. Some of the findings seem to be false positives, but
some of the issues seem to be real discrepancies with the
implementation of Melchoir and the spec. Here are the issues that the
script pointed out
</p>

<ol class="org-ol">
<li>[TLSRequired] Non-TLS requests should be refused</li>
<li>[HomepageRedirect] A URL with no trailing slash should redirect to the canonical resource</li>
<li>[RequestMissingCR] A request without a &lt;CR&gt; should timeout</li>
<li>[URLInvalidUTF8Byte] Send a URL containing a non-UTF8 byte sequence</li>
<li>[URLAboveMaxSize] Send a 1025 byte URL, above the maximum allowed size</li>
<li>[URLWrongPort] A URL with an incorrect port number should be rejected</li>
<li>[URLWrongHost] A URL with a foreign hostname should be rejected</li>
<li>[URLSchemeHTTP] Send a URL with an HTTP scheme</li>
<li>[URLSchemeHTTPS] Send a URL with an HTTPS scheme</li>
<li>[URLSchemeGopher] Send a URL with a Gopher scheme</li>
<li>[URLEmpty] Empty URLs should not be accepted by the server</li>
<li>[URLInvalid] Random text should not be accepted by the server</li>
<li>[URLDotEscape] A URL should not be able to escape the root using dot notation</li>
</ol>

<p>
That's a lot of errors!
</p>

<div id="outline-container-orgecaf529" class="outline-2">
<h2 id="orgecaf529"><span class="section-number-2">1</span> Applying Fixes</h2>
<div class="outline-text-2" id="text-1">
<p>
<a href="https://github.com/praetoriansentry/melchior/commit/96ea45a30b59b0833cb81461d6f3e1c618167c3b">Patches</a>
</p>

<p>
Fixing the errors here was pretty easy. My basic server was very
easygoing when it came to the format of the requests. The only thing I
was really doing was making sure directory traversal was not
possible. My error codes weren't quite right and I wasn't enforcing
checks on the hostname, port numbers, and scheme.
</p>

<p>
The expected behavior when a request doesn't end with <code>\r\n</code> was a
little surprising.. I.e. I didn't expect that you should get a timeout
/ empty response If the request didn't end with <code>\r\n</code>. I guess it
kind of makes sense. Perhaps in the early phases of the protocol it's
better to be a bit strict.
</p>
</div>
</div>
</div>
