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
        <?php if ($firstname != null) { ?>
        <span class="name" style="position:absolute;"><?php echo $fullName; ?></span>
        <?php } else { ?>
          <span class="name"><p><?php echo $fullName; ?></p></span>
        <?php } ?>
        <span class="name" style=""><a href="#edit" onclick="edit()">Editar</a></span>
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
        <div class="home">
          <input class="btn btn-red" type="button" value="Sincronizar canais do youtube" onclick="location.href = 'Sys/receiveSubscribers.php';" style="width: 30%; margin: 10px 10px;">
        </div>
        <div class="edit">
          <span style="float:right;">User > Edit</span><br>
          <hr>
          <h2 style="padding-top: 10px;">Edit</h2>
          <form action="" method="post">
            <input type="text" name=firstname"" value="<?php echo $firstname; ?>" placeholder="<?php echo 'Firstname: ' . $firstname; ?>" style="display: inline; width: 45%;">
            <input type="text" name="surname" value="" placeholder="<?php echo 'Surname: ' . $surname; ?>" style="display: inline; width: 45%;">
            <input type="date" name="birthday" value="" placeholder="<?php echo 'Birthday: ' . $birthday ?>" style="display: inline; width: 45%;">
            <input type="text" name="" value="" placeholder="<?php echo 'Sex: ' . $sex; ?>" style="display: inline; width: 45%;">
            <input type="text" name="" value="" placeholder="<?php echo 'Email: ' . $email; ?>">
            <input type="password" name="" value="" placeholder="Change password" style="display: inline; width: 45%;">
            <input type="password" name="" value="" placeholder="Repeat new password" style="display: inline; width: 45%;"><br><br>
            <input class="btn btn-green" type="submit" name="edit" value="Salvar" style="width: 150px;">
          </form>
          <div class="summary">
            <b>Registration date:</b> <?php echo $registration_datetime; ?><br><br>
            <b>Registration ip:</b> <?php echo $registration_ip; ?>
          </div>
        </div>
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

      function edit() {
        var home = document.getElementsByClassName("home");
        var edit = document.getElementsByClassName("edit");
        if (edit[0].style.display == '') {
          home[0].style.display = 'none';
          edit[0].style.display = 'block'
        } else {
          edit[0].style.display = '';
          home[0].style.display = 'none';
        }
      }


    </script>
  </body>
</html>
