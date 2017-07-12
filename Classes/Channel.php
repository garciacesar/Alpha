<?php
/**
 * Project: Alpha
 * Author: Cesar Garcia
 * File: Channels Class
 * Version: 1.0
 */
class Channel{

  protected $channels = "channels";
  protected $subscriptions = "subscriptions";

  public function insertChannel($channel, $description){
    $sql = "SELECT channel FROM $this->channels WHERE channel = :channel";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':channel', $channel, PDO::PARAM_STR);
    $stmt->execute();
    $verify = $stmt->fetchAll();

    if (count($verify) == 0) {
      $sqlInsert = "INSERT INTO $this->channels (channel, description) VALUES (:channel, :description)";
      $stmt = DB::prepare($sqlInsert);
      $stmt->bindValue(':channel', $channel, PDO::PARAM_STR);
      $stmt->bindValue(':description', $description, PDO::PARAM_STR);
      $stmt->execute();
    }
  }

  public function insertSubscriptions($channel, $idUser){
    $sql = "SELECT id FROM $this->channels WHERE channel = :channel";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':channel', $channel, PDO::PARAM_STR);
    $stmt->execute();
    $idChannel = $stmt->fetch();

    $verify = "SELECT id FROM $this->subscriptions WHERE id_channel = :id_channel AND id_user = :id_user";
    $stmt = DB::prepare($verify);
    $stmt->bindValue(':id_channel', $idChannel->id, PDO::PARAM_INT);
    $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
    $stmt->execute();
    $verify = $stmt->fetchAll();

    if (count($verify) == 0) {
      $insertSubs = "INSERT INTO $this->subscriptions (id_channel, id_user) VALUES (:id_channel, :id_user)";
      $stmt = DB::prepare($insertSubs);
      $stmt->bindValue(':id_channel', $idChannel->id, PDO::PARAM_INT);
      $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

}
