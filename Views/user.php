<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/hillstyle.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
  </head>
  <body class="user">
    <div class="sidebar">
      <div class="brand"><h1>TwoHills</h1></div>
      <div class="info">
        <img src="img/user.png" alt="">
        <span class="name" style="position:absolute;"><?php echo $fullName; ?></span>
        <span class="name"><a href="#">Editar</a></span>
      </div>
      <ul>
        <li><a href="watch.php">Videos de hoje</a></li>
      </ul>
      <form action="" method="post">
        <input class="btn-logout" type="submit" name="logout" value="Sair">
      </form>
    </div>

    <div class="content">
      <div class="navbar">
       <i class="fa fa-2x fa-bars" aria-hidden="true" onclick="toggle()"></i>
      </div>
      <div class="inside">

      </div>
    </div>

    <script type="text/javascript">
      function toggle() {
        var sidebar = document.getElementsByClassName("sidebar");
        var content = document.getElementsByClassName("content");
        if (sidebar[0].style.display == 'none') {
          sidebar[0].style.display = '';
          content[0].style.width = 'calc(100vw - 200px)';
        } else {
          sidebar[0].style.display = 'none';
          content[0].style.width = '100vw';
        }
      }
    </script>
  </body>
</html>
