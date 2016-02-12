
function testAddMarriage() {
	//alert('me');
	$('#id_suami').val('000000004');
	$('#id_istri').val('000000006');
	$('#tanggal_pernikahan').val('2012-09-15');
	$('#note').val('');
}

function resetAddEditMarriageForm() {
	$('#frm_couple').find('button[type=reset]').click();
}

function autoCompleteNama(id,parent_id,max_response,hint){
/*
 * load ajax untuk anime title, englis, alias, atau judul indonesianya
 * variabel : 
   id : object id autocomplete
   max_response : maxsimal jumlah response (pengaruh ke kecepatan load datanya)
   hint : list diload dalam hint object semisal div/layer object
   gender : baca jenis kelamin, L/P, jika l maka load yg p aja dan harus cukup umur (input umur harus benar)
 */
try{
	$tag = $('#'+id).val();
	if (max_response == null) max_response = 50;
	
	if (parent_id == null) {
		$parent = $('body');
	} else {
		$parent = $('#'+parent_id);
	}
							
	$parent.find('#'+id).autocomplete(
		{
        source: function(request,response){
			$jk = (id == 'nama_suami') ? 'L' : 'P' ;
			$.get(site_url+'ajax/individual/personal/',{'term':request.term,'max':max_response,'jk':$jk})
				.success(function(data) { 
					//do some advnced function here
					//printCheckServerError(data);
					var $sdata = data.split(data_spliter);
					var $taglist = checkJSON($sdata[1]);
					if (check_error($sdata[1])){
						addSplashMsg('ERROR');
					}
					else {
						response($taglist);
					}
				})
				.error(function(jqXHR, textStatus) {	
					addSplashMsg(jqXHR);
				});
		},
        select: function(event, ui) {
				var iid = ui.item.id;
				$idObj = (id == 'nama_suami') ? 'id_suami' : 'id_istri' ;
				$('#'+$idObj).val(iid);
		},
        minLength: 2,
		delay : 200
		})
	.data( "ui-autocomplete" )
	._renderItem = function( ul, item ) 
	{
        var inner_html = '<a><div class="list_item_container" style="color:#000000;"><img src="' + item.foto + '" align=left class="img_autocomplete"><span class="display:inline; position:relative;"><span class="">' + item.label + '</span><br><span class="description">' + item.description+ '</span></span></div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul )
	};
}catch(e){console.log(e);}
}

function editMarriage_toggle(cid) {
/* 
 * fungsi untuk tombol edit, agar disa dibatalkan saat form diload juga
 */	
	edit_form = findObj('frm_couple_edit_'+cid);
	$btn = $('#couple_row_'+cid).find('button.btn_edit');
	
	if (edit_form == undefined) { 
		editMarriage(cid);
		//$btn.attr('onclick','');
		$btn.removeClass('btn-default').addClass('btn-info').attr('title','click untuk membatalkan');
	} else {
		$edit_content = $('#couple_row_edit_'+cid);
		$edit_content.remove();
		$btn.addClass('btn-default').removeClass('btn-info').attr('title','click untuk menyunting');
		//$btn.attr('onclick','editIndividual_toggle(this,\''+cid+'\');');
	}
}

function editMarriage(cid,submode) {
/* 
 * fungsi untuk meloan form untuk menunting data individe
 */	
 	submode = (submode == null) ? 'normal' : submode ;
	
	edit_form = findObj('couple_row_edit_'+cid);
	
	if (edit_form == undefined) {
		$('tr#couple_row_'+cid).after('<tr id="couple_row_edit_'+cid+'" class="edit_row"><td colspan=10 class="bc07" id="couple_container_edit_'+cid+'"></td></tr>');
	//adding animation here..
		progress_div('couple_container_edit_'+cid);
	}
	
	$edit_content = $('#couple_row_edit_'+cid);
	
	if (edit_form == undefined) {
	$.post(base_url+"ajax/marriage/sunting/",{couple_id : cid})
		.success(function(data) { 
			//do some advnced function here
			//printCheckServerError(data);
			//alert(data);
			var $sdata = data.split(data_spliter);
			var JSDATA = checkJSON($sdata[1]);
			if (check_error($sdata[1])){
				addSplashMsg(JSDATA.message,'ERROR',null,'bc09');
			}
			else {
				//addSplashMsg(JSDATA.message,'LOADING DATA SUCCESS');
				$edit_content.find('td').html(JSDATA.row);
				addMessage('edit_message_panel_'+cid,JSDATA.message,'bg-primary');
				setFormMarriage(cid);
				autoCompleteNama('nama_suami');
				autoCompleteNama('nama_istri');
			}
		})
		.error(function(jqXHR, textStatus) {	
			addSplashMsg(jqXHR);
		});
	}
}

