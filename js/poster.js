$(document).ready(function() {
	var w = $(document).width(),
			h = $(document).height();
	var submitWidth = (h-60) / 3 * 2 + 760;
	var mainInfoContainer = $('#main-info-container');
	$('#main-info-submit').click(function() {
		$('#submit-container').slideDown(1000);
		if (w<submitWidth)
			mainInfoContainer.slideUp(400);
	});

	$('#submit-back-button').click(function() {
		$('#submit-container').slideUp(1000);
		if (w<submitWidth)
			mainInfoContainer.slideDown(1000);
	});

	function setElementSize() {
	// set element width and height
		var containerHeight = h-60;
		var posterH = (containerHeight / 2),
				posterW = (containerHeight / 6 * 2),
				sw = (containerHeight / 3 * 2);
		$('#container').css('height', containerHeight.toString());
	
		$('#submit-poster').css('width', sw.toString());
		$('#submit-container').css('width', (sw + 360).toString());
		$('#submit-origin-poster').width(sw / 8 * 3).height(sw / 16 * 9);
	
		$('.posters').css('height', posterH.toString()).css('width', posterW.toString());
		$('.poster-col').css('width', posterW.toString()).css('height', containerHeight.toString());
	}
	$(window).resize(setElementSize());
});