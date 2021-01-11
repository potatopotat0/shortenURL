<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>shortenURL short link generator</title>
	<script type="text/javascript">
		function copyInput(elementID) {
			var copyText = document.getElementById(elementID);
			copyText.select();
			copyText.setSelectionRange(0, 99999);
			document.execCommand("copy");
		}
	</script>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;display=swap');
		@import url('https://fonts.googleapis.com/css?family=Varela+Round&amp;display=swap');
		@import url('https://intoyour.space/wp-content/fonts/KosugiMaru/style.css');
		body {
			font-family: 'Varela Round','Kosugi Maru','Noto Sans SC', 'SF Pro Text', 'Arial', 'PingFangSC', 'Microsoft Yahei', 'Microsoft Jhenghei', sans-serif;
		}
		a {color: black; text-decoration: none;}
		a:link {color: black; text-decoration: none;}
		a:visited {color: black; text-decoration: none;}
		a:hover		{color: black; text-decoration: none;}
		a:active {color: black; text-decoration: none;}
		a.linkTxt:hover {color: rgba(135, 135, 135, .75) !important;}
		a.linkImg {opacity: 1;}
		a.linkImg:hover {opacity: .65;}
	</style>
</head>
<body>
	<form action = "https://ptt.pub/get.php" method = "get">
		URL: <input id = "urlInput" size = 50 type = "text" name = "url" value = "<?php $url = $_GET['url']; if(!($url == "")) echo $url;?>" />
		<?php if($url == "") : ?>
			<input type = "submit" value = "Submit" />
		<?php else : ?>
			<button type="button" onclick="copyInput('urlInput')">Copy to clipboard</button>
			<button type="button" onclick="window.location.replace('https://ptt.pub');">Return</button>
		<?php endif ?>
	</form><br>
	© <a class = "linkTxt" href = "https://github.com/potatopotat0">potatopotat0</a>, Released under the <a class = "linkTxt" href = "https://github.com/potatopotat0/shortenURL/blob/main/LICENSE">MIT License</a>.<br>
	<a class = "linkImg" href = "https://github.com/potatopotat0/shortenURL">
		<img style = "transform: translate(0, 4px);" height = "24px" src = "https://bloghost-1254352323.cos.ap-hongkong.myqcloud.com/ImageUpload/GitHub_Logo.png" /><span style = "font-size: 20px;">REPOSITORY</span>
	</a>
</body>
</html>