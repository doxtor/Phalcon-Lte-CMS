{{ content() }}
<div class="error-actions">
   <img src="/images/error.png">
   <h1>Неавторизованный пользователь</h1>
   <p>У Вас не достаточно прав на просмотр этой страницы. Пожалуйста авторизуйтесь или свяжитесь с администратором</p>
   <p>{{ link_to('/', 'На главную', 'class': 'btn btn-primary') }}</p>
</div>