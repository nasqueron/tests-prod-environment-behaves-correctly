###
### Nasqueron ops tests
### We use PHPUnit to test several parts of our infrastructure.
###

PHPUNIT=vendor/bin/phpunit

ENV_FOR_TEST_FULL= \
	DOCKER_ACCESS=1 \
	DOCKER_HOST=equatower.nasqueron.org \

all: test

vendor:
	composer install

test: vendor
	${PHPUNIT} --log-junit build/phpunit.xml -v

test-full: vendor
	sh -c "${ENV_FOR_TEST_FULL} ${PHPUNIT} --log-junit build/phpunit.xml -v"
