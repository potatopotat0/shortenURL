<?php
header("Content-type: text/plain");
$path = dechex((time() * rand()) % 16777213);
$des = $_GET['url'];
$ch = curl_init($des);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
if($des == "") {
	$result = array(
		'code'	=> -1,
		'msg'	=> "No URL to be shortened."
	);
	die(json_encode($result));
} elseif(strpos($des, "ptt.pub") !== false) {
	$result = array(
		'code'	=> 514,
		'msg'	=> "shortenURL doesn't support creating shortened URL of " . $des
	);
} elseif(curl_errno($ch)) {
	$result = array(
		'code'	=> 404,
		'msg'	=> "The URL to be shortened doesn't exsit. Please check if there're misspellings"
	);
} else {
	mkdir("../" . $path, 0777);
	$resfile = fopen("../" . $path . "/index.htm", "w") or die("Unable to create file.");
	$content = "<!DOCTYPE html>\n<html>\n<head>\n<title>Redirecting...</title>\n</head>\n<body>\n<script>\n!function () {window.location.replace('" . $des . "');}()\n</script>\n</body>\n</html>";
	fwrite($resfile, $content);
	$result = array(
		'code'	=> 114,
		'msg'	=> 'succeed',
		'url'	=> 'https://ptt.pub/' . $path
	);
}
die(json_encode($result));
?>