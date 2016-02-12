
function testAddPeople() {
	//alert('me');
	$('#nama').val('dinda rama saputri');
	$('#jenis_kelamin').val('P');
	$('#tempat_lahir').val('bantul');
	$('#tanggal_lahir').val('2001-12-09');
	$('#tempat_tinggal').val('karang ploso, siti mulyo, piyungan, bantul, yogyakarta');
	$('#phone').val('');
}

function resetAddEditForm() {
	$('#frm_people').find('button[type=reset]').click();
}

function autoCompleteParent(id,parent_id,max_response,hint){
/*
 * load ajax untuk anime title, englis, alias, atau judul indonesianya
 * variabel : 
   id : object id autocomplete
   max_response : maxsimal jumlah response (pengaruh ke kecepatan load datanya)
   hint : list diload dalam hint object semisal div/layer object
 */
try{
	//$tag = $('#'+id).val();
	if (max_response == null) max_response = 50;
	if (parent_id == null) {
		$parent = $('body');
	} else {
		$parent = $('#'+parent_id);
	}
							
	$parent.find('#'+id).autocomplete(
		{
        source: function(request,response){
			$.get(site_url+'ajax/marriage/pernikahan/',{'term':request.term,'max':max_response})
				.success(function(data) { 
					//do some advnced function here
					//printCheckServerError(data);
					var $sdata = data.split(data_spliter);
					var $taglist = checkJSON($sdata[1]);
					if (check_error($sdata[1])){
						alert ('server error','e');
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
				//alert(iid);
				//$('form#'+parent_id).find('input.id_pernikahan').val(iid);
				//$parent.find('input#id_pernikahan').val(iid);
				$('#id_pernikahan').val(iid);
		},
        minLength: 2,
		delay : 200
		})
	.data( "ui-autocomplete" )
	._renderItem = function( ul, item ) 
	{
        var inner_html = '<a><div class="list_item_container" style="color:#000000;"><img src="' + item.foto_suami + '" align=left class="img_autocomplete"><img src="' + item.foto_istri + '" align=left class="img_autocomplete"><span class="display:inline; position:relative;"><span class="">' + item.label + '</span><br><span class="description">' + item.description+ '</span></span></div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul )
	};
}catch(e){console.log(e);}
}

function autoCompleteCouple(id,parent_id,max_response,hint){
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
			$jk = $('#jenis_kelamin').val();
			$.get(site_url+'ajax/marriage/pasangan/',{'term':request.term,'max':max_response,'jk':$jk})
				.success(function(data) { 
					//do some advnced function here
					//printCheckServerError(data);
					var $sdata = data.split(data_spliter);
					var $taglist = checkJSON($sdata[1]);
					if (check_error($sdata[1])){
						alert ('server error','e');
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
				//$(this).parent('td').find('input#id_pasangan').val(iid);
				//$parent.find('input#id_pasangan').val(iid);
				$('#id_pasangan').val(iid);
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

function editIndividual_toggle(pid) {
/* 
 * fungsi untuk tombol edit, agar disa dibatalkan saat form diload juga
 */	
	edit_form = findObj('frm_people_edit_'+pid);
	$btn = $('#people_row_'+pid).find('button.btn_edit');
	
	if (edit_form == undefined) { 
		editIndividual(pid);
		//$btn.attr('onclick','');
		$btn.removeClass('btn-default').addClass('btn-info').attr('title','click untuk membatalkan');
	} else {
		$edit_content = $('#people_row_edit_'+pid);
		$edit_content.remove();
		$btn.addClass('btn-default').removeClass('btn-info').attr('title','click untuk menyunting');
		//$btn.attr('onclick','editIndividual_toggle(this,\''+pid+'\');');
	}
}

function editIndividual(pid,submode) {
/* 
 * fungsi untuk meloan form untuk menunting data individe
 */	
 	submode = (submode == null) ? 'normal' : submode ;
	
	edit_form = findObj('people_row_edit_'+pid);
	
	if (edit_form == undefined) {
		$('tr#people_row_'+pid).after('<tr id="people_row_edit_'+pid+'" class="edit_row"><td colspan=10 class="bc07"></td></tr>');
	//adding animation here..
	}
	
	$edit_content = $('#people_row_edit_'+pid);
	
	if (edit_form == undefined) {
	$.post(base_url+"ajax/individual/sunting/",{people_id : pid})
		.success(function(data) { 
			//do some advnced function here
			//printCheckServerError(data);
			var $sdata = data.split(data_spliter);
			var JSDATA = checkJSON($sdata[1]);
			if (check_error($sdata[1])){
				addSplashMsg(JSDATA.message,'ERROR',null,'bc09');
			}
			else {
				//addSplashMsg(JSDATA.message,'LOADING DATA SUCCESS');
				$edit_content.find('td').html(JSDATA.row);
				addMessage('edit_message_panel_'+pid,JSDATA.message,'bg-primary');
				setForm(pid);
				autoCompleteParent('label_pernikahan','frm_people_edit_'+pid);
				autoCompleteCouple('nama_pasangan','frm_people_edit_'+pid);
			}
		})
		.error(function(jqXHR, textStatus) {	
			addSplashMsg(jqXHR);
		});
	}
}

function setForm(id) {
/*
 * set form action for : add, update
 */	
 	if (id != null) {
		form_id = '#frm_people_edit_'+id;
		mode = 'update';
		
		$(form_id).on('reset',(function(e) {
			//$('tr#people_row_edit_'+id).hide(2222).delay().remove();
			editIndividual_toggle(id);
		}));
	} else {
		form_id = '#frm_people';
		mode = 'add';
	}
	
	$(form_id).on('submit',(function(e) {
		e.preventDefault();
		//adding aniamtion here
		//alert(mode);
		$.ajax({
        	url: base_url+"ajax/individual/register/"+mode+"/",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false})
			.success(function(data) { 
				//do some advnced function here
				//printCheckServerError(data);
				var $sdata = data.split(data_spliter);
				var JSDATA = checkJSON($sdata[1]);
				if (check_error($sdata[1])){
					if (mode == 'add') {
						addSplashMsg(JSDATA.message,'ADDING DATA ERROR',null,'bc09');
					} else if (mode == 'update') {
						addSplashMsg(JSDATA.message,'UPDATING DATA ERROR',null,'bc09');
					}
				}
				else {
					if (mode == 'add') {
						addMessage('add_message_panel',JSDATA.message,'bg-primary');
						$('#add_message_panel').show().delay(6000).hide(1000);
						resetAddEditForm();
						//setForm();
						addSplashMsg(JSDATA.message,'ADDING DATA SUCCESS');
						$('tr.people_row:last').after(JSDATA.row);
					} else if (mode == 'update') {
						//refreshing data on table rows here
						//removing tr tags
						$trs = $(JSDATA.row);
						$('tr#people_row_'+id).html($trs.html());
						addSplashMsg(JSDATA.message,'UPDATING DATA SUCCESS');
						editIndividual_toggle(id);
					}
				}
			})
			.error(function(jqXHR, textStatus) {	
				addSplashMsg(jqXHR);
			});
	}));
}

function removeIndividual(p_id) {
	//adding animation here
	$.post(base_url+"ajax/individual/hapus/",{people_id : p_id})
		.success(function(data) { 
			//do some advnced function here
			//printCheckServerError(data);
			var $sdata = data.split(data_spliter);
			var JSDATA = checkJSON($sdata[1]);
			if (check_error($sdata[1])){
				addSplashMsg(JSDATA.message,'ERROR',null,'bc09');
			}
			else {
				//addMessage('people_row_'+p_id,JSDATA.message,'bg-primary');
				addSplashMsg(JSDATA.message,'DELETING DATA SUCCESS');
				$('tr#people_row_'+p_id).html('<td colspan=10 class="bg-success">data telah dihapus !</td>');
				$('tr#people_row_'+p_id).hide(1500);
			}
		})
		.error(function(jqXHR, textStatus) {	
			addSplashMsg(jqXHR);
		});
}

function removeFilters() {
/*
 * removing active filters
 */
	$('#filter_name').val('');
	$('#filter_parent').val('');
	$('#filter_address').val('');
	$('#filter_notif').hide();
	$('#filter_notif').find('td span.nama').html('');
	$('#filter_notif').find('td span.ortu').html('');
	$('#filter_notif').find('td span.alamat').html('');
	$('#filter_notif').find('td span.result').html(0);
	$('tr.people_row').each(function (index) {
		$(this).show();
	});
}

function filterIndividual(){
/*
 * find individual by filters
 */
try{
	f_name 		= $('#filter_name').val();
	t_name 		= $.trim(f_name).replace('_',' ');
	src_name 	= t_name.toLowerCase();
	
	f_parent 	= $('#filter_parent').val();
	t_parent 	= $.trim(f_parent).replace('_',' ');
	src_parent 	= t_parent.toLowerCase();
	
	f_address 	= $('#filter_address').val();
	t_address 	= $.trim(f_address).replace('_',' ');
	src_address = t_address.toLowerCase();
	
	l_name 		= src_name.length;
	l_parent 	= src_parent.length;
	l_address 	= src_address.length;
	
	text_len 	= parseInt(l_name+l_parent+l_address);
	$result_count = $total_list = 0;

	if (text_len > 0){
		$('#filter_notif').show();
		$('tr.edit_row').remove();
		$('button.btn_edit').removeClass('btn-info');
		$('#filter_notif').find('td span.nama').html(f_name);
		$('#filter_notif').find('td span.ortu').html(f_parent);
		$('#filter_notif').find('td span.alamat').html(f_address);
		
		$('tr.people_row').each(function (index) {
										  
			$p_name 	= $.trim($(this).data('people-name'));
			$p_parent 	= $.trim($(this).data('people-parent'));
			$p_address 	= $.trim($(this).data('people-address'));
				
			$getName 	= $p_name.toLowerCase();
			$getParent 	= $p_parent.toLowerCase();
			$getAddress = $p_address.toLowerCase();
			
			c_name 		= $getName.search(src_name);
			c_parent 	= $getParent.search(src_parent);
			c_address 	= $getAddress.search(src_address);
			
			if (l_name > 0  && l_parent > 0 && l_address > 0) {
				//c_count = parseInt($getName.search(src_name) + $getParent.search(src_parent) + $getAddress.search(src_address)) ;
				c_count = (c_name >= 0 && c_parent >= 0 && c_address >= 0) ? true : false ;
			} else if (l_name > 0  && l_parent > 0) {
				c_count = (c_name >= 0 && c_parent >= 0) ? true : false ;
			} else if (l_name > 0  && l_address > 0) {
				c_count = (c_name >= 0 && c_address >= 0) ? true : false ;
			} else if (l_address > 0  && l_parent > 0) {
				c_count = (c_parent >= 0 && c_address >= 0) ? true : false ;
			} else if (l_name > 0) {
				c_count = (c_name >= 0) ? true : false ;
			} else if (l_parent > 0) {
				c_count = (c_parent >= 0) ? true : false ;
			} else if (l_address > 0) {
				c_count = (c_address >= 0) ? true : false ;
			}
			
			if (c_count == true){
				//$(this).addClass('filter_pass');
				$(this).show();
				$result_count++;
			} else {
				$(this).hide().removeClass('filter_pass');
			}
			$total_list++;
		});
		$('#filter_notif').find('td span.result').html($result_count+'/'+$total_list);//c_name+c_parent+c_address+c_count+'/'+
	}
	else{
		removeFilters();
	}

}catch(e){console.log(e);}
}


$(document).ready(function(){
						  testAddPeople();
						  autoCompleteParent('label_pernikahan');
						  autoCompleteCouple('nama_pasangan');
						  setForm();
						  filterIndividual();
						  });