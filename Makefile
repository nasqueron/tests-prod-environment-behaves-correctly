###
### Nasqueron ops tests
### We use PHPUnit to test several parts of our infrastructure.
###

ENV_FOR_TEST_FULL= \
	DOCKER_ACCESS=1 \
	DOCKER_HOST=dwellers.nasqueron.org \

test:
	phpunit --log-junit build/phpunit.xml -v .

test-full:
	sh -c "${ENV_FOR_TEST_FULL} phpunit --log-junit build/phpunit.xml -v ."
