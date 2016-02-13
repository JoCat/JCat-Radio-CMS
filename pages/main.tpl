<!DOCTYPE html>
<html>
<head>
    {head}
    <link rel="shortcut icon" href="{dir}/images/radio.ico" />
    <link rel="stylesheet" type="text/css" href="{dir}/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{dir}/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-fixed-top navbar-default">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="/">Main</a></li>
            <li><a href="/news">News</a></li>
            <li><a href="/page1">Page 1</a></li>
            <li><a href="/page2">Page 2</a></li>
          </ul>
          <ul class="nav navbar-nav right">
            <li><a href="/admin">Admin panel</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div id="js_check">
    Для правильной работы сайта рекомендуем включить поддержку JavaScript на нашем сайте.<br>
    Если вы не отключали поддержку JavaScript, то возможно ваш браузер устарел или он не поддерживает JavaScript.
    </div>
    
    <div class="placeholder">
      <div class="container">
        <h1>Default Template</h1>
        <p>Test site for JLE</p>
      </div>
    </div>
    
    <div id="content" class="neighborhood-guides">
    {content}
    </div>
    
    </div>
    
    <!-- Script Start -->
    <script type="text/javascript" src="{dir}/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="{dir}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{dir}/js/background-slide.js"></script>
    <script type="text/javascript" src="//jcat.tk/js/SmoothScroll.js"></script>
    <script type='text/javascript'>
    document.write('<style>#js_check {display:none;}</style>');
    </script>
    <!-- Script End -->
    
    <!-- Footer -->
    <footer>{footer}</footer>
    <!-- Footer End -->
</body>
</html>