## Всякие понты
Оказывается вот это, называется `fluent-интерфейс`:
```php
$orderCreationDto = (new OrderCreationDto())
    ->setPartnerOrderId($header['orderId'])
    ->setPharmacyCode($pharmacyCode)
    ->setName($header['name'])
    ->setPhone(str_replace(['(', ')','-'], '', $header['mPhone']))
    ->setComment($statusesArray[$header['orderId']]['cmnt'] ?? '')
    ->setBasket($basketItems[$header['orderId']]);
```

# Как лучше всего проверять идентичность файлов
```php
if (
    file_exists($fullPath) &&
    filesize($tmpPath) === filesize($fullPath) &&
    hash_file('crc32', $tmpPath) === hash_file('crc32', $fullPath)
) {
    unlink($tmpPath);
    return;
}
```