# Contact manager

Awesome mega smoothie unicorn application for contact management!

## Installation

You need to have free 8080, 3306 ports in the system
and installed docker with docker-compose, then just run:

```bash
$ make up
$ make install
```

Or alternatively if you for some reason do not have
make installed in the system just use these commands:

```bash
$ docker compose up -d
$ docker compose exec -it php sh
$ cp .env .env.local
$ composer install
$ php bin/console doctrine:migrations:migrate
```

Now navigate to http://localhost:8080/

## Testing

For run all app tests just type:

```bash
$ docker compose exec -it php sh
$ php bin/phpunit
```
