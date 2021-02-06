<?php
ini_set('memory_limit', '536870912');
header("Content-type: text/json");
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
$post_data = array(
    'secret' => '<Your reCaptcha key here>',
    'response' => $_GET['key']
);
// var_dump($post_data);
$verifyRes = json_decode(curl_post('https://www.google.com/recaptcha/api/siteverify', $post_data), true);
// var_dump($verifyRes);
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
	$path = dechex((time() * rand()) % 15658736 + 1118481);
	$des = $_GET['url'];
	$ch = curl_init($des);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	if($des == "") {
		$result = array(
			'code'	=> -1,
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
			$des = "https://" . $des;
		}
		mkdir("../../" . $path, 0777);
		$resfile = fopen("../../" . $path . "/index.htm", "w") or die("Unable to create file.");
		$content = "<script>!function(){window.location.replace('" . $des . "');}()</script>";
		fwrite($resfile, $content);
		$result = array(
			'code'	=> 114,
			'msg'	=> 'succeed',
			'url'	=> 'https://ptt.pub/' . $path
		);
	}
}
die(json_encode($result));
?>