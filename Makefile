default: help

help:
	@echo "Usage:"
	@echo "     make [command]"
	@echo "Available commands:"
	@grep '^[^#[:space:]].*:' Makefile | grep -v '^default' | grep -v '^_' | sed 's/://' | xargs -n 1 echo ' -'

coverage:
	rm -rf coverage; bin/phpunit-8.4.3.phar --coverage-html=coverage/ --coverage-clover=coverage/clover.xml

tests-unit:
	bin/phpunit-8.4.3.phar --testsuite unit

tests-integration:
	bin/phpunit-8.4.3.phar --testsuite integration

tests-infection:
	./bin/infection.phar

cs-fix:
	./bin/php-cs-fixer fix --verbose

