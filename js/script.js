function copyInput(elementID) {
	var copyText = document.getElementById(elementID);
	copyText.select();
	copyText.setSelectionRange(0, 99999);
	document.execCommand("copy");
}