<?php
require_once 'Classes/Registration.php';
$registration = new Registration();

if ($registration->errors) {
    foreach ($registration->errors as $error) {
        echo $error;
    }
    $email = $_POST['email'];
} else {
   $email = "";
}
if ($registration->messages) {
    foreach ($registration->messages as $message) {
        echo $message;
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Test</title>
    <link rel="stylesheet" href="css/hillstyle.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
    <div class="register">
      <?php if (!$registration->registration_successful && !$registration->verification_successful) { ?>
        <h1 style="text-align:center;">Registrar</h1>
        <form action="" method="post">
          <input class="input" type="text" class="formInput" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email" required>
          <input class="input" type="password" class="formInput" id="password" name="password" value="" placeholder="Senha" required>
          <input class="input" type="password" class="formInput" id="passwordAgain" name="repeatPass" value=""
                                    placeholder="Repetir Senha" onchange="validatePass()" required>
          <div class="g-recaptcha" data-sitekey="6LdZiCgUAAAAABGn2eJOe0_js4IvmNZQWcrTf7O9"></div>
          <input class="btn btn-green bottom left" type="submit" id="register" name="register" value="Registrar">
          <input class="btn btn-gray bottom right" type="button" value="Voltar" onclick="location.href = 'index.php';">
        </form>
      <?php } ?>
    </div>

    <script type="text/javascript">
      function validatePass(){
        var password = document.getElementById('password');
        var passwordAgain = document.getElementById('passwordAgain');
        var register = document.getElementById('register');
        var email = document.getElementById('email');

        if (password.value == passwordAgain.value) {
          password.style.borderColor = "green";
          passwordAgain.style.borderColor = "green";
          register.disabled = false;
        } else {
          password.style.borderColor = "red";
          passwordAgain.style.borderColor = "red";
          register.disabled = true;
        }
      }
    </script>

  </body>
</html>
