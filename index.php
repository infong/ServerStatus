<?php
include('./includes/config.php');
global $sJavascript, $sTable;

$query = mysql_query("SELECT * FROM servers ORDER BY id") or die(mysql_error());
$servers = array();
while($result = mysql_fetch_array($query)){
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

$refresh = $sSetting['refresh'];
include($index);

?>
