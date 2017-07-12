<?php
/**
 *
 */

class Videos{

  protected $videos = "videos";
  protected $channels = "channels";
  protected $subscriptions = "subscriptions";

  public function insertVideo($video, $idChannel){
    $verify = "SELECT id FROM $this->videos WHERE video = :video";
    $stmt = DB::prepare($verify);
    $stmt->bindValue(':video', $video, PDO::PARAM_STR);
    $stmt->execute();
    $verify = $stmt->fetchAll();

    if (count($verify) == 0) {
      $sql = "INSERT INTO $this->videos (video, id_channel, `datetime`) VALUES (:video, :id_channel, NOW())";
      $stmt = DB::prepare($sql);
      $stmt->bindValue(':video', $video, PDO::PARAM_STR);
      $stmt->bindValue(':id_channel', $idChannel, PDO::PARAM_INT);
      $stmt->execute();
      echo "Video " , $video , " cadastrado";
    }
  }

  public function todayVideos(){
    if (!isset($_SESSION['count'])) {
      $_SESSION['count'] = 100000000000;
      $count = $_SESSION['count'];
    } else {
      $count = $_SESSION['count'];
    }

    $sql = "SELECT * FROM $this->videos WHERE id < :count AND DATE(`datetime`) = CURDATE() ORDER BY id ASC LIMIT 1";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':count', $count, PDO::PARAM_INT);
    $stmt->execute();
    $video = $stmt->fetch();

    echo $video->video;
    $_SESSION['count'] = $video->id;

  }

  public function userVideos(){
    if (!isset($_SESSION['counter'])) {
      $_SESSION['counter'] = 0;
      $count = $_SESSION['counter'];
    } else {
      $count = $_SESSION['counter'];
    }

    $idUser = $_SESSION['id'];

    $sql = "SELECT `videos`.* FROM $this->videos INNER JOIN $this->subscriptions ON `videos`.`id_channel` = `subscriptions`.`id_channel` WHERE `videos`.`id` > :count AND `subscriptions`.`id_user` = :id_user AND DATE(`datetime`) = CURDATE() ORDER BY `videos`.`id` ASC LIMIT 1";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
    $stmt->bindValue(':count', $count, PDO::PARAM_INT);
    $stmt->execute();
    $video = $stmt->fetch();

    echo $video->video;
    $_SESSION['counter'] = $video->id;
  }

  public function listChannels(){
    $sql = "SELECT id, channel FROM $this->channels";
    $stmt = DB::prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

}
