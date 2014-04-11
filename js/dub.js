$(document).ready(function() {
	var showForm = false;
	$('#main-intro-join').click(function() {
		if (showForm) {
			$('#main-info-container').animate({'opacity':'1'},{duration:500,queue:false});
			$('#main-form-container').animate({'height':'0'},{duration:500,queue:false});
			$('#main-intro-join').text('我要参加');
			showForm = false;
		}
		else{
			$('#main-info-container').animate({'opacity':'0'},{duration:500,queue:false});
			$('#main-form-container').animate({'height':'100%'},{duration:500,queue:false});
			$('#main-intro-join').text('返回');
			showForm = true;
		}
	})
})