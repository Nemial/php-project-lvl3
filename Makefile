lint:
	composer phpcs -- --standard=PSR12 tests
deploy:
	git push heroku
