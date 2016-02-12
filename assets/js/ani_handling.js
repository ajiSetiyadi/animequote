/*
ANIMATION HANDLING FUNCTION
progress_div(d,size) -> set the content of the div/object element (innerHTML)
progress_src(d,size) -> set the src attribute of object/image
progress_src_reset(d) -> reset the src attribute of object/image
progress_bg(d,size) -> set the bg of thr div/object element
progress_bg_reset(d) -> resetign the default bg of the object (need reconsidered)
check_tonggle_image(id,checked_img,inchecked_img) -> 
*/
function progress_div(d,size,returned,c_class){
	var aniimg; // animation img
	if (size==16)		aniimg = 'pbani_16.gif';
	else if (size==24)	aniimg = 'pbani_24.gif';
	else if (size==32)	aniimg = 'pbani_32.gif';
	else 				aniimg = '29-1.gif';
	
	ani_img = base_url+'assets/images/loading/'+aniimg;
	
	if (c_class == null) c_class = 'h-100percent';
	
	if(returned == true)
		return "<div class=\"text-center box-ami "+c_class+"\"><img src=\""+ani_img+"\"></div>";
	else
		$('#'+d).html("<div class=\"text-center box-ami "+c_class+"\"><img src=\""+ani_img+"\"></div>");
}

function progress_ani_append(d,size,cclass){
	var aniimg; // animation img
	if (size==16)aniimg = 'images/icon/pbani_16.gif';
	else if (size==24)aniimg = 'images/icon/pbani_24.gif';
	else if (size==32)aniimg = 'images/icon/pbani_32.gif';
	else aniimg = $template_dir+'image/29-1.gif';
	
	if(cclass == null) cclass = "brff sb ra m1 ms-5 p2";
	
	//alert(d.substr(0,1));
	/*
	if(d.id != '')
		d.html("<div class=\"alc box-ami h-100percent\"><img src=\""+$COVER+aniimg+"\"></div>");
	else*/
	$insideani = $('#'+d).find('span.progress_div_append_animation').html();
	if($insideani == null){
		$('#'+d).append("<span class=\""+cclass+" ps-5 valm progress_div_append_animation\"><img src=\""+$COVER+aniimg+"\"></span>");
	}
}

function progress_ani_append_reset(d){
	$('#'+d).find('span.progress_div_append_animation').remove();
}

function progress_ani_masking(container,size,cclass){
	var aniimg; // animation img
	if (size==16)		aniimg = 'pbani_16.gif';
	else if (size==24)	aniimg = 'pbani_24.gif';
	else if (size==32)	aniimg = 'pbani_32.gif';
	else 				aniimg = '29-1.gif';
	
	//alert(container);
	
	ani_img = base_url+'assets/images/loading/'+aniimg;
	
	if(cclass == null) cclass = "bg-igrey";
	
	$('#'+container).addClass('pos-rel');
	
	$dh = $('#'+container).innerHeight();
	$dw = $('#'+container).innerWidth();
	
	$insideani = $('#'+container).find('div.progress_div_append_animation').html();
	
	if($insideani == null){
		//inserted div with nopadding or margin, copy the parent dimension
		$('#'+container).prepend("<div style=\"position:absolute; top:0px; left:0px;\" class=\"progress_div_append_animation text-center\"><span class=\""+cclass+" din pp-5\" style=\"display:inline-block; height:"+$dh+"px; width:"+$dw+"px;\"><img src=\""+ani_img+"\" class='m5'></span></div>");
		//alert($('#'+container).html());
	}
}

function progress_ani_masking_reset(container){
	$('#'+container).find('div.progress_div_append_animation').remove();
}

function progress_src(d,size){
	if (size==16)
		$('#'+d).attr('src',$COVER+'images/icon/pbani_16.gif');
	else if (size==24)
		$('#'+d).attr('src',$COVER+'images/icon/pbani_24.gif');
	else if (size==32)
		$('#'+d).attr('src',$COVER+'images/icon/pbani_32.gif');
		
	//set empty onclick event and title content
	$('#'+d).attr('title','');
	$('#'+d).attr('onClick','');
	findObj(d).disabled = true;
}

function progress_src_reset(d){
	if(findObj(d))
		findObj(d).disabled = false;
}

function progress_bg(d,size){
	if (size==16)
		$('#'+d).css('background-image','url('+$COVER+'images/icon/pbani_16.gif)');
	else if (size==24)
		$('#'+d).css('background-image','url('+$COVER+'images/icon/pbani_24.gif)');
	else if (size==32)
		$('#'+d).css('background-image','url('+$COVER+'images/icon/pbani_32.gif)');
	else
		$('#'+d).css('background-image','url('+$template_dir+'image/29-1.gif)');
	
	$('#'+d).css('background-position','center');
	$('#'+d).css('background-repeat','no-repeat');
	
	//disabling form component
	if(findObj(d))
		findObj(d).disabled = true;
}

function progress_bg_reset(d){
	$('#'+d).css('background-image','');
	$('#'+d).css('background-repeat','repeat');
	if(findObj(d))
		findObj(d).disabled = false;
}

/*
there trigger checkbox with image tonggle click -> the name must be img_(id) and checkbox_(id) to their name both
usedn on :
- tpL_build_progress_function.php
*/
function check_tonggle_image(id,checked_img,inchecked_img){
	try{
	var $img = $('#img_'+id);
	var pic = $img.attr('src');
	var $cb = findObj('checkbox_'+id); // cannot use JQUERY, has no method..
	
	if (pic == checked_img){
		$img.attr('src',inchecked_img);
		$cb.checked = false;
	}
	else{
		$img.attr('src',checked_img);
		$cb.checked = true;
	}
	
	}catch(e){console.log(e);}
}

