<?php
/**
 * Short links API
 * Author: potatopotat0(https://intoyour.space)
 */
ini_set('memory_limit', '536870912');
header("Content-type: text/plain");
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
	mkdir("../" . $path, 0777);
	$resfile = fopen("../" . $path . "/index.htm", "w") or die("Unable to create file.");
	$content = "<script>!function(){window.location.replace('" . $des . "');}()</script>";
	fwrite($resfile, $content);
	$result = array(
		'code'	=> 114,
		'msg'	=> 'succeed',
		'url'	=> 'https://ptt.pub/' . $path
	);
}
die(json_encode($result));
?>