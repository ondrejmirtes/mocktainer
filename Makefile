build: composer check

composer:
	composer install

lint:
	bin/parallel-lint src tests

cs:
	bin/phpcs --standard=ruleset.xml --extensions=php --tab-width=4 --encoding=utf-8 -sp src tests

test:
	bin/phpunit -c tests/phpunit.xml tests

phpstan:
	bin/phpstan analyse -l 7 src tests

check: lint cs test phpstan
