<h1>Знакомство с приложением "Мероприятия и участники"</h1>
<h3>Общее описание функциональности</h3>
<p>Это небольшое API приложение, с помощью которого можно добавить, отредактировать, удалить или просмотреть список участников мероприятий.
</p>
<h3>Работа API</h3>

<p> Api реализовано на фреймворке Yii2 с использованием базы данных.
</p>
    <h3>Состав базы данных</h3>
    <p>База данных состоит из трех таблиц:</p>
    <ul>
 <li>1) events</li>
 <li>2) members</li>
 <li>3) token</li>
 </ul>
    <p>Таблица events содержит список мероприятий</p>
    <p>Таблица members содержит список участников с уникальным email</p>
    <p>Таблица token содержит уникальный ключ-доступ к Api</p>
<p> Обратиться к Api можно по адресу http://444gaid.ru/web/api?token=4567890
    В случае, если указан другой токен, то Api работать не будет.
    Api на входе принимает список GET параметров со значениями и на выходе отдает результат в формате JSON.
    Лучше всего использовать для работы с API браузер Firefox</p>
    <h3>Методы Api</h3>
    <strong>token</strong>
    <p>Метод принимает значение из таблицы MySQL, так осуществляется защита от стороннего использования API.</p>
    <strong>operation</strong>
    <p>Метод принимает одно из значений, в зависимости от операции: add, update, delete, filter.</p>
    <p>Операция add позволяет добавить участника мероприятия.</p>
    <p>Операция update позволяет обновить данные об участнике мероприятия.</p>
    <p>Операция delete позволяет удалить участника мероприятия.</p>
    <p>Операция filtr позволяет просмотреть участников определенного мероприятия.</p>
    <strong>event</strong>
   <p> Метод event принимает числовое значение, таким числом является id мероприятия.</p>
    <strong>email</strong>
   <p> Метод email принимает в качестве значения валидный email.</p>
    <strong>name</strong>
   <p> Метод name принимает в качестве значения Фамилию Имя и Отчество пользователя.</p>
    
    
