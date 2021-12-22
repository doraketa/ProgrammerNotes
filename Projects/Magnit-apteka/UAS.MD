## Авторизационный токен при запросах из УАС

Я создал Юзера:

UASVorozhko:123456

! Юзер должен быть в группе `УАС-интеграция`

В постмане Basic Auth (далее ввести Username, Password)

Пример адреса (передача статусов (Смена состояния заказа) от УАС к нам):
```
http://magnit.loc/api/uas/orders/update-status
```
Пример тела запроса:
```json
{
    "Status": 3,
    "TypeOrder": 1, 
    "Number": "1452051",
    "Rows": [
        {
            "Product": {
                "Code": "1000335305"
             },
            "Quantity": 0,
	        "Reserved": 0,
            "Price": 315.00,
            "Sum": 315.00
        }
    ]
}
```
