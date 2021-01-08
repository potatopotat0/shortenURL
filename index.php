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
	</form>
</body>
</html>