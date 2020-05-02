web = docker-compose exec -u web web

install-prod:
	$(web) composer install --no-dev --optimize-autoloader

clear-cache:
	$(web) ./bin/console cache:c
	$(web) ./bin/console cache:w
	$(web) ./bin/console cache:pool:prune

build-assets:
	docker run --rm -it --user node -w /app -v $(shell pwd):/app node:carbon yarn install
	docker run --rm -it --user node -w /app -v $(shell pwd):/app node:carbon yarn build

docker-up:
	docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d

migrations:
	$(web) ./bin/console doctrine:migra:migra -n

deploy: docker-up install-prod migrations build-assets clear-cache
