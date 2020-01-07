#!make

.PHONY: init api update configure up
.DEFAULT_GOAL := init

init: up api

configure:
	@echo "========================= Configure =================================="
	cp docker-compose.template.yml docker-compose.yml

api:
	@echo "========================= Setup Working API =================================="
	docker-compose run --rm composer install

update:
	docker-compose pull
	docker-compose up -d --build --remove-orphans

up:
	docker-compose up -d --build --remove-orphans
