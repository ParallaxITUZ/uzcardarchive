.DEFAULT_GOAL := app
.PHONY: app postgres nginx rebuild ps recreate

app: docker-compose.yml
	@docker-compose exec app bash
nginx: docker-compose.yml
	@docker-compose exec nginx bash
postgres: docker-compose.yml
	@docker-compose exec postgres bash
rebuild: docker-compose.yml
	@docker-compose up --force-recreate --build --remove-orphans -d
recreate: docker-compose.yml
	@docker-compose up --force-recreate --remove-orphans -d
ps: docker-compose.yml
	@docker-compose ps
