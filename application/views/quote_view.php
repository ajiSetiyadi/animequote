<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($mode == 'quote_header') {
	if (!isset($by_user)) $by_user = "";
?>
<div style="min-height:50px; " id="graph"></div>
 <div class="row">
  <div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading"><p class="panel-title"><h4 class="text-primary"><span class="glyphicon glyphicon-list"></span> Quote List<?=$by_user?></h4></p></div>
<div class="panel-body"></div>
	<table class="table table-striped table-bordered table-condensed" id="tb_indiv"><tr>
	<th id="notif"><h2><span class="	glyphicon glyphicon-tasks"></span></h2></th>
	<th><h2><span class="	glyphicon glyphicon-picture"></span></h2></th>
	<th nowrap>Short Name / Title<br><input type="search" class="form-control" placeholder="ketik title" onKeyUp="filterIndividual();" value="" id="filter_name" name="filter_name"></th>
	<th><h2><span class="	glyphicon glyphicon-user"></span></h2></th>
	<th>Description</th>
	<th>Page Note</th>
	</tr>
	<tr id="filter_notif"><td colspan="10" class="p10 bg-igreen fs15"><span class="glyphicon glyphicon-filter"></span> Filter By, Title : <span class="title fwb"></span>, Description : <span class="description fwb"></span>, Found : <span class="result fwb">0</span>. <span class="fs15 btn btn-default btn-sm bg-success" onClick="removeFilters();"><span class="	glyphicon glyphicon-remove"></span>&nbsp; clear filters</span></td></tr>
<?php 
} else if ($mode == 'quote_content') {
	//print_r($quotes);
	foreach ($quotes as $id=>$quote) { 
		$_qid = $quote['id'];	
?>
        <tr class="quote_row" id="quote_row_<?=$_qid?>" data-quote-id="<?=$_qid?>" data-quote-title="<?=$quote['title'].'/'.$quote['shortname']?>"  data-quote-note="<?php echo $quote['note']; ?>">
        <td nowrap>
<?php if (ISLOGNED) { ?>		
		<div class="btn-group w-action">
 <button type="button" class="btn btn-default btn-sm btn_edit" title="sunting" onClick="editIndividual_toggle('<?=$_qid?>');"> <span class="glyphicon glyphicon-edit"></span>  </button>
   
   <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="menu_<?=$_qid?>" data-toggle="dropdown" title="hapus" onClick="$('div.btn_remove_<?=$_qid?>').show();"> <span class="glyphicon glyphicon-trash"></span> </button> 
        <ul class="dropdown-menu" style="padding:0px; min-width:100px; " role="menu" aria-labelledby="menu_<?=$_qid?>">
          <div class="btn-group-vertical" style="margin:0px; padding:0px; border:0px;">
   			<button type="button" class="btn btn-danger btn-sm" title="hapus" onClick="removeIndividual('<?=$_qid?>');"> <span class="glyphicon glyphicon-ok"></span> Hapus Quote Ini</button>
   			<button type="button" class="btn btn-default btn-sm" title="hapus"> <span class="glyphicon glyphicon-remove"></span> batalkan</button>
		  </div>
        </ul>
	  
   </div>
<?php } ?>
</td>
		<td><a title="view <?php echo $quote['picture_description']; ?>" href="<?php echo site_url('q/'.$_qid); ?>"><img width="180px" src="<?php echo $quote['picture_url']; ?>"><br><?php echo $quote['picture_description']; ?></a></td>
		<td><a title="view link" href="<?php echo site_url('q/'.$quote['shortname']); ?>"><?php echo $quote['shortname']." / ".$quote['title']; ?></a></td>
		<td><?php echo $quote['user_name']; ?></td>
        <td><?php echo $quote['description']; ?></td>
		<td><?php echo $quote['note']; ?></td>
		</tr>

<?php
	}
	print "</table>";
} else if ($mode == 'quote_footer') {
?>

</div>
</div>
</div>
<?php
} else if ($mode == 'quote_view_detail') {
/**
 * DETAIL / SHARE MODE dari quote
 */
?>
<div style="min-height:50px; "></div>
  <div class="col-md-12">
	<div class="panel panel-primary">
	<div class="panel-heading"><div class="panel-title"><h2 align="center"><?=$quote['title']?></h2></div></div>
	<div class="panel-body bg-success text-primary"><?=$quote['description']?><br>
	<button class="btn btn-primary disabled" title="views count">
	<span class="glyphicon glyphicon-eye-open"></span> : <?=$quote['view_count']?></button>&nbsp;
	<button class="btn btn-primary" title="creator / author">
	<span class="glyphicon glyphicon-user"></span> : <?=$quote['user_name']?></button>&nbsp;</div>
	<div class="panel-body"><h4><?=$quote['note']?></h4></div>
	<div class="panel-body" style="text-align:center; "><img src="<?php echo $quote['picture_url']; ?>"></div>
	<div class="panel-body bg-success" style="text-align:center; "><h3><?php echo $quote['picture_description']; ?></h3></div>
	<div class="panel-body" style="text-align:center; "><div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
<div class="fb-comments" data-href="<?=current_url()?>" data-numposts="5"></div>
</div>
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
