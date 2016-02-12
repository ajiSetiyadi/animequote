<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($mode == 'user_detail') {
?>
<div style="min-height:50px; "></div>
  <div class="col-md-12">
	<div class="panel panel-warning">
	<div class="panel-heading"><div class="panel-title"><h2 align="center"><?=$user['fname']." ".$user['lname']?></h2></div></div>
	<div class="panel-body bg-success text-primary"><?=$user['gender']?></div>
	<div class="panel-body"><h4><?=$user['locale']?></h4></div>
	<div class="panel-body" style="text-align:center; "><img src="<?php echo $user['large_picture_url']; ?>"></div>
	<div class="panel-body" style="text-align:center; "></div>
	</div>
</div>
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
