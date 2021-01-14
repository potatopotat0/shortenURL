<!DOCTYPE html>
<!--
 ____  _____  ____  ____  ____  _  _/ ____   __    ____  ____  _  _ 
(  _ \(  _  )(  _ \(  _ \(_  _)( \( )(  _ \ /__\  (  _ \(_  _)( \/ )
 )___/ )(_)(  )___/ )___/ _)(_  )  (  )___//(__)\  )   /  )(   \  / 
(__)  (_____)(__)  (__)  (____)(_)\_)(__) (__)(__)(_)\_) (__)  (__) 
-->
<html>
<head>
	<meta charset="utf-8">
	<title>shortenURL short link generator</title>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;display=swap');
		@import url('https://fonts.googleapis.com/css?family=Varela+Round&amp;display=swap');
		@import url('https://intoyour.space/wp-content/fonts/KosugiMaru/style.css');
	</style>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<script src="./js/script.js"></script>
</head>
<body>
	<form class="urlForm" action="https://ptt.pub/get.php" method="get">
		URL: <input class="urlInput" id="urlInput" size=50 type="text" name="url" value="<?php $url=$_GET['url']; if(!($url == "")) echo $url;?>" />
		<?php if($url == "") : ?>
			<input type="submit" value="Submit" />
		<?php else : ?>
			<button type="button" onclick="copyInput('urlInput')">Copy to clipboard</button>
			<button type="button" onclick="window.location.replace('https://ptt.pub');">Return</button>
		<?php endif ?>
	</form><br>
	Copyright <script>document.write(new Date().getFullYear())</script> <a class="linkTxt" href="https://intoyour.space" target="_blank">potatopotat0</a>. All Rights Reserved.<br>
	<a class="linkImg" href="https://github.com/potatopotat0/shortenURL">
		<img style="transform: translate(0, -3px);" height="24px" src="https://bloghost-1254352323.cos.ap-hongkong.myqcloud.com/ImageUpload/GitHub_Logo.png" /><span style="font-size: 18px;">REPOSITORY</span>
	</a>
</body>
</html>