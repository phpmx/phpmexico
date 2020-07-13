# PHP México
![php73-badge]
> PHP México Community website

![](resources/docs/img/phpmexico.mx.png)

## Development setup

Windows, OS X & Linux:


## Requirements:

You need to have Docker and Docker-compose installed on your machine.

## Run project

For run docker and enter into the container typing in a terminal the following commands.

```sh
docker-compose up -d
docker-compose exec -u web web bash
```

To install the necessary dependencies of the project, both for php
and javascript, inside the container execute the following commands.

```bash
composer install -o
yarn install
```

If is your first time running this project, you must type the
following commands to migrate to database, remember to run this
command every time to added changes to database.

```bash
bin/console doctrine:migra:migra
```

For build assets, you only need run the following command, remember
run this command every time when you add changes to styles files or
javascript files.

```sh
yarn install
yarn build
```

To see the portal of phpmx, write the address `http://localhost:8080/` 
in your browser.
 
## Contributing

### Open [issues](https://github.com/phpmx/phpmexico/issues) & [projects](https://github.com/phpmx/phpmexico/projects/)

1. Fork it (<https://github.com/phpmx/phpmexico/fork>)
2. Create your feature branch (`git checkout -b feature/fooBar`)
3. Run php-cs-fixer (`composer lint`)
4. Run tests (`./bin/phpunit`)
4. Commit your changes (`git commit -am 'Add some fooBar'`)
5. Push to the branch (`git push origin feature/fooBar`)
6. Create a new Pull Request

## Meta

PHP México – [@phpmx](https://twitter.com/phpmx) – [slack://phpmx](https://phpmx.slack.com)

<!-- Markdown link & img dfn's -->
[php73-badge]: https://img.shields.io/badge/PHP_Version-7.3-darkgreen.svg
