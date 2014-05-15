<?php

define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

define('THEMESDIR', '/themes' . DIRECTORY_SEPARATOR);

$old_ob_level = ob_get_level();

//get basedir;
$base_url = preg_replace('%/index.php%i','',$_SERVER['PHP_SELF']);
$config = require ROOT . 'config.php';
$refresh = $config['refresh'];
$theme = $config['theme'];
$dbInfo = $config['database'];
$pdo = new PDO($dbInfo['conn'],$dbInfo['user'],$dbInfo['pass']);

//get Servers
$servers = array();
$sTable = '';
$sql = "SELECT * FROM `servers` ORDER BY id ASC";
foreach($pdo->query($sql) as $result) {
  $servers[$result["id"]] = 'online' . $result["id"];
    $sTable .= '
    <tr>
      <td id="online'.$result["id"].'" class="status">
        <div class="progress">
          <div class="bar bar-danger" style="width: 100%;"><small>Down</small></div>
        </div>
      </td>
      <td>'.$result["name"].'</td>
      <td>'.$result["type"].'</td>
      <td>'.$result["host"].'</td>
      <td>'.$result["location"].'</td>
      <td id="uptime'.$result["id"].'">n/a</td>
      <td id="load'.$result["id"].'">n/a</td>
      <td id="memory'.$result["id"].'">
        <div class="progress progress-striped active">
          <div class="bar bar-danger" style="width: 100%;"><small>n/a</small></div>
        </div>
      </td>
      <td id="hdd'.$result["id"].'">
        <div class="progress progress-striped active">
          <div class="bar bar-danger" style="width: 100%;"><small>n/a</small></div>
        </div>
      </td>
    </tr>
  ';
}

if (ob_get_level() > $old_ob_level + 1) {
  ob_end_flush();
}
ob_start();
include(ROOT.'views/status.php');
$buffer = ob_get_contents();
ob_end_clean();
echo $buffer;

