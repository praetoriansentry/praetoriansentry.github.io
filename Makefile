index:
	find . -type f -name '*.org' | sort -r | xargs -I xxx echo '<li><a href="xxx">xxx</a></li>' > index.html
