<?php
include 'config.php';
$DBCONN = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
if($DBCONN -> connect_error) {
	$res = array(
		'msg'  => "Database connection failure: " . $DBCONN -> connect_error,
		'code' => 501
	);
	die(json_encode($result));
}


/**
 * Short links API
 * Author: potatopotat0(https://intoyour.space)
 */
ini_set('memory_limit', '536870912');
if(!($_GET['rd'] == "")) {
	$des = $_GET['rd'];
	if(!(strpos($des, "/")) !== false) {
		$des = substr($des, -6);
	}
	$sql = "SELECT * FROM `links` WHERE `shortLink` LIKE '{$des}'";
	$result = $DBCONN -> query($sql);
	if ($result -> num_rows > 0) {
		$row = $result -> fetch_assoc();
		echo "<script>!function(){window.location.replace('{$row['longLink']}');}()</script>";
	} else {
		echo "<script>!function(){window.location.replace('../404.htm');}()</script>";
	}
	$DBCONN -> close();
} else {
	$des = $_GET['url'];
	if(!(strpos($des, "http://") !== false) && !(strpos($des, "https://") !== false)) {
		if(strpos($des, "http://") !== false) $des = "http://" . $des;
		else $des = "https://" . $des;
	}
	$sqll = "SELECT * FROM `links` WHERE `longLink` LIKE '{$des}'";
	$res = $DBCONN -> query($sqll);
	header("Content-type: text/json");
	if ($res -> num_rows > 0) {
		$row = $res -> fetch_assoc();
		$result = array(
			'code'	=> 114,
			'msg'	=> 'succeed',
			'url'	=> 'https://ptt.pub/' . $row['shortLink']
		);
	} else {
		for($i = 1; $i <= 30; ++$i) {
			if($i == 30) {
				$result = array(
					'code' => -1,
					'msg'  => "Failure generating a short link, please try again later or contact site administrator." 
				);
				die(json_encode($result));
			}
			$path = dechex((time() * rand()) % 15658736 + 1118481);
			$sql = "SELECT * FROM `links` WHERE `shortLink` LIKE '{$path}'";
			$result = $DBCONN -> query($sql);
			if(!($result -> num_rows > 0)) break;
		}
		$des = $_GET['url'];
		// $ch = curl_init($des);
		// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_exec($ch);
		if($des == "") {
			$result = array(
				'code'	=> 401,
				'msg'	=> "No URL to be shortened."
			);
		} elseif(strpos($des, "ptt.pub") !== false) {
			$result = array(
				'code'	=> 514,
				'msg'	=> "shortenURL does not support creating shortened URL of link \"" . $des . "\"."
			);
		// } elseif(curl_errno($ch)) {
			// $result = array(
				// 'code'	=> 404,
				// 'msg'	=> "Cannot connect to the target server."
			// );
		} else {
			if(!(strpos($des, "http://") !== false) && !(strpos($des, "https://") !== false)) {
				if(strpos($des, "http://") !== false) $des = "http://" . $des;
				else $des = "https://" . $des;
			}
			$result = array(
				'code'	=> 114,
				'msg'	=> 'succeed',
				'url'	=> 'https://ptt.pub/' . $path
			);
			$sql = "INSERT INTO `links` (`shortLink`, `longLink`, `time`, `requestIP`, `requestUA`)
			VALUES ('{$path}', '" . urldecode($des) . "', CURRENT_TIMESTAMP, '{$_SERVER["REMOTE_ADDR"]}', '{$_SERVER['HTTP_USER_AGENT']}')";
			if($DBCONN -> query($sql) == false) die("Error: " . $sql . "\n" . $DBCONN -> error);
		}
	}
	$DBCONN -> close();
	die(json_encode($result));
}
?>