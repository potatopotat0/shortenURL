function copyInput(elementID) {
	var copyText = document.getElementById(elementID);
	copyText.select();
	copyText.setSelectionRange(0, 99999);
	document.execCommand("copy");
}
var widgetId;
var onloadCallback = function () {
    widgetId = grecaptcha.render('reCAPTCHA', {
			    'sitekey': '6Ld_9ksaAAAAAN35oC8MjUlatD-1_wEiIEh1G4h1',
			    'theme': 'light',
			    'size': 'normal'
	});
};

function getResponseFromRecaptcha() {
    return grecaptcha.getResponse(widgetId);
};
var url
function onInputHandler(event) {
	url = event.target.value;
}
function onPropertyChangeHandler(event) {
	url = srcElement.value;
}
/*
missing-input-secret	The secret parameter is missing.
invalid-input-secret	The secret parameter is invalid or malformed.
missing-input-response	The response parameter is missing.
invalid-input-response	The response parameter is invalid or malformed.
bad-request				The request is invalid or malformed.
timeout-or-duplicate	The response is no longer valid: either is too old or has been used previously.
*/
function reCAPTCHAVerify() {
	return grecaptcha.getResponse(widgetId).length != 0;
}
function getURL() {
	if(reCAPTCHAVerify()) {
		$.get("https://ptt.pub/api/web/", {url: url, key: grecaptcha.getResponse(widgetId)}, function(result){
			if(result['code'] != 114) {
				alert(result['msg']);
				location.reload();
			} else {
				document.getElementById('urlInput').value = result['url'];
				document.getElementById('urlSubmit').setAttribute("style", "transform: translate(15px, 0);");
				document.getElementById('urlSubmit').setAttribute("onclick", "copyInput(\"urlInput\")");
				document.getElementById('urlSubmit').innerHTML = "<font size=\"4px\" face=\"Varela Round\">Copy to clipboard</font>";
			}
		});
	} else {
		alert("Please finish Google reCAPTCHA first");
	}
}