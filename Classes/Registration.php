<?php
/**
* Project: Alpha
* File: Registration class
* Author: Cesar Garcia
* Version: 1.0
**/

require_once 'Config/Connect.php';
require_once 'Libraries/phpmailer/PHPMailerAutoload.php';

class Registration{

  public  $registration_successful  = false;
  public  $verification_successful  = false;
  public  $errors                   = array();
  public  $messages                 = array();

  function __construct(){
    if (isset($_POST['register'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $this->registerNewUser($email, $password);
    } else if (isset($_GET["id"]) && isset($_GET["verification_code"])) {
      $this->verifyNewUser($_GET["id"], $_GET["verification_code"]);
    }
  }

  private function registerNewUser($email, $password){
    $email = trim($email);

    $checkEmail = "SELECT email FROM users WHERE email = :email";
    $stmt = DB::prepare($checkEmail);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $checkEmail = $stmt->fetchAll();

    if (count($checkEmail) > 0) {
      $this->errors[] = EMAIL_ALREADY_EXISTS;
    } else {
      $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
      $password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
      $activation_hash = sha1(uniqid(mt_rand(), true));

      $new_user = "INSERT INTO users (password_hash, email, activation_hash, registration_ip, registration_datetime) VALUES(:password_hash, :email, :activation_hash, :registration_ip, now())";
      $stmt = DB::prepare($new_user);
      $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':activation_hash', $activation_hash, PDO::PARAM_STR);
      $stmt->bindValue(':registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);

      if ($stmt->execute()) {
        $id = "SELECT id FROM users WHERE email = :email";
        $stmt = DB::prepare($id);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $result["id"];

        $this->sendEmail($id, $email, $activation_hash);
      } else {
        $this->errors[] = ACCOUNT_NOT_CREATED;
      }

    }
  }

  public function sendEmail($id, $email, $activation_hash){

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'smtp.umbler.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
    $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
    $mail->Port       = 587; //  Usar 587 porta SMTP
    $mail->Username = ''; // Usuário do servidor SMTP (endereço de email)
    $mail->Password = ''; // Senha do servidor SMTP (senha do email usado)

    $mail->SetFrom('cesar@twohills.com.br', 'TwoHills Team'); //Seu e-mail
    $mail->AddAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Ativação de conta: TwoHills TV';//Assunto do e-mail
    $mail->Body    = 'Bem vindo a TwoHills TV, abaixo está o link de ativacão da sua conta para fazer parte da familia TwoHills :)<br><br>https://twohills.com.br/tv/register?id=' . urlencode($id) . '&verification_code=' . urlencode($activation_hash);

    if(!$mail->Send()){
      $query_delete_user = "DELETE FROM users WHERE id=:id";
      $stmt = DB::prepare($query_delete_user);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
    } else {
      $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
      $this->registration_successful = true;
    }
  }

  public function verifyNewUser($id, $activation_hash){

      // try to update user with specified information
      $query_update_user = "UPDATE users SET active = 1, level = 1, activation_hash = NULL WHERE id = :id AND activation_hash = :activation_hash";
      $stmt = DB::prepare($query_update_user);
      $stmt->bindValue(':id', intval(trim($id)), PDO::PARAM_INT);
      $stmt->bindValue(':activation_hash', $activation_hash, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
          $this->verification_successful = true;
          $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
          header( "refresh:3;url=/" );
      } else {
          $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
      }
  }
}
