<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>JRE Admin Panel</title>
    <link rel="stylesheet" href="/engine/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/engine/admin/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    {messages}
    <div class="auth-form">
      {content}
    </div>
    <script src="/engine/admin/js/jquery-2.1.4.min.js"></script>
    <script>
      $(window).resize(function(){
        $('.auth-form').css({
          position:'absolute',
          left: ($(window).width() - $('.auth-form').outerWidth())/2,
          top: ($(window).height() - $('.auth-form').outerHeight())/2
        });
      });
      // Для запуска функции при загрузке окна:
      $(window).resize();
    </script>
  </body>
</html>