function setFormMarriage(id) {
/*
 * set form action for : add, update
 */	
 	if (id != null) {
		using_form = 'frm_couple_edit_'+id;
		mode = 'update';
		
		$('#'+using_form).on('reset',(function(e) {
			//$('tr#couple_row_edit_'+id).hide(2222).delay().remove();
			editMarriage_toggle(id);
		}));
	} else {
		using_form = 'frm_couple';
		mode = 'add';
	}
	
	$('#'+using_form).on('submit',(function(e) {
		e.preventDefault();
		//alert(using_form);
		progress_ani_masking(using_form);
		$.ajax({
        	url: base_url+"ajax/marriage/register/"+mode+"/",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false})
			.success(function(data) { 
				//do some advnced function here
				//printCheckServerError(data);
				//alert(data);
				var $sdata = data.split(data_spliter);
				var JSDATA = checkJSON($sdata[1]);
				if (check_error($sdata[1])){
					if (mode == 'add') {
						addSplashMsg(JSDATA.message,'ADDING DATA ERROR',null,'bc09');
						progress_ani_masking_reset('frm_couple');
					} else if (mode == 'update') {
						addSplashMsg(JSDATA.message,'UPDATING DATA ERROR',null,'bc09');
					}
				}
				else {
					if (mode == 'add') {
						addMessage('add_message_panel',JSDATA.message,'bg-primary');
						$('#add_message_panel').show().delay(6000).hide(1000);
						resetAddEditMarriageForm();
						addSplashMsg(JSDATA.message,'ADDING DATA SUCCESS');
						$('tr.couple_row:last').after(JSDATA.row);
						progress_ani_masking_reset('frm_couple');
					} else if (mode == 'update') {
						//refreshing data on table rows here
						//removing tr tags
						$trs = $(JSDATA.row);
						$('tr#couple_row_'+id).html($trs.html());
						addSplashMsg(JSDATA.message,'UPDATING DATA SUCCESS');
						editMarriage_toggle(id);
					}
				}
			})
			.error(function(jqXHR, textStatus) {	
				addSplashMsg(jqXHR);
				progress_ani_masking_reset('frm_couple');
			});
	}));
}

function removeMarriage(cid) {
	//adding animation here
	$.post(base_url+"ajax/marriage/hapus/",{couple_id : cid})
		.success(function(data) { 
			//do some advnced function here
			//printCheckServerError(data);
			var $sdata = data.split(data_spliter);
			var JSDATA = checkJSON($sdata[1]);
			if (check_error($sdata[1])){
				addSplashMsg(JSDATA.message,'ERROR',null,'bc09');
			}
			else {
				//addMessage('couple_row_'+cid,JSDATA.message,'bg-primary');
				addSplashMsg(JSDATA.message,'DELETING DATA SUCCESS');
				$('tr#couple_row_'+cid).html('<td colspan=10 class="bg-success">data telah dihapus !</td>');
				$('tr#couple_row_'+cid).hide(1500);
			}
		})
		.error(function(jqXHR, textStatus) {	
			addSplashMsg(jqXHR);
		});
}

function removeMarriageFilters() {
/*
 * removing active filters
 */
	$('#filter_couple').val('');
	$('#filter_couple_notif').hide();
	$('#filter_couple_notif').find('td span.couple').html('');
	$('#filter_couple_notif').find('td span.result').html(0);
	$('tr.couple_row').each(function (index) {
		$(this).show();
	});
}

function filterMarriage(){
/*
 * find individual by filters
 */
try{
	f_name 		= $('#filter_couple').val();
	t_name 		= $.trim(f_name).replace('_',' ');
	src_name 	= t_name.toLowerCase();
	
	l_name = t_name.length;
	
	text_len 	= parseInt(l_name);
	$result_count = $total_list = 0;

	if (text_len > 0){
		$('tr.edit_row').remove();
		$('button.btn_edit').removeClass('btn-info');

		$('#filter_couple_notif').show();
		$('#filter_couple_notif').find('td span.couple').html(f_name);
		
		$('tr.couple_row').each(function (index) {
										  
			$p_name 	= $.trim($(this).data('couple'));
				
			$getName 	= $p_name.toLowerCase();
			
			c_count = $getName.search(src_name) ;
			
			if (c_count >= 0){
				//$(this).addClass('filter_pass');
				$(this).show();
				$result_count++;
			} else {
				$(this).hide().removeClass('filter_pass');
			}
			$total_list++;
		});
		$('#filter_couple_notif').find('td span.result').html($result_count+'/'+$total_list);
	}
	else{
		removeMarriageFilters();
	}

}catch(e){console.log(e);}
}

$(document).ready(function(){
						filterMarriage();
						testAddMarriage();
						setFormMarriage();
						  autoCompleteNama('nama_suami');
						  autoCompleteNama('nama_istri');
						  });
