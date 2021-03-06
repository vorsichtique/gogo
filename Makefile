#! make

-include .env
export
include Makefile.app
include Makefile.dev
include Makefile.prod

init:
	/bin/bash build/bin/init.sh

run: dev

up: docker-up permissions

up-embedded: docker-up-embedded permissions

down: docker-down

docker-up:
	docker-compose -f docker-compose.yml -f build/docker/docker-compose-standalone.yml -f build/docker/docker-compose-db.yml up -d --build

docker-up-embedded:
	docker-compose -f docker-compose.yml -f build/docker/docker-compose-embedded.yml up -d

docker-down:
	docker-compose down --remove-orphans

permissions:
	docker-compose exec -T app chown -R www-data var

logs:
	docker-compose logs -f

test:
	docker-compose run -e APP_ENV=test -e DATABASE_URL=sqlite:///%kernel.project_dir%/var/test.db app sh -c "php bin/console doctrine:schema:update --force && ./vendor/bin/simple-phpunit"