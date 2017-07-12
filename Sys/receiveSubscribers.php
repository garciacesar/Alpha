<?php
require_once '../Config/Connect.php';
require_once '../Classes/Login.php';
require_once '../Classes/Channel.php';
require_once '../Libraries/Google/vendor/autoload.php';

$login = new Login();
$channel = new Channel();

if ($login->isUserLogged()) {

$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
$client->setScopes('https://www.googleapis.com/auth/youtube');
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
  FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

// Check if an auth token exists for the required scopes
$tokenSessionKey = 'token-' . $client->prepareScopes();
if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
}

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    // Call the channels.list method to retrieve information about the
    // currently authenticated user's channel.
    $htmlBody = "";
    $subList = $youtube->subscriptions->listSubscriptions('snippet', array(
      'mine'=>'true', 'maxResults'=> 50));

      foreach ($subList['items'] as $subscribers) {
        $channelTittle = $subscribers['snippet']['title'];
        $channelId = $subscribers['snippet']['resourceId']['channelId'];

        $channel->insertChannel($channelId, $channelTittle);
        $channel->insertSubscriptions($channelId, $_SESSION['id']);
      }
      echo "<h1>Inscrições importadas com sucesso</h1>";
      echo '<meta http-equiv="refresh" content="3; url=../" />';

  } catch (Google_Service_Exception $e) {
    $htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
      session_destroy();
  } catch (Google_Exception $e) {
    $htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }

  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
} else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
  ?>

  <!doctype html>
  <html>
    <head>
      <title>My Uploads</title>
    </head>
    <body>
      <?=$htmlBody?>
    </body>
  </html>

<?php } else {
  header("location:../index.php");
}
