<?php
  require_once 'Config/Connect.php';
  require_once 'Classes/Login.php';
  $login = new Login();

  if ($login->isUserLogged() AND $_SESSION['level'] == 1) {
    $firstname = $_SESSION['firstname'];
    $surname = $_SESSION['surname'];
    $fullName = $firstname . " " . $surname;
    require_once 'Views/user.php';
  } elseif ($login->isUserLogged() AND $_SESSION['level'] == 7) {
    require_once 'Views/admin.php';
  } else {
     require_once 'Views/login.php';
  }
