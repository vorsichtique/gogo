dev: down up composer

dev-full: down up-full composer

prod: down prod-up js-routes prod-assets permissions

prod-quick: down prod-up-without-build permissions

prod-up:
	docker-compose -f docker-compose.yml -f docker-compose-production.yml up -d --build
	docker-compose exec -T app composer install --no-dev --optimize-autoloader
	docker-compose exec -T app bin/console cache:clear
	docker-compose exec -T app bin/console doctrine:schema:update --force

prod-assets: yarn-install yarn-prod js-routes

prod-up-without-build:
	docker-compose -f docker-compose.yml -f docker-compose-production.yml up -d

up: docker-up permissions

up-full: docker-up-full permissions

down: docker-down

docker-up:
	docker-compose up -d

docker-up-full:
	docker-compose -f docker-compose.yml -f docker-compose-external.yml up -d

docker-down:
	docker-compose down

permissions:
	docker-compose exec -T app chown -R www-data var

logs:
	docker-compose logs -f

test:
	docker-compose run -e APP_ENV=test -e DATABASE_URL=sqlite:///%kernel.project_dir%/var/test.db app sh -c "php bin/console doctrine:schema:update --force && ./vendor/bin/simple-phpunit"

composer:
	docker-compose exec app composer install

migrate:
	docker-compose exec app php bin/console doctrine:migrations:migrate

fixtures:
	docker-compose exec -T app php bin/console doctrine:fixtures:load -n

db:
	docker-compose run app sqlite3 var/data.db

shell:
	docker-compose exec app sh

encore:
	docker-compose run node yarn run encore dev

watch:
	docker-compose run node yarn run encore dev --watch

yarn-install:
	docker-compose run node yarn install

yarn-prod:
	docker-compose run node yarn run encore production

node:
	docker-compose run node bash

travis: docker-up composer js-routes yarn-install encore test

js-routes:
	docker-compose exec -T app bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json

run-shell:
	docker run -v /Users/malu/proj/gogo:/srv/symfony -it malulu/php-7.1:latest sh