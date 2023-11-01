HOST_GROUP_ID = $(shell id -g)
HOST_USER = ${USER}
HOST_UID = $(shell id -u)

export HOST_UID
export HOST_USER
export HOST_GROUP_ID

DOCKER_COMPOSE_DEV = docker-compose

install:
	$(DOCKER_COMPOSE_DEV) build
	$(MAKE) composer-install
	$(MAKE) composer-update

composer-install:
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php -d memory_limit=4G bin/composer install'

composer-update:
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php -d memory_limit=4G bin/composer update -W'

start:
	$(DOCKER_COMPOSE_DEV) up -d

stop:
	$(DOCKER_COMPOSE_DEV) down

connect:
	$(DOCKER_COMPOSE_DEV) exec php bash

clear:
	php ./bin/console cache:clear

run-test:
	php ./bin/phpunit
