## Особенности vue.js
Добавить класс к тегу body правильно так:
```vue
<script>
export default {
  head: {
    bodyAttrs: {
      class: 'home-page home page page-id-4 page-template page-template-template-homepage page-template-template-homepage-php'
    }
  }
}
</script>
```
Прокидываем значения из родитекльского в дочерний:
```vue
<script>
// родительский компонент предоставляет доступ к 'foo'
var Provider = {
  provide: {
    foo: 'bar'
  },
  // ...
}

// дочерний компонент внедряет 'foo'
var Child = {
  inject: ['foo'],
  created () {
    console.log(this.foo) // => "bar"
  }
  // ...
}
```
Это все сделано НЕ реактивным, значит computed свойства надо прокидывать по-особенному:
```vue
<script>
export default {
  // ...
  provide() {
    const newThis = this;

    return {
      get category() {
        return newThis.category;
      },
    };
  },
```
При получении данных можно указать значение по-умолчанию (на случай, если ничего не прилетит и будет варнинг):
```vue
<script>
export default {
  // ...
  inject: {
    category: {
      default: undefined,
    },
  },
```
Intersection Observer для Vue.js

Его лучше реализовывать через кастомную директиву
```php
import { visibleEvent } from '@/helpers/yandexEvents';

export default {
  // используем хук жизненного цикла
  inserted: (el, bindings) => {
    if (
      bindings.value.data.params === undefined ||
      bindings.value.stop === true
    ) {
      return false;
    }
    // когда элемент виден делаем нужное нам действие
    function onElementIsVisible() {
      visibleEvent({ el, bindings });
    }
    // проверяем видимость элементов
    function handleIntersect(entries, observer) {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          onElementIsVisible();
          observer.unobserve(el);
        }
      });
    }
    // создаем наблюдатель
    function createObserver() {
      // настройки 
      const options = {
        root: null,
        threshold: bindings.value.data.params.threshold
          ? bindings.value.data.params.threshold
          : 0, // некоторые можно взять из самой директивы
      };
      const observer = new IntersectionObserver(handleIntersect, options);
      observer.observe(el);
    }
    // Проверяем поддерживается ли технология вообще
    if (window.IntersectionObserver) {
      createObserver();
    } else {
      onElementIsVisible();
    }
  },
};
```
Через плагины можно сделать кастомную директиву глобальной
```php
import YandexDirective from '~/directives/yandex';

Vue.directive('yandex', YandexDirective);
```
Сама директива будет выглядит так:
```html
<div
  v-yandex="{
    event: eventPrefix + '_mediaСarousel_visible',
    data: getDataForYandex({
      context: '',
      block: 'mediaCarousel',
      inner_block: '',
      element: '',
      event: 'visible',
      needed: ['user_id', 'is_auth', 'page'],
      threshold: 0.1,
    }),
  }"
  class="main-carousel"
>
```