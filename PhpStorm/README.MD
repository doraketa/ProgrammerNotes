###Магия PHPStorm
https://my.qsoft.ru/community/blogs/dmanerov/727.php

###Trial reset Linux
```shell
#!/bin/sh

rm -rf ~/.config/JetBrains/PhpStorm2021.1/eval
rm ~/.config/JetBrains/PhpStorm2021.1/options/other.xml
# rm -rf ~/.local/share/JetBrains/consentOptions
rm -rf ~/.java/..userPrefs
```
! На линуксе не работает, надо использовать ещё и скрипт evaluation-reset.sh
instruction for lamers:

    download evaluation-reset.sh, then unzip it if needed
    open terminal and cd to evaluation-reset.sh location
    file must have rights for execute (chmod +x evaluation-reset.sh)
    run sh evaluation-reset.sh
    enjoy
Source: https://gist.github.com/tmsperera/87fe89405e5e62e60f3fe3c49e7fc3b2

###Trial reset Windows
```bat
# Remove reference to license
del "C:\Users\%USERNAME%\AppData\Roaming\JetBrains\PhpStorm2020.3\options\other.xml"

# Remove old license key
echo Y | del "C:\Users\%USERNAME%\AppData\Roaming\JetBrains\PhpStorm2020.3\eval\*.*"
```
Еще есть дополнительный файл для Windows. Лучше использовать его, то что выше просто портит лицензию.

# Trial reset больше не работает
Пробную лицензию теперь просто так не переактивировать, надо подключаться к их хосту для этого.
Выход: использовать старую версию, например: 2021.1.4 (от 30 Июня 2021)

Скачать можно тут: https://www.jetbrains.com/ru-ru/phpstorm/download/other.html

После установки надо в конфигах:
~/.config/JetBrains/IntelliJIdea2020.3/options/updates.xml

Прописать:
```xml
<application>
 <component name="UpdatesConfigurable">
   <option name="CHECK_NEEDED" value="false" />
 </component>
</application>
```
Чтобы запретить обновления.

### Фишки
Строка удаляется с зажатой клавишей `Shift`

Чтобы вызвать меню `Generate`, горячие клавиши:
```
Alt + Insert
```
Что умеет (самое нужное):
- Сгенерировать пустые шаблоны методов для реализации (если имплементируется интерфейс)
- Переопределить методы родителей (создать пустые шаблоны)
- Инициализировать конструктор
- Сгенерировать геттеры и сеттеры

Чтобы автоматически проинициализировать переменную в конструкторе, нужно встать курсором на неё и нажать
```
Alt + Enter
```
И выбрать `Initialize properties`.