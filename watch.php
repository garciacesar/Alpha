<?php
  require_once 'Config/Connect.php';
  require_once 'Classes/Videos.php';
  require_once 'Classes/Login.php';
  $videos = new Videos();
  $login = new Login();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/hillstyle.css">
  </head>
  <body class="watch">

    <?php
      if ($login->isUserLogged()) {
    ?>
    <script src="http://www.youtube.com/iframe_api"></script>

     <script>
     function onPlayerStateChange(event) {
         switch(event.data) {
             case YT.PlayerState.ENDED:
                 location.reload();
                 break;
         }
     }

     var player;
     function onYouTubeIframeAPIReady() {
         var vidId = '<?php echo $videos->userVideos(); ?>';
            player= new YT.Player('hills', {
                 videoId: vidId,
                 events: {
                     'onStateChange': onPlayerStateChange
                 },
                 playerVars: { autohide: 1, rel: 0, autoplay: 1, hd: 1, }
             });
     }
     </script>

    <?php
      } else {
    ?>
    <script src="http://www.youtube.com/iframe_api"></script>

     <script>
     function onPlayerStateChange(event) {
         switch(event.data) {
             case YT.PlayerState.ENDED:
                 location.reload();
                 break;
         }
     }

     var player;
     function onYouTubeIframeAPIReady() {
         var vidId = '<?php echo $videos->todayVideos(); ?>';
            player= new YT.Player('hills', {
                 videoId: vidId,
                 events: {
                     'onStateChange': onPlayerStateChange
                 },
                 playerVars: { autohide: 1, rel: 0, autoplay: 1, hd: 1, }
             });
     }
     </script>
    <?php
      }
    ?>
    <div class="player" id="hills"></div>
    <button type="button" class="next" onclick="location.reload();">Next</button>
    <button type="button" class="quit" onClick="window.location.href='index.php'">Sair</button>
  </body>
</html>
