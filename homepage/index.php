<?php
  if (file_exists('./scripts/thisrun.txt')) {
    $config = parse_ini_file('./scripts/thisrun.txt');
  } elseif (file_exists('./scripts/firstrun.ini')) {
    $config = parse_ini_file('./scripts/firstrun.ini');
  }
  if($config["SITE_NAME"] == "") {
    $site_name = "BirdNET-Pi";
  } else {
    $site_name = $config['SITE_NAME'];
  }
?>
<title><?php echo $site_name; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body::-webkit-scrollbar {
  display:none
}
</style>
<link rel="stylesheet" href="style.css?v=8.05.22">
<link rel="stylesheet" type="text/css" href="static/dialog-polyfill.css" />
<body>
<div class="banner">
  <div class="logo">
<?php if(isset($_GET['logo'])) {
echo "<a href=\"https://github.com/wilpat1024/BirdNET-Pi.git\" target=\"_blank\"><img style=\"width:40;height:40;\" src=\"images/whiteLoon.png\"></a>";
} else {
echo "<a href=\"https://github.com/wilpat1024/BirdNET-Pi.git\" target=\"_blank\"><img style=\"width:280;height:160;\" src=\"images/whiteLoon.png\"></a>";
}?>
  </div>


  <div class="stream">
<?php
if(isset($_GET['stream'])){
  if (file_exists('./scripts/thisrun.txt')) {
    $config = parse_ini_file('./scripts/thisrun.txt');
  } elseif (file_exists('./scripts/firstrun.ini')) {
    $config = parse_ini_file('./scripts/firstrun.ini');
  }
  $caddypwd = $config['CADDY_PWD'];
  if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'You cannot listen to the live audio stream';
    exit;
  } else {
    $submittedpwd = $_SERVER['PHP_AUTH_PW'];
    $submitteduser = $_SERVER['PHP_AUTH_USER'];
    if($submittedpwd == $caddypwd && $submitteduser == 'birdnet'){
      echo "
  <audio controls autoplay><source src=\"/stream\"></audio>
  </div>
  <h1><a href=\"/\"><img class=\"topimage\" src=\"images/bnp.png\"></a></h1>
  </div>";
    } else {
      header('WWW-Authenticate: Basic realm="My Realm"');
      header('HTTP/1.0 401 Unauthorized');
      echo 'You cannot listen to the live audio stream';
      exit;
    }
  }
} else {
    echo "
  <form action=\"\" method=\"GET\">
    <button type=\"submit\" name=\"stream\" value=\"play\">Live Audio</button>
  </form>
  </div>
  <h1><a href=\"/\"><img class=\"topimage\" src=\"images/bnp.png\"></a></h1>
</div><div class=\"centered\"><h3>$site_name</h3></div>";
}
if(isset($_GET['filename'])) {
  $filename = $_GET['filename'];
echo "
<iframe src=\"/views.php?view=Recordings&filename=$filename\"></iframe>
</div>";
} else {
  echo "
<iframe src=\"/views.php\"></iframe>
</div>";
}

