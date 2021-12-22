## Javascript
Как проитерировать объект и вернуть значение:
```javascript
const prefixes = {
    indexPage: ['index'],
    catalogPage: ['catalog-category'],
    catalogListPage: [
        'catalog-category-subcategory',
        'search',
        'catalog-category-subcategory-code',
    ],
};
getEventPrefix() {
    function getPrefix(acc, cur) { // acc - аккумулирующий объект, cur - текущий элемент
        if (cur[1].includes(this.$route.name)) {
            [getPrefix.result] = cur; // или getPrefix.result = cur[0]; <- статическая переменная
        }
        // если на какой-то итерации переменная undefined, то она не будет возвращена 
        return getPrefix.result;
    }
    // прибиндим свой контекст
    const getPrefixBounded = getPrefix.bind(this);

    // пустой объект нужен чтобы проитерировать все элементы
    // если не указать, 0-й элемент будет пропущен
    return Object.entries(prefixes).reduce(getPrefixBounded, {});
},
```
Если надо вернуть итоговое значение, обязательно используем reduce.

Отфильтровать содержимое объекта:
```javascript
let romNumbers={'I':1,'V':5,'X':10,'L':50,'C':100,'D':500,'M':1000}

// You can filter romNumbers object by key:

const filteredByKey = Object.fromEntries(
    Object.entries(romNumbers).filter(([key, value]) => key === 'I') )
// filteredByKey = {I: 1} 

// Or filter romNumbers object by value:

 const filteredByValue = Object.fromEntries(
    Object.entries(romNumbers).filter(([key, value]) => value === 5) )
 // filteredByValue = {V: 5}
```
## Как обращаться с аккумулятором
```javascript
const hints = [
	{
  	id: 10090,
    name: 'Yota marketing',
  	category: {
    	code: 'marketing',
      name: 'Маркетинг',
    },
  },
  {
  	id: 4106,
    name: 'Заявка тестовая',
  	category: {
    	code: 'market',
      name: 'Маркет',
    },
  },
];

let test = hints.reduce(function(acc, cur){
  acc[cur.id] = cur.name; // аккумулятор заполняем на каждой итерации из текущего значения
  return acc; // возвращаем заполненный аккумулятор
}, {}); // начальное значение - пустой объект, далее его зполняем

console.log(test);
```

Вернет:
```
{
  10090: "Yota marketing",
  4106: "Заявка тестовая"
}
```

## Как обратиться к свойству через переменную
```javascript
var myObj = new Object;
var a = 'string1';
myObj[a] = 'whatever';
alert(myObj.string1)

// (alerts "whatever")
```

## Как посчитать количество элементов в объекте
```javascript
var entity = {id: {id: 1}, info: {type: 'string'}};
var len = Object.keys(entity).length
console.log(len)
```
выведет 2

## Поиск индекса по массиву

```javascript
const foundedEntityIndex = [].findIndex(
    ent => ent.link_query[codePropertyName] === cur[entityName].code
);
console.log(foundedEntityIndex);
```
выведет -1

Может не сработать, потому что `findIndex is not a prototype method of Array in ECMASCRIPT 262`, тогда надо так:
```javascript
var f;
var data = [1,2,3];
var removeId = 3;
var filteredElements = data.some(
    function(item, index){
        f = index;
        return item.id == removeId;
    });

console.log(f); // индекс у искомого элемента = 2
console.log(data.splice(f, 1)); // сам искомый элемент [3]
```