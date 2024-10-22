run: build up composer-install cache-clear seed
test: phpcs lint phpspec unit-tests integration-tests phpstan-run

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

bash:
	docker exec -it creativestyle /bin/bash

nginx:
	docker exec -it nginx /bin/bash

composer-install:
	docker exec -it creativestyle composer install

sleep:
	sleep 5

seed:
	docker exec -it creativestyle bin/console doctrine:database:drop --force
	docker exec -it creativestyle bin/console doctrine:database:create
	docker exec -it creativestyle bin/console doctrine:migrations:migrate --no-interaction
	docker exec -it creativestyle bin/console support:fixture:product
	docker exec -it creativestyle bin/console doctrine:database:create --env=test --no-interaction
	docker exec -it creativestyle bin/console doctrine:migrations:migrate --env=test --no-interaction

cache-clear:
	docker exec -it creativestyle bin/console cache:clear

consume-async:
	docker exec -it creativestyle bin/console messenger:consume async -vv

phpcs:
	docker exec -it creativestyle vendor/bin/phpcs

lint:
	docker exec -it creativestyle bin/console lint:yaml config --parse-tags

phpspec:
	docker exec -it creativestyle vendor/bin/phpspec run --format=pretty

unit-tests:
	docker exec -it creativestyle ./bin/phpunit -c phpunit.xml --testdox --testsuite unit

integration-tests:
	docker exec -it creativestyle ./bin/phpunit -c phpunit.xml --testdox --testsuite integration

phpstan-run:
	docker exec -it creativestyle vendor/bin/phpstan analyse -c phpstan.neon