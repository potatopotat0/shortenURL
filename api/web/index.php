<?php
$SERVER = "localhost";
$DATABASE = "<DATABASE>";
$USERNAME = "<USERNAME>";
$PASSWORD = "<PASSWORD>";
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
function curl_post($url,$array){  
    $curl = curl_init();  
    curl_setopt($curl, CURLOPT_URL, $url);  
    curl_setopt($curl, CURLOPT_HEADER, 0);   
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($curl, CURLOPT_POST, 1);  
    $post_data = $array;  
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;  
} 
ini_set('memory_limit', '536870912');
header("Content-type: text/json");
$post_data = array(
    'secret' => '<YOUR GOOGLE RECAPTCHA KEY>',
    'response' => $_GET['key']
);
$verifyRes = json_decode(curl_post('https://www.google.com/recaptcha/api/siteverify', $post_data), true);
/*
missing-input-secret	The secret parameter is missing.
invalid-input-secret	The secret parameter is invalid or malformed.
missing-input-response	The response parameter is missing.
invalid-input-response	The response parameter is invalid or malformed.
bad-request				The request is invalid or malformed.
timeout-or-duplicate	The response is no longer valid: either is too old or has been used previously.
*/
if($verifyRes['success'] == false) {
	switch ($verifyRes['error-codes'][0]) {
		case 'missing-input-secret':
			$errmsg = 'The secret parameter is missing.';
			break;
		case 'invalid-input-secret':
			$errmsg = 'The secret parameter is invalid or malformed.';
			break;
		case 'missing-input-response':
			$errmsg = 'The response parameter is missing.';
			break;
		case 'invalid-input-response':
			$errmsg = 'The response parameter is invalid or malformed.';
			break;
		case 'bad-request':
			$errmsg = 'The request is invalid or malformed.';
			break;
		case 'timeout-or-duplicate':
			$errmsg = 'The response is no longer valid: either is too old or has been used previously.';
			break;
		default:
			$errmsg = 'Google reCaptcha unknown error.';
			break;
	}
	$result = array(
		'code'	=> 502,
		'status'=> $verifyRes['error-codes'][0],
		'msg'	=> $errmsg
	);
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
		$ch = curl_init($des);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
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
		} elseif(curl_errno($ch)) {
			$result = array(
				'code'	=> 404,
				'msg'	=> "Cannot connect to the target server."
			);
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
			$sql = "INSERT INTO `links` (`shortLink`, `longLink`, `time`)
			VALUES ('" . $path . "', '" . urldecode($des) . "', CURRENT_TIMESTAMP)";
			if($DBCONN -> query($sql) == false) die("Error: " . $sql . "\n" . $DBCONN -> error);
		}
	}
	$DBCONN -> close();
}
die(json_encode($result));
?>