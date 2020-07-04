lint:
	composer phpcs -- --standard=PSR12 public tests
deploy:
	git push heroku
