$(document).ready(function() {
	// set #container height property
	{
		var h = $(document).height()-60;
		var ph = h.toString();
		$('#container').css('height', ph);
		$('#main-info').css('height', ph);
	};
});