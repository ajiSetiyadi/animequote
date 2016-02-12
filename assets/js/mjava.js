/**
 * default java function for site, including animation, etc
 *
 */
 
 function findObj(theObj, theDoc)
{
  var p, i, foundObj;
  
  if(!theDoc) theDoc = document;
  if( (p = theObj.indexOf("?")) > 0 && parent.frames.length)
  {
    theDoc = parent.frames[theObj.substring(p+1)].document;
    theObj = theObj.substring(0,p);
  }
  if(!(foundObj = theDoc[theObj]) && theDoc.all) foundObj = theDoc.all[theObj];
  for (i=0; !foundObj && i < theDoc.forms.length; i++) 
    foundObj = theDoc.forms[i][theObj];
  for(i=0; !foundObj && theDoc.layers && i < theDoc.layers.length; i++) 
    foundObj = findObj(theObj,theDoc.layers[i].document);
  if(!foundObj && document.getElementById) foundObj = document.getElementById(theObj);
  
  return foundObj;
}

 
function check_error(d){
/*
* CHECK the error based on printed tag (defailt=<!--someerrorwasfoundhere-->) in some page (ajax) result
*/
	var ca = d.search(error_tag);
	//alert(ca);
	if (ca >= 0) {return true;} // check if result contain teh text up
	else {return false;}
}
function checkServerError(d){
	var cc = d.search($server_error_tag); //server error and query error, see config.php
	var cd = d.search($query_error_tag);
	//alert(cc+cd);
	if ((cc+cd) >= 0) {	// check if result contain teh text up
		return true;
	} 
	else {return false;}
}

function checkJSON(the_data,m,r) {
/**
 * checking and returning json content
 * the_data = output of the formed data (must be json part, if using separator, split its and select the json data part)
 * m = added message,
 * r = return data, default is false,
 */
try {
	
	ori_data = the_data.replace('</pre>','').replace('<pre style="word-wrap: break-word; white-space: pre-wrap;">','');//removing JSON_PRETTY_PRINTING
	$JSON_data = jQuery.parseJSON(ori_data);
	//alert(ori_data);
	
	if ($JSON_data == null) {
		message = (m == null) ? '' : '<br><span class="fs15 ffc-03 fwb f-sansa">'+m+'</span><br><br>' ;
		//addAAISplash(message+'sorry for incovenient!,<br>please contact our administrator or please try again later in few moment!<br><br><span class="fsi">if your session ended or youre not logned!, please re|login first!</span>','bg-iwhite sb13-2 br01 ffc-00','bc09 lra','Loading / Querying data failed!');
		if (r == null) { return false; }
		else { return null; }
	} else {	
		return $JSON_data;
	}
	//check acces is needed, formly for registered user or admin
		
} catch(e) {console.log(e);}
}

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    //.width(150)
                   // .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

function addMessage(panel_id,msg,cls) {
/*
 * print pesan hasil dari ajax atau validasi form
 */	
 
	cw = cls.search('warn');
	cd = cls.search('danger');
	
	if (cw > 0 || cd > 0) {
 		pre_msg = '<span class="glyphicon glyphicon-remove"></span>&nbsp;';
	} else {
 		pre_msg = '<span class="glyphicon glyphicon-ok"></span>&nbsp;';
	}
	$('#'+panel_id).show().html(pre_msg+msg).removeClass().addClass(cls);
}

$splash_pid = 0;
function addSplashMsg(msg,title,internal_class,external_class){
/*
 * menambahkan pesan spash (tampil sebentar semacam notifikasi), semacam confirm call
 * var :msg,type,pade,prhide,given_id
    - msg 	= pesan
	- type 	= display type, default none
    - pade  = external message add
    - prhide = hide spout
 */
try{
	
	
	if (internal_class == null) { internal_class = 'bg-iwhite sb03'; }
	if (external_class == null) { external_class = 'bc08'; }
	
	if (msg == null) {
		msg = '<span class="fwb f-sansa fs18">Error on Request!</span>,<br> - Request Failed!, Please try again later!';
		internal_class = 'bg-iwhite sb01-2';
		external_class = 'bc09';
	} else {
		if (msg.status != null) {
		//jqXHR variable set as message
		//textStatus+'-'+jqXHR.status+' ('+jqXHR.statusText+') ' + jqXHR.readyState 
			if (msg.status == 404) {
				msg = '<span class="fwb f-sansa fs18">Error Occured!</span>,<br>requested Page Not Available for a moment! <br>Please try again later in few moment!';
			} else if (msg.readyState == 0) {
				msg = '<span class="fwb f-sansa fs18">Error Occured!</span>,<br>Your intenet connection may Offline, <br>Please check your internet connection and try again later!';
			} else {
				msg = '<span class="fwb f-sansa fs18">Error Occured!</span>,<br>'+msg.status+' ('+msg.statusText+')';
			}
			internal_class = 'bg-iwhite sb01-2';
			external_class = 'bc09';
		} else {
			msg = msg
			if (title != null) msg = '<span class="fwb f-sansa fs18">'+title+'</span>,<br>'+msg;
		}
	}
	
	//alert(msg );
	$pid = 'splash_'+$splash_pid;
	
	$dW = $(window).width();
	$dH = $(window).height();
	
	$('body').append('<div id="'+$pid+'" class="splash_message '+external_class+'" style="display:none; min-width:360px; max-width:360px; left:'+($dW/2-180)+'px; top:'+($dH/2-100)+'px;"><div class="p5 ra icon_link valm '+internal_class+'"><span class="fs18 glyphicon glyphicon-exclamation-sign"></span>&nbsp;<span class="din valm">'+msg+'</span></div></div>');

	
	$('#'+$pid).click(function(){$(this).remove();});
	
	$('#'+$pid).show().delay(9000).fadeOut(600,function(){$('#'+$pid).remove();});

	$splash_pid++;
						
} catch(e) {console.log(e);}
}
