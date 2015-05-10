build: composer lint cs test

composer:
	composer install

lint:
	bin/parallel-lint src tests

cs:
	bin/phpcs --standard=vendor/consistence/coding-standard/Consistence/ruleset.xml --extensions=php --encoding=utf-8 -sp src tests

test:
	bin/phpunit -c tests/phpunit.xml tests
