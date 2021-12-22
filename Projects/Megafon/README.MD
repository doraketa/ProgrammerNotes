## При создании нового класса
composer dump-autoload

## Консоль Laravel
php artisan

## Просмотр логов докера
docker logs megafon-dev.web-application -f

## Проверить гит статус на всех микросервисах
make git-status

##Чтобы переключиться во всех микросервисах на release, выполните
make git-release

##Чтобы запулить релиз во всех микросах
А так же обновить все контейнеры, поправить везде права и установить композер выполните (ваша самая любимая команда до конца проекта, делайте каждый день по несколько раз)

make all-release

(нельзя делать, если на каком-то микросе не release)

## После переключения на ветку
git pull
composer i

##Чистить кеш этой командой
(а не той, что в описании деплоера)

make cache-clear

## Пользак в системе
new.test:qwerty78

## SonarCube
http://sonarqube.vpool/projects?sort=-analysis_date
(логин и пароль от Гита)