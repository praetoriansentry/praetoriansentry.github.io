index:
	find posts -type f | sort -r | xargs -I xxx echo '<li><a href="xxx">xxx</a></li>' > index.html
