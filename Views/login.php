<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/hillstyle.css">
  </head>
  <body>
    <div class="login">
      <h1 style="text-align:center;">Login</h1>
      <form action="" method="post">
        <input class="input" type="text" name="email" value="" placeholder="Email">
        <input class="input" type="password" name="password" value="" placeholder="Senha">
        <?php
          if ($login->errors) {
            foreach ($login->errors as $error) {
              echo $error;
            }
          }
          if ($login->messages) {
            foreach ($login->messages as $message) {
              echo $message;
            }
          }
        ?>
        <input class="btn btn-green bottom left" type="submit" name="login" value="Logar">
        <!-- <input class="btn btn-gray bottom right" type="button" value="Registrar" onclick="location.href = 'register.php';"> -->
      </form>
    </div>
  </body>
</html>
