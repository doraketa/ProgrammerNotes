# Заметки по докеру
## Юзер в контейнере
Чтобы в контейнере был гарантированно текущий юзер (из-под которого работаем в Linux), можно в `docker-compose.yml` указать
```yaml
version: '3'
services:
    app:
        image: ...
        user: ${UID:-0}
```
При этом в `.env` нужно прописать получение ID текущего пользователя Linux:
```
UID=${UID}
```
Чтобы зайти в контейнер под этим юзером нужно:
```
docker exec -it -u root:root container /bin/bash
```
Но при этом:
```
$ whoami
whoami: cannot find name for user ID 1001
```
Смотреть логи:
```
docker logs -f имя_контейнера
```
