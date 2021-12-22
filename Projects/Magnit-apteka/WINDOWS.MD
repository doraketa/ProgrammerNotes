## Развертывание на Windows

Для развёртывания на Windows нужно развертывать только front-end.

Ставим git отсюда: https://git-scm.com/download/win

Сгенерировать ssh ключ

```bash
cd ~/.ssh
ssh-keygen -t rsa -b 2048 -C "email@qsoft.ru"
```

более надежный ключ:

```
ssh-keygen -t rsa -b 4096 -C "email@qsoft.ru"
```

Клонируем фронтенд:

```bash
git clone git@gitlab.qsoft.ru:magnit-apteka/frontend.git
```

Переименовать .env.example в .env

Заменить конфиг на этот:

```
DEV_LOGIN = "admin"
DEV_PASSWORD = "123456"
API_SERVER_URL = "http://172.27.2.45:8081"
MAIN_TITLE = "Магнит-Аптека"
MAIN_DESCRIPTION = "Описание интернет-магазина Магнит-Аптека"
RECAPTCHA_API_KEY="test"
MODE_ENV = "dev"
BASE_URL_BROWSER="http://172.27.2.45"
QSOFT_ENVIRONMENT="true"
MINDBOX="false"
```
(Порт заменить на свой)

Ставим node.js отсюда: https://nodejs.org/en/download/

Ставим зависимости:

```bash
yarn install
```

При возникновении ошибок:

Нужен NET\Framework\v4.0, скачать отсюда:

https://www.microsoft.com/ru-ru/download/details.aspx?id=17851
  
Также нужно это (с правами администратора):

```bash
npm install --global --production windows-build-tools
npm config set msvs_version 2012 --global
```

При ошибке node-sass: Command failed (если ругается на версию node-sass):

```bash
yarn add node-sass
yarn add node-sass@4.14.1
```

Возможно так же понадобится питон 2:

https://www.python.org/downloads/release/python-2710/

После того, как побороли все ошибки установки, запускаем:

```bash
yarn dev
```