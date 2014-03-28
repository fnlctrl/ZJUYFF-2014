$(document).ready(function() {
	setElementSize();
});
$(window).bind('load resize', setElementSize());
function setElementSize() {
// set element width and height
	var h = $(document).height()-60;
	var posterH = (h / 2),
			posterW = (h / 6 * 2),
			sw = (h / 3 * 2);
	$('#container').css('height', h.toString());

	$('#submit-poster').css('width', sw.toString());
	$('#submit-container').css('width', (sw + 360).toString());

	$('.posters').css('height', posterH.toString());
	$('.posters').css('width', posterW.toString());
	$('.poster-col').css('width', posterW.toString());
	$('.poster-col').css('height', h.toString());
};