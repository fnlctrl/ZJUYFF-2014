$(document).ready(function() {
	$('#main-info-submit').click(function() {
		$('#submit-container').slideDown(1000);
		$('#main-info-container').css('z-index', '-1');
	});
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
	$('#submit-origin-poster').width(sw / 8 * 3).height(sw / 16 * 9);

	$('.posters').css('height', posterH.toString()).css('width', posterW.toString());
	$('.poster-col').css('width', posterW.toString()).css('height', h.toString());
};