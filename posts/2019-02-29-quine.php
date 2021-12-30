<div id="content">
<h1 class="title">Bash Quine
</h1>
<p>
I wanted to see what it's like to write a <a href="https://en.wikipedia.org/wiki/Quine_(computing)">quine</a>. The challenge is
pretty simple to understand: write a program that takes no input and
can print itself.
</p>

<p>
I had heard of quines before but had never looked at one. After
looking at the Wiki page for a while I diced to try to write one on my
bus ride. I figured that writing it in Go or Javascript would probably
be a little too familiar, so I tried to write it in bash. This is what
I ended up with
</p>

<script src="https://gist.github.com/praetoriansentry/1ef5f4281183db797ef124ccc3a34feb.js"></script>

<p>
Since I don't know bash that well, I'm not even sure how much sense
this makes. Looping using <code>seq</code> feels weird. Especially since all of
the bounds of the lists are hard coded.
</p>

<p>
The hardest part of the of the bash implementation is actually all of
the escaping. Line 17 and 28 took a while to figure out. It would have
been a lot easier if I used single quotes in <code>sed</code>. But then escaping
a single quote on line 17 was very hard to figure out.
</p>

<p>
Other than that, the structure of the application pretty much looks
the same as the reference Java implementation from the Wiki page.
</p>

<p>
The way I ended up thinking about this is that the program has code
and strings. The code needs to print out strings that represent the
code itself. In terms of printing, I had to print the code that's
before the strings, then print the strings themselves as strings, then
print the code that's after the strings.
</p>

<p>
I don't know if I can explain quines better than explanations I've
found online, but at least now I think I understand it.
</p>

<p>
Just to make sure it actually works, hashing the code and hashing the
output gives the same result.
</p>

<div class="org-src-container">
<pre class="src src-text">$ shasum quine.sh
21415e04c597d28058aed0163f2e501a0bcd36ac  quine.sh
$ ./quine.sh | shasum
21415e04c597d28058aed0163f2e501a0bcd36ac  -
$ ./quine.sh | bash | bash | bash | shasum
21415e04c597d28058aed0163f2e501a0bcd36ac  -
</pre>
</div>

<p>
Another cool property of the quine is that we can keep passing the
output to bash and it's going to have the same result.
</p>
</div>
