<?php
header("HTTP/1.1 404 Not Found");
?>
<html>
  <head>
    <title>Ошибка 404: Страница не найдена</title>
    <style>
    body{
      margin:0px;
      width: 100%;
      height: 100%;
      position: fixed;
      background-color: #f2f2f2;
    }
    .error{
      margin: auto;
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
    }
    </style>
  </head>
  <body>
    <img class="error" src="/modules/errors/images/404.jpg">
  </body>
</html>