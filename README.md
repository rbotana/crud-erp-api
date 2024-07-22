Crud developed in Laravel under the TDD concept.



Containers up
```sh
docker-compose up -d
```


Create .env file
```sh
cp .env.example .env
```

Access container
```sh
docker-compose exec app bash
```


Install dependencies
```sh
composer install
```

Key generated
```sh
php artisan key:generate
```


Migrations
```sh
php artisan migrate
```

Access the project
[http://localhost:8000](http://localhost:8000)
