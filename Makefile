lint:
	composer phpcs -- --standard=PSR12 tests routes
lint-fix:
	composer phpcbf
deploy:
	git push heroku
log:
	tail -f storage/logs/laravel.log
start:
	php artisan serve --host localhost
# test-coverage:
# 	composer phpunit -- tests --whitelist tests --coverage-clover coverage-report
