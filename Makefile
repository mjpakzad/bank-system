APP_CONTAINER=bank-app
APP_SERVICE=app
COMPOSE=docker-compose

.PHONY: up down build rebuild setup test artisan composer logs

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

build:
	$(COMPOSE) build

rebuild:
	$(COMPOSE) up -d --build

setup:
	cp .env.example .env
	$(COMPOSE) up -d
	$(COMPOSE) exec $(APP_SERVICE) composer intall
	$(COMPOSE) exec $(APP_SERVICE) php artisan key:generate
	$(COMPOSE) exec $(APP_SERVICE) php artisan migrate --seed

test:
	$(COMPOSE) exec $(APP_SERVICE) php artisan test

artisan:
	$(COMPOSE) exec $(APP_SERVICE) php artisan $(filter-out $@,$(MAKECMDGOALS))

composer:
	$(COMPOSE) exec $(APP_SERVICE) composer $(filter-out $@,$(MAKECMDGOALS))

logs:
	$(COMPOSE) logs -f

%:
	@:
