# PHP México

## Install using Docker

Usando docker-compose:

`docker-compose up -d`

`docker-compose exec -u web web bash`

`./bin/console doctrine:migra:migra`

Generar el build de los assets:

`docker-compose -f docker-compose.cli.yml run --rm yarn install`

`docker-compose -f docker-compose.cli.yml run --rm yarn build`

Visita http://localhost:8080
