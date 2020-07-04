lint:
	composer phpcs -- --standard=PSR12 tests
lint-fix:
	composer phpcbf
deploy:
	git push heroku
log:
	tail -f storage/logs/laravel.log
start:
	php artisan serve --host 0.0.0.0
