## Заметки по elasticsearch

Плагин для Storm: `Cap ElasticSearch`

Чтение:

Для поиска документа:

http://172.27.2.45:9200/catalog_dev/_search

Тело запроса:

```json
{
    "size": 100,
    "query": {
        "terms": {
            "id": [
                81635
            ]
        }
    }
}
```

Пример с 'и':

```json
{
  "from": 0,
  "size": 10,
  "query": {
    "bool": {
      "must": [
        {
          "match": {
            "price.article": "1000335305"
          }
        },
        {
          "match": {
            "price.quantity": 187
          }
        }
      ]
    }
  }
}
```