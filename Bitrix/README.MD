## Миграции Bitrix

Создать миграцию можно так:
```
php -d memory_limit=2G bin/migrate create --name=<название>
```
Накатить:
```
php -d memory_limit=2G bin/migrate up --search=<название>
```
Откатить:
```
php -d memory_limit=2G bin/migrate down --search=<название>
```
Миграции хранятся в app/migrations

Главный инструмент получить можно так
```php
$this->getHelperManager()->Hlblock();
```
В миграциях можно использовать API Битрикса.

Вывести сообщение в миграции можно так:
```php
$this->outInfo('Сообщение');
```
Сообщение об ошибке:
```php
$this->outError('Не найден HL-блок ' . Hlblock::CODE_SMS_DELAYED);
```

## Как справляться с ошибками
Как проверить работает ли бек (если на фронте 404 ашибка):
```
http://magnit.loc/api/catalog/sort
```
Если на беке ошибка 500 и неизвестно почему, чистим кеш:
```
php bin/console b:c:c
```
## Работа с бд
Прямые запросы лучше не делать.
Можно так (пример получения информации о загруженном файле из таблицы `b_file`):
```php
$fileInfo = \Bitrix\Main\FileTable::getRow([
    'select' => ['ID', 'TIMESTAMP_X'],
    'filter' => ['=DESCRIPTION' => $description],
    'order' => ['ID' => 'desc'],
    'limit' => 1
]);
```
! Важно: равно в фильтре нужно чтобы запрос не понимал его как LIKE (если в значении строка).

Возможные ключи:
```
select - массив фильтров в части SELECT запроса, алиасы возможны в виде: "alias"=>"field".
filter - массив фильтров в части WHERE запроса в виде: "(condition)field"=>"value".
group - массив полей в части GROUP BY запроса.
order - массив полей в части ORDER BY запроса в виде: "field"=>"asc|desc".
limit - целое число, указывающее максимальное число строк в выборке (Подобно LIMIT n в MySql)
offset - целое число, указывающее номер первой строки в результате. (Подобно LIMIT n, 100 в MySql)
runtime - массив полей сущности, создающихся динамически.
```
## JOIN'ы в Битриксе
```php

use Adv\CatalogBundle\Table\StoresTable;
use Adv\CatalogBundle\Table\StoresLockingTable;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Iblock\ElementTable;

public function getStoresLockingData()
    {
        Application::getConnection()->startTracker();
        $result = StoresLockingTable::getList([
            'select' => [
                'ID', 'UF_STORE_ID',
                'UF_ELEMENT_ID',
                'STORE_NAME' => 'STORE.UF_NAME',
                'STORE_XML_ID' => 'STORE.UF_XML_ID',
                'PRODUCT_NAME' => 'PRODUCT.NAME'
            ],
            'runtime' => [
                new ReferenceField(
                    'STORE', // ЭТО АЛИАС
                    'Adv\CatalogBundle\Table\StoresTable',
                    [
                        '=this.UF_STORE_ID' => 'ref.ID',
                    ] // UF_STORE_ID - из текущей таблицы, ref.ID - из присоединяемой
                ),
                new ReferenceField(
                    'PRODUCT', // ЭТО АЛИАС
                    ElementTable::getEntity(),
                    [
                        '=this.UF_ELEMENT_ID' => 'ref.ID',
                    ]
                )
            ]
        ]);

        // Можно смотреть сформированный запрос
        echo '<pre>', $result->getTrackerQuery()->getSql(), '</pre>';

        while ($row = $result->fetch()) {
            echo '<pre>';print_r($row);echo '</pre>';
        }

        return 'DONE!';
    }
```
## Фильтрация
Чтобы найти все сущности с заполненным свойством, используем
```
$filter = array("PERSONAL_CITY" => " _% ");
```
C незаполненным:
```
$filter = array("PERSONAL_CITY" => " ~_% ");
```
## Как получить hl-блок по имени
```php
$hlblock = Highloadblock\HighloadBlockTable::getList([
    'filter' => ['=NAME' => $code]
])->fetch();
if(!$hlblock){
    throw new \Exception('[04072017.1331.1]');
}

$hlClassName = (Highloadblock\HighloadBlockTable::compileEntity($hlblock))->getDataClass();

$hlClassName::add(...) // если нужно что-то добавить
```
## Как поймать шаблон отправляемого письма
Чтобы записывать в файл отправляемое письмо, надо в файле

