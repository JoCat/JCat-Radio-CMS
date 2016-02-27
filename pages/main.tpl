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
            <li><a href="/play">Listen</a></li>
            <li><a href="/rj">RJ</a></li>
            <li><a href="/prog">Programs</a></li>
            <li><a href="/rasp">Schedule</a></li>
            <li><a href="/img">Background Images</a></li>
          </ul>
          <ul class="nav navbar-nav right">
            <li><a href="/admin.php">Admin panel</a></li>
          </ul>
        </div>
      </div>
    </nav>
    
    <script type='text/javascript'>
    document.write('<style>#js_check {display:none;}</style>');
    </script>
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
      <div class="container">
        <div>&nbsp;</div>
        <div class="left-side">
          <div class="block">
            <div><b>Information Block</b></div>
            <div>Information Block Content</div>            
          </div>
          <div class="block">
            <div><b>Information Block</b></div>
            <div>Information Block Content</div>            
          </div>
          <div class="block">
            <div><b>Information Block</b></div>
            <div>Information Block Content</div>            
          </div>
        </div>
        <div class="right-side">
        {content}
        </div>
      </div>
    </div>
    
    </div>
    
    <!-- Script Start -->
    <script type="text/javascript" src="{dir}/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="{dir}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{dir}/js/background-slide.js"></script>
    <script type="text/javascript" src="//jcat.tk/js/SmoothScroll.js"></script>
    <!-- Script End -->
    
    <!-- Footer -->
    <footer>
    <div class="container">
      <div class="left">
        <b>JLE</b> Template 2016. All rights reserved.<br>
        Contact the administration: <a href="{adm_mail}">{adm_mail}</a><br>
        Design and Development: <a href="http://vk.com/johny_cat">Johny_Cat</a> (<a href="http://jcat.tk/">JCat.tk</a>)
      </div>
      <div class="right" style="text-align: right;">
        counters<br>
        Powered by JLE v0.5
      </div>
    </div>
    </footer>
    <!-- Footer End -->
</body>
</html>