build:
	docker build -t mysite .
run:
	docker run -d -v /Users/jhilliard/code/praetoriansentry.github.io:/var/www/html:ro -p 8000:80 mysite
deploy:
	scp -r * john@jfhlab04:/var/www/john.dev/public_html