`common/bitrix/modules/main/lib/mail/event.php`

Внутри метода handleEvent()
прописать
```php
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/mailsend.html', $message->getMailBody());
```
html будет сохраняться в файл mailsend.html

Чтобы отправить тестовое письмо, надо в админке пройти `Настройки/Инструменты/Командная PHP-строка`
и выполнить
```php
$result = Bitrix\Main\Mail\Event::sendImmediate([
'EVENT_NAME' => 'SALE_NEW_ORDER',// имя шаблона
'LID'        => 's1',
'C_FIELDS'   => ['EMAIL' => 'test@test.com',// любая почта
'ORDER_REAL_ID' => 46637],// номер существующего заказа
]);
```

## Как отправить смс

Чтобы отправить тестовое смс, надо в админке пройти `Настройки/Инструменты/Командная PHP-строка`
и выполнить
```php
$fields = [
    'PHONE' => '+79990000000',
];

$sms = new \Bitrix\Main\Sms\Event('SMS_ORDER_ADD', $fields);
$sms->setSite('s1');
$sms->setLanguage('ru');
$sms->send();
```

Поймать смс можно в файле `common/bitrix/modules/main/lib/sms/event.php`:

после этого
```php
$smsMessage = \Bitrix\MessageService\Sender\SmsManager::createMessage([
    'SENDER_ID' => $senderId,
    'MESSAGE_FROM' => $message->getSender(),
    'MESSAGE_TO' => $message->getReceiver(),
    'MESSAGE_BODY' => $message->getText(),
]);
```
Надо прописать так:
```php
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/sms.txt', print_r($message->getText(), true));
```

## Как протестировать смс

```
php bin/console sms:delayed:send
```

## Как отфильтровать с помощью inner join
Есть 2 таблицы:

stores

hl_stores_formats_uf_site_list

Нужно взять 1 строку из hl_stores_formats_uf_site_list в которой value = 14 и по этому значению отфильтровать таблицу stores по полю UF_STORE_FORMAT.

Делается так:
```php
$query = StoresTable::query()
    ->setSelect(['UF_XML_ID'])
    ->addFilter('=UF_ACTIVE', 1)
    ->setOrder(['UF_XML_ID'])
    ->setLimit(1000)
    ->registerRuntimeField(
        'STORE_FORMAT',
        [
            'data_type' => StoresFormatsSiteListTable::class,
            'reference' => [
                '=this.UF_STORE_FORMAT' => 'ref.ID',
                '=ref.VALUE' => new SqlExpression('?i', $stores[Site::MAIN]),
            ],
            'join_type' => 'inner',
        ]
    );
```

'?i' означает тайпкастинг к числу второго параметра

Смысл в том, что мы присоединяем к таблице store таблицу hl_stores_formats_uf_site_list и связываем поля:

UF_STORE_FORMAT из store и ID из hl_stores_formats_uf_site_list

и говорим, что нас интересует только значение 14 (хранится в переменной $stores[Site::MAIN])

inner join при этом возьмет только полученные совпадения, остальное отбросит (фильтр)

Таким образом мы отфильтровали таблицу store по полю UF_STORE_FORMAT по значению, взятому из другой таблицы (ID, для которого value = 14 в таблице hl_stores_formats_uf_site_list)

! Сам запрос можно посмотреть:
```php
$query->getQuery()
```