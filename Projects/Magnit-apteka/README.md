##Инструкция по развертыванию проекта:

https://www.notion.so/07f7a794604e49eabf4b01951b207be3#0448e816bb7b4f1c850c13e2429c45f0

Админка (бек)
http://172.27.2.45:8080/bitrix/admin/#authorize

Доступ по ssh:
адрес: 172.27.2.45
порт: 22
логин и пароль от гитлаба
Путь к бекенду на сервере (пример): /srv/tp2/backend

(на хосте в гитлабе отключена авторизация по паролю, нужно сгенерировать свой ключ и прокинуть в https://gitlab.qsoft.ru/

Ключ хранится в ~/
)

Пример конфига для фронта, подключенного к хосту:

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

Номер порта смотреть в папке deployer

Фронт
http://magnit.loc:8000/

Host gitlab.qsoft.ru 
```
Preferredauthentications publickey
IdentityFile ~/.ssh/
```

Прямые ссылки товаров
http://magnit.loc:8000/product/nutrof_kapsuly_1_24_06g_kartonnaya_upakovka_laboratoires_tnea
http://magnit.loc:8000/product/antigrippin_tabletki_shipuchie_greypfrut_10sht

Коммиты в гитлабе должны начинаться с номера задачи OMNI (указана в названии тикета который вы делаете)
OMNI / номер тикета / что сделал

Пример:
OMNI-1111 / 118579 / Исправление проблемы отображения

Вернуть картинки на сайт:
```
--- a/components/common/CustomImage.vue
+++ b/components/common/CustomImage.vue
@@ -66,7 +66,8 @@ export default {
     src: {
       immediate: true,
       handler(value) {
-        this.srcInner = this.createSrc(value) || this.defaultSrc;
+        const src = this.createSrc(value) || this.defaultSrc;
+        this.srcInner = `https://apteka.magnit.ru/${src}`;
       },
     },
   },
```
## Не отправляется смс
Надо закомментить строчку:
```
await this.getRecaptchaToken();
```
в файле `mixins/sendSms.js`
Хранятся в таблице adv_verification_codes (для авторизации через телефон по API)
Для мягкой регистрации хранятся в b_messageservice_message

## Запрос для тестирования бека
http://magnit.loc/api/addresses/

## Как получить юзера по любому полю
```php
use Adv\BitrixUserBundle\Repository\UserRepository;
$user = $this->userRepository->findBy((new ConditionTree())->whereMatch('UF_KIS_ID', $pharmacistId));
```

## Как узнать что релизная ветка на проде

1. Попытаться влить релизную ветку в мастер

2. Не забыть откатить мастер обратно

## Заказ со склада или из остатков аптеки

Если в регионе есть склад - товар можно добавить в корзину и заказать
- с аптеки - сегодня
- со склада - завтра по интернет цене

Если склада нет, или товар только на остатках аптек, то в этом регионе можно только
ЗАБРОНИРОВАТЬ ТОВАР

Если товар доступен и в аптеке и на складе, то его можно добавить в корзину, но вкладка "Сегодня по цене аптеки" - это забрать из остатков аптеки.
