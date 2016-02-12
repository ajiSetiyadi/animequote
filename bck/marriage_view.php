<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($mode == 'list_header') {
?>
<div style="min-height:50px; " id="marriage_list"></div>
	<div class="page_content" id=""><h4 class="text-primary"><span class="glyphicon glyphicon-user"></span> Pernikahan <small>(Gunakan filter untuk menyaring daftar)</small></h4>
	<table class="table table-striped table-bordered table-condensed" id="tb_indiv"><tr>
	<th id="notif">{no relation person} {is valid}</th>
	<th>Suami / Istri<br><input type="search" class="form-control" placeholder="type name" onKeyUp="filterMarriage();" value="" id="filter_couple" name="filter_couple"></th>
	<th>Tanggal Pernikahan <br>
	  / Status Pernikahan </th>
	<th>Anak</th>
	<th>Menantu ()</th></tr>
	<tr id="filter_couple_notif"><td colspan="5" class="p10 bg-igreen fs15"><span class="glyphicon glyphicon-filter"></span> Filter By, Suami/Istri : <span class="couple fwb"></span>, Found : <span class="result fwb">0</span>. <span class="fs15 btn btn-default btn-sm bg-success" onClick="removeMarriageFilters();"><span class="glyphicon glyphicon-remove"></span>&nbsp; clear filters</span></td></tr>
<?php 
} else if ($mode == 'list_content') {
	foreach ($couples as $couple): 	
		$_cid = $couple['id'];
?>

        <tr class="couple_row" id="couple_row_<?=$_cid?>" data-couple-id="<?=$_cid?>" data-couple="<?php echo $couple['nama_suami']."/".$couple['nama_istri'];?>">
        <td nowrap>
		<div class="btn-group w-action">
 <button type="button" class="btn btn-default btn-sm"> <span class="glyphicon glyphicon-star-empty" title="start line from this couple"></span>  </button>
		<button type="button" class="btn btn-default btn-sm" title="detil"> <a href="<?php echo site_url('marriage/detail/'.$_cid); ?>"> <span class="glyphicon glyphicon-arrow-right"></span>  </a></button>
 <button type="button" class="btn btn-default btn-sm btn_edit" title="sunting" onClick="editMarriage_toggle('<?=$_cid?>');"> <span class="glyphicon glyphicon-edit"></span>  </button>
   
   <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="menu_<?=$_cid?>" data-toggle="dropdown" title="hapus" onClick="$('div.btn_remove_<?=$_cid?>').show();"> <span class="glyphicon glyphicon-trash"></span> </button> 
        <ul class="dropdown-menu" style="padding:0px; min-width:100px; " role="menu" aria-labelledby="menu_<?=$_cid?>">
          <div class="btn-group-vertical" style="margin:0px; padding:0px; border:0px;">
   			<button type="button" class="btn btn-danger btn-sm" title="hapus" onClick="removeMarriage('<?=$_cid?>');"> <span class="glyphicon glyphicon-ok"></span> hapus data pernikahan</button>
   			<button type="button" class="btn btn-default btn-sm" title="hapus"> <span class="glyphicon glyphicon-remove"></span> batalkan</button>
		  </div>
        </ul>	  
   </div>
</td>
		<td><?php echo ucwords($couple['suami_istri']); ?></td>
		<td><?php echo $couple['tanggal_pernikahan']."/".$couple['status_pernikahan'];?></td>
		<td><?php echo $couple['anak']; ?></td>
		<td><?php echo $couple['menantu']; ?></td>
		</tr>

<?php 
	endforeach; 
} else if ($mode == 'list_footer') {
?>
</table></div>
<?=$add_form?>
<?php
} else if ($mode == 'detail') {
?>
		<td><?php echo ucwords($couple['nama']); ?></td>
        <td><?php echo $couple['tempat_lahir']; ?></td>
		<td><?php echo $couple['tanggal_lahir']; ?></td>
		<td><?php echo $couple['tempat_tinggal']; ?></td>
		<td><?php echo $couple['phone']." / ".$couple['net_kontak']; ?></td>
<?php
} else if ($mode == 'add_edit') {
$submode = (!isset($submode)) ? "" : $submode ;
	if ($submode == 'edit') {
		$_cid = $couple['id'];
		$nama_pasangan = $couple['nama_suami']."/".$couple['nama_istri'];
		$submit_label 	= "Update";
		$reset_label 	= "Batalkan Edit";
?>
<div class="page_content bg-iwhite75">
<form role="form" class="couple_form" id="frm_couple_edit_<?=$_cid?>">
<h4><span class="glyphicon glyphicon-edit"></span> Edit Pernikahan (<?=ucwords($nama_pasangan);?>)</h4>
<div id="edit_message_panel_<?=$_cid?>" style="margin-bottom:10px; padding:5px; display:none; ">pesan edit data</div>
<?php	
	} else {
		$couple = array(
			'id'=> 0,					'id_suami' => '',			'id_istri' => '',
			'nama_suami' => '', 		'nama_istri' => '',
			'tanggal_pernikahan' => '',	
			'status_pernikahan' => 'bersama',	
			'note' => '',
		);
		$_cid = $couple['id'];
		$submit_label 	= "Tambahkan";
		$reset_label 	= "Reset";
?>
<div style="min-height:50px; " id="individual_add"></div>
<div class="page_content">
<form role="form" class="couple_form" id="frm_couple">
<h4><span class="glyphicon glyphicon-plus-sign"></span> Tambahkan pernikahan {sub mode penambahan}</h4>
<div id="add_message_panel" style="margin-bottom:10px; padding:5px; display:none; ">pesan penambahan data</div>
<?php		
	}
?>
<table class="table table-striped table-condensed">
<colgroup>
    <col nowrap>
    <col  width="80%">
  </colgroup>
  	<tr>
	<td>Suami / Istri </td>
	<td><input type="" id="couple_id" name="couple_id" value="<?=$couple['id']?>"><input type="" id="id_suami" name="id_suami" value="<?=$couple['id_suami']?>"><input type="" id="id_istri" name="id_istri" value="<?=$couple['id_istri']?>"><div class="w-50p"><input type="text" class="form-control" id="nama_suami" name="nama_suami" placeholder="nama suami" size="30" value="<?=$couple['nama_suami']?>" data-main="13"></div><div class="w-50p"><input type="text" class="form-control" id="nama_istri" name="nama_istri" placeholder="nama istri" size="30" value="<?=$couple['nama_istri']?>"></div></td>
	</tr>
	<tr>
	<td class="text-nowrap">Tanggal Pernikahan </td>
	<td><div class="w-25p"><input type="date" class="form-control" id="tanggal_pernikahan" name="tanggal_pernikahan" value="<?=$couple['tanggal_pernikahan']?>"></div></td>
	</tr>
	<tr>
	  <td>Status Pernikahan </td>
	  <td><div class="w-25p"><select class="form-control" id="status_pernikahan" name="status_pernikahan"><option <?=($couple['status_pernikahan'] == 'bersama') ? 'selected' : '';?>>bersama</option><option <?=($couple['status_pernikahan'] == 'berpisah') ? 'selected' : '';?>>berpisah</option></select></div></td></tr>
	<tr>
	  <td>Catatan</td>
	  <td><div class="w-100p"><textarea class="form-control" rows="2" id="note" name="note" placeholder="catatan"><?=$couple['note']?></textarea></div></td></tr>
	<tr><td></td><td><button type="submit" class="btn btn-warning"><?=$submit_label?></button>&nbsp;<button type="reset" class="btn btn-info"><?=$reset_label?></button></td></tr>
</table>	
</form>
</div>
<?php
}
?>
