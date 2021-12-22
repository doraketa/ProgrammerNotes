## Symfony
Как найти нужный маршрут:
```
php bin/console debug:router blo

  Select one of the matching routes:
  [0] blog
  [1] blog_show
```

Как получить нужный сервис, если другие способы не работают:
```php
$kernel = AppKernel::getInstance();
$scheduler = $kernel->getContainer()->get(SchedulerService::class);
```