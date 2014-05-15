<?php
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('THEMESDIR', '/themes' . DIRECTORY_SEPARATOR);

$config = require(ROOT . 'config.php');

function get_data($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'curl/7.29.0';
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    //curl_setopt($ch, CURLOPT_INTERFACE, $_SERVER['REMOTE_ADDR']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$sId = intval($_GET['url']);
if(is_numeric($sId)){
    $dbInfo = $config['database'];
    $pdo = new PDO($dbInfo['conn'],$dbInfo['user'],$dbInfo['pass']);
    $stmt = $pdo->prepare("SELECT * FROM servers WHERE id=".$sId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $url = "http://".$result['url']."/uptime.php";
    $output = get_data($url);
    if(($output == NULL) || ($output === false)){
        $array = array();
        $array['uptime'] = '
        <div class="progress">
            <div class="bar bar-danger" style="width: 100%;"><small>Down</small></div>
        </div>
        ';
        $array['load'] = '
        <div class="progress">
            <div class="bar bar-danger" style="width: 100%;"><small>Down</small></div>
        </div>
        ';
        $array['online'] = '
        <div class="progress">
            <div class="bar bar-danger" style="width: 100%;"><small>Down</small></div>
        </div>
        ';
        echo json_encode($array);
    } else {
        $data = json_decode($output, true);
        $data["load"] = number_format($data["load"], 2);
        echo json_encode($data);
    }
}
