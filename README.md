Initialize dependencies with: 

```
composer install
composer dump-autoload --optimize
```

Run tests with: 

```
php bin/phpunit --bootstrap vendor/autoload.php tests
```

Run server with: 
```
php bin/console server:run
```

By default the server should be running on `http://127.0.0.1:8000` - open your browser && enjoy.