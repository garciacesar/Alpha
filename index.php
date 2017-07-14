<?php
  require_once 'Config/Connect.php';
  require_once 'Classes/Login.php';
  $login = new Login();

  if ($login->isUserLogged() AND $_SESSION['level'] == 1) {
    $email = $_SESSION['email'];
    $firstname = $_SESSION['firstname'];
    $surname = $_SESSION['surname'];
    if ($firstname == null) {
      $fullName = $email;
    } else {
      $fullName = $firstname . " " . $surname;
    }
    $birthday = $_SESSION['birthday'];
    $sex = $_SESSION['sex'];
    $registration_datetime = $_SESSION['registration_datetime'];
    $registration_ip = $_SESSION['registration_ip'];
    require_once 'Views/user.php';
  } elseif ($login->isUserLogged() AND $_SESSION['level'] == 7) {
    require_once 'Views/admin.php';
  } else {
     require_once 'Views/login.php';
  }
