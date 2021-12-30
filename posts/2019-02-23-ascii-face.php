<div id="content">
<h1 class="title">Video to ASCII Art
</h1>
<p>
For whatever reason, I'm fascinated with <a href="https://en.wikipedia.org/wiki/ASCII_art">ASCII Art</a>. I guess it's
because it reminds me of old school computing and hacking.
</p>

<p>
I was curious today if I could create animated ASCII Art from a
video. It turned out to be pretty easy.
</p>

<p>
<b>Step 1</b>: I took a very short and simple video of myself on my
phone. I took a video selfie and emailed that to myself.
</p>

<p>
<b>Step 2</b>: I used Adobe Premier, to convert the <code>.MOV</code> file from my phone
into a series of <code>.jpg</code> files. Each frame of the video is being
converted to a still frame.
</p>

<p>
<b>Step 3</b>: Each frame of the video is converted from a <code>.jpg</code> file to
an ASCII art <code>.txt</code> file. I used an awesome tool called <a href="https://csl.name/jp2a/">jp2a</a> to do the
conversion. This is the actual command I used to do the conversion.
</p>

<div class="org-src-container">
<pre class="src src-bash">find . -type f | sort | xargs -I xxx jp2a --width=200 xxx --output=xxx.txt
</pre>
</div>

<p>
<b>Step 4</b>: I then used <code>cat</code> to concatenate all of the text files and
 separate them with <code>pre</code> tags. At this point, I have a very simple
 html document with every frame of the animation inside of it.
</p>

<p>
<b>Step 5</b>: The last step here was to animate the frames.
</p>

<script src="https://gist.github.com/praetoriansentry/297152a91354aded5cd0f81ea512a821.js"></script>

<p>
The basic approach was to hide all but one of the <code>pre</code> tags. Then
there is a timer that's running regularly to change which <code>pre</code> tag is
showing.
</p>

<p>
You can see the final html document <a href="./ascii-face.html">./ascii-face.html</a>.
</p>

<p>
<b>Step 6</b>: The last step here was to create a real gif. Since I don't
 know how to convert animated plain text into a gif, I just took a screen
 capture and rendered it as a gif. This is finale result:
</p>


<div id="orgfee8013" class="figure">
<p><img class="img-fluid" src="../img/face.gif" alt="face.gif">
</p>
<p><span class="figure-number">Figure 1: </span>The final gif</p>
</div>
</div>
