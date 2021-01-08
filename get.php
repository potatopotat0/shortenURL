<?php
$des = $_GET['url'];
$res = json_decode(@file_get_contents('https://ptt.pub/api/?url=' . urlencode($des)), true);
if($res['code'] == "114") {
	echo "<!DOCTYPE html>\n<html>\n<head>\n<title>Redirecting...</title>\n</head>\n<body>\n<script>\n!function () {window.location.replace('https://ptt.pub/?url=" . $res['url'] . "');}()\n</script>\n</body>\n</html>";
}
else {
	echo "<!DOCTYPE html>\n<html>\n<head>\n<title>Redirecting...</title>\n</head>\n<body>\n<script>\n!function () {window.location.replace('https://ptt.pub/?url=" . $res['msg'] . "');}()\n</script>\n</body>\n</html>";
}
?>