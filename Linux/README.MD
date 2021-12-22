# Заметки по Linux
Проверить кто слушает 80 порт
```
sudo netstat -ltnp | grep -w ':80'
```
Убить процесс
```
kill -9 934
```
## Работа с юзерами
Как узнать ID текущего пользователя
```
$UID
```
Можно так использовать:
```
sudo chown -R $UID:$GID .
```
## Украшательства
Чтобы всегда показывалась ветка, нужно добавить в `.bashrc`:
```
function parse_git_branch {
    git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'
}

function proml {
    local        BLUE="\[\033[0;34m\]"
    local         RED="\[\033[0;31m\]"
    local      YELLOW="\[\033[0;33m\]"
    local   LIGHT_RED="\[\033[1;31m\]"
    local       GREEN="\[\033[0;32m\]"
    local LIGHT_GREEN="\[\033[1;32m\]"
    local  LIGHT_GRAY="\[\033[0;37m\]"
    case $TERM in
        xterm*)
        TITLEBAR='\[\033]0;\u@\h:\w\007\]'
        ;;
        *)
        TITLEBAR=""
        ;;
    esac

PS1="$PS1$YELLOW\$(parse_git_branch)$LIGHT_GRAY"
PS2='> '
PS4='+ '
}

proml
```
Как сделать чтобы zsh запускалось всегда:

В файле `~/.bashrc` в самом начале вставить `exec zsh`
## Траблшутинг
Если не удается войти в систему после ввода правильного пароля (login loop), то пробуем войти через консоль, чтобы её открыть:
```
ctrl + alt + F2
```
Далее пробуем авторизоваться, если успешно, то нужно установить другой менеджер загрузки:
```
sudo apt --purge --reinstall install unity lightdm
```

## Поиск по файлам
```
find . -name "*.*" -exec grep -o "font-size" '{}' \; | wc -l
```
Ищем сколько раз фраза `font-size` встречается в любых файлах (`*.*`) директории

Вместо `*.*` можно указать тип файлов, например `*.vue`

## Изменить файл подкачки
Посмотреть текущий
```
swapon --show
```
Отключить
```
sudo swapoff /dev/dm-1
```
Создать новый
```
sudo mkswap /swap
```
Задать размер нового swap
```
sudo fallocate -l 6G /swap
```
Включить новый раздел
```
sudo swapon /swap
```
При таком способе swap слетает после перезагрузки
Чтобы не слетало:
```
sudo nano /etc/fstab
```
Добавить строку:
```
/swap   swap    swap    sw  0   0
```
Запустить команды:
```
sudo sysctl vm.swappiness=10

sudo nano /etc/sysctl.conf
```
Добавить строки:
```
vm.swappiness = 10
vm.vfs_cache_pressure = 50
```

## Symlink
Создать мягкую ссылку на папку:

```
ln -s /path/to/source /path/to/link
```

Как удалить симлинк на папку:

```
rm -f symlink_to_dir
```

Самое главное не использовать ключ -r (это удалит данные)