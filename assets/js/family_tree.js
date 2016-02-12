
function personalInfoTrigger() {
/**
 * give personal info div showed/hidded
 */
	$cb = findObj('people_info');
	if ($cb.checked) {
		$('.person_info').hide();	
		$('#people_info_trigger').removeClass('btn-primary').find('span.glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
		$cb.checked = false;
	} else {
		$('.person_info').show();	
		$('#people_info_trigger').addClass('btn-primary').find('span.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
		$cb.checked = true;
	}
}

function personalOptionTrigger() {
/**
 * give personal info div showed/hidded
 */
	$cbo = findObj('people_option');
	if ($cbo.checked) {
		$('.person_option').hide();	
		$('#people_option_trigger').removeClass('btn-primary').find('span.glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
		$cbo.checked = false;
	} else {
		$('.person_option').show();	
		$('#people_option_trigger').addClass('btn-primary').find('span.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
		$cbo.checked = true;
	}
}

$(document).ready(function() {
	findObj('people_info').checked = false;
	personalInfoTrigger();
	$('.person_info').addClass('bg-iwhite pt-5 sb13');	
	
	findObj('people_option').checked = false;
	personalOptionTrigger();
});
