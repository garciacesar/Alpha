<?php

require_once '../Classes/Videos.php';
require_once '../Config/Connect.php';
$crawler = new Videos();

foreach ($crawler->listChannels() as $key => $value) {
  $channel = $value->channel;
  $idChannel = $value->id;
  $url = "https://youtube.com/channel/" . $channel . "/videos";

  $content = file_get_contents($url);
  preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $content, $result);

  $links = array();
  $links = $result['href'];
  $links = array_unique($links);

  foreach ($links as $key => $value) {
    $videos = strripos($value, '/watch?v=');

    if ($videos === 0) {
      $video = explode("=", $value);
      $video = $video[1];

      echo $crawler->insertVideo($video, $idChannel) . "<br>";

    }
  }
}

echo '<meta http-equiv="refresh" content="15;url=crawler.php" />';
