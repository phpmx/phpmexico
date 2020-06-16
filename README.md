# PHP México

## Install using Docker

Usando docker-compose:

`docker-compose up -d`

![docker-compose up -d](resources/docs/img/final-composer-up-d.png)

`docker-compose exec -u web web bash`

and run composer install

![composer install](resources/docs/img/composer-install.png)

also you can run 

`./bin/console doctrine:migra:migra`

![./bin/console doctrine:migra:migra](resources/docs/img/migra.png)

after that you can exit of the container 

`exit`

install javascript dependencies 

`docker-compose -f docker-compose.cli.yml run --rm yarn install`

![yarn install](resources/docs/img/yarn-install.png)

and build 

`docker-compose -f docker-compose.cli.yml run --rm yarn build`

![yarn build](resources/docs/img/yarn-build.png)

and after that you can access to Url 

Visit http://localhost:8080


## test

access to container

`docker-compose exec -u web web bash`

and run 

`./bin/phpunit`

![phpunit](resources/docs/img/phpunit.png)