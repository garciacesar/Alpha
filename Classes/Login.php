<?php
/**
* Project: Alpha
* File: Login class
* Author: Cesar Garcia
* Version: 1.0
* Level status:
*   - 0 Not active
*   - 1 Default user
*   - 7 Admin user
**/

class Login{

  private $id = null;
  private $email = "";
  private $logged = false;

  public $errors = array();
  public $messages = array();

  function __construct(){
    session_start();

    if (isset($_POST['logout'])) {
      $this->logout();
    } elseif (!empty($_SESSION['email']) && ($_SESSION['logged'] == true)) {
      $this->loginWithSession();
    } elseif (isset($_COOKIE['rememberme'])) {
      $this->loginWithCookie();
    } elseif (isset($_POST['login'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      if (!isset($_POST['rememberme'])) {
        $rememberme = $_POST['rememberme'] = null;
      }
      $this->loginWithPost($email, $password, $rememberme);
    }elseif (isset($_POST['register'])) {
      header('Location:register.php');
    }

  }

  private function userData($email){
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchObject();
  }

  private function logout(){
    $_SESSION = array();
    session_destroy();

    $this->logged = false;
    $this->messages[] = MESSAGE_LOGOUT;
  }

  private function loginWithSession(){
    $this->email = $_SESSION['email'];
    $this->logged = true;
  }

  private function loginWithPost($email, $password, $rememberme){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $result = $this->userData(trim($email));
    } else {
      $sql = "SELECT * FROM users WHERE email = :email";
      $stmt = DB::prepare($sql);
      $stmt->bindValue(':email', trim($email), PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchObject();
    }

    if (!isset($result->id)) {
      $this->errors[] = LOGIN_FAIL;
    } elseif (($result->failed_logins >= 3) && ($result->last_failed_login > (time() - 30))) {
      $this->errors[] = PASSWORD_WRONG_3_TIMES;
      //Enviar email para usuario de recuperacao
    } elseif (!password_verify($password, $result->password_hash)) {
      $sql = "UPDATE users SET failed_logins = failed_logins+1, last_failed_login = :last_failed_login WHERE email = :email OR email = :email";
      $stmt = DB::prepare($sql);
      $stmt->execute(array(':email' => $email, ':last_failed_login' => time()));

      $this->errors[] = PASSWORD_WRONG;
    } elseif ($result->active != 1) {
      $this->errors[] = ACCOUNT_NOT_ACTIVATED;
    } else {
      $_SESSION['id'] = $result->id;
      $_SESSION['firstname'] = $result->firstname;
      $_SESSION['surname'] = $result->surname;
      $_SESSION['email'] = $result->email;
      $_SESSION['level'] = $result->level;
      $_SESSION['logged'] = true;

      $this->id = $result->id;
      $this->email = $result->email;
      $this->logged = true;

      $sql = "UPDATE users SET failed_logins = 0, last_failed_login = NULL WHERE id = :id AND failed_logins != 0";
      $stmt = DB::prepare($sql);
      $stmt->bindValue(':id', $result->id);
      $stmt->execute();

      //criar rememberme validator

    }
  }

  public function isUserLogged(){
    return $this->logged;
  }

}
