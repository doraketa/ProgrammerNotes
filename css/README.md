## Заметки по стилям
Быстрое центрирование через flexbox:
```html
<div class="flex-container">
<div class="flex-item">hello hello hello hello </div>
</div>
```
```css
.flex-container {
display: flex;    
justify-content:center;
align-items:center;
width: 300px;
height: 300px;
background-color: lightgrey;
text-align:center;
}

.flex-item {
background-color: cornflowerblue;
width: 100px;
height: 100px;
display:flex;  //<---- added property supposed to be work on parent
justify-content:center; //<---- added property supposed to be work on parent
flex-direction:column;  //<---- added property supposed to be work on parent
```