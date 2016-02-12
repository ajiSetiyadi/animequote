<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($mode == 'list_header') {
?>
<div style="min-height:50px; " id="individual_list"></div>
	<div class="page_content" id=""><h4 class="text-primary"><span class="glyphicon glyphicon-user"></span> Anggota Keluarga <small>(Gunakan filter untuk menyaring daftar)</small></h4>
	<table class="table table-striped table-bordered table-condensed" id="tb_indiv"><tr>
	<th id="notif">{no relation person} {is valid}</th>
	<th>Foto</th>
	<th>Nama<br><input type="search" class="form-control" placeholder="ketik name" onKeyUp="filterIndividual();" value="" id="filter_name" name="filter_name"></th>
	<th>JK</th>
	<th>Tempat Lahir</th>
	<th>Tgl.Lahir</th>
	<th>Anak Dari Ayah/Ibu<br><input type="search" class="form-control" placeholder="ketik nama orang tua" onKeyUp="filterIndividual();" value="" id="filter_parent" name="filter_parent"></th>
	<th>Istri/Suami</th>
	<th>Alamat<br><input type="search" class="form-control" placeholder="ketik alamat" onKeyUp="filterIndividual();" value="" id="filter_address" name="filter_address"></th>
	<th>Kontak</th></tr>
	<tr id="filter_notif"><td colspan="10" class="p10 bg-igreen fs15"><span class="glyphicon glyphicon-filter"></span> Filter By, Nama : <span class="nama fwb"></span>, Orang Tua : <span class="ortu fwb"></span>, Alamat : <span class="alamat fwb"></span>, Found : <span class="result fwb">0</span>. <span class="fs15 btn btn-default btn-sm bg-success" onClick="removeFilters();"><span class="	glyphicon glyphicon-remove"></span>&nbsp; clear filters</span></td></tr>
<?php 
} else if ($mode == 'list_content') {
foreach ($peoples as $people): 
	$_pid = $people['id'];
	$btn_add_ortu = '<button type="button" class="btn btn-default btn-sm" title="tambahkan orang tua" onClick="editIndividual_toggle(\''.$_pid.'\');"><span class="glyphicon glyphicon-plus-sign"></span></button>';
	if (!empty($people['alias'])) $people['alias'] = "<br><small class='text-primary'>".ucwords($people['alias'])."</small>";
	$people['ortu'] = (!empty($people['id_pernikahan'])) ? $people['ayah']."/".$people['ibu'] : $btn_add_ortu ;
	
?>

        <tr class="people_row" id="people_row_<?=$_pid?>" data-people-id="<?=$_pid?>" data-people-name="<?=$people['nama'].'/'.$people['alias']?>" data-people-parent="<?php echo $people['ayah'].$people['ibu'];?>" data-people-address="<?php echo $people['tempat_tinggal']; ?>">
        <td nowrap>
		<div class="btn-group w-action">
 <button type="button" class="btn btn-default btn-sm"><a href="<?=site_url('descendant/').'/'.$people['id'];?>#graph"><span class="glyphicon glyphicon-star-empty" title="start line from this people"></span></a></button>
		<button type="button" class="btn btn-default btn-sm" title="detil"> <a href="<?php echo site_url('individual/'.$_pid); ?>"> <span class="glyphicon glyphicon-arrow-right"></span>  </a></button>
 <button type="button" class="btn btn-default btn-sm btn_edit" title="sunting" onClick="editIndividual_toggle('<?=$_pid?>');"> <span class="glyphicon glyphicon-edit"></span>  </button>
   
   <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="menu_<?=$_pid?>" data-toggle="dropdown" title="hapus" onClick="$('div.btn_remove_<?=$_pid?>').show();"> <span class="glyphicon glyphicon-trash"></span> </button> 
        <ul class="dropdown-menu" style="padding:0px; min-width:100px; " role="menu" aria-labelledby="menu_<?=$_pid?>">
          <div class="btn-group-vertical" style="margin:0px; padding:0px; border:0px;">
   			<button type="button" class="btn btn-danger btn-sm" title="hapus" onClick="removeIndividual('<?=$_pid?>');"> <span class="glyphicon glyphicon-ok"></span> hapus data individu</button>
   			<button type="button" class="btn btn-default btn-sm" title="hapus"> <span class="glyphicon glyphicon-remove"></span> batalkan</button>
		  </div>
        </ul>
   
  <!--
 <button class="btn btn-default  btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Tutorials</button>   <div class="btn_remove_<?=$_pid?>" style="display:none; position:absolute; left:120px;" title="hapus" onClick="removeIndividual('<?=$_pid?>');"> 
        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
          <button class="btn btn-default  btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Tutorials</button>   <div class="btn_remove_<?=$_pid?>" style="display:none; position:absolute; left:120px;" title="hapus" onClick="removeIndividual('<?=$_pid?>');"></button>
          <li role="presentation" class="divider"></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">About Us</a></li>
        </ul>
   		<div class="btn-group-vertical">
   			<button type="button" class="btn btn-warning btn-sm" title="hapus" onClick="$(this).find('span.btn_remove').show();"> <span class="glyphicon glyphicon-trash"></span> hapus individu</button>
   			<button type="button" class="btn btn-default btn-sm" title="hapus" onClick="$(this).find('span.btn_remove').show();"> <span class="glyphicon glyphicon-trash"></span> batalkan</button>
		</div>  
	</div> --> 
	  
   </div>
</td>
		<td><a href="<?php echo site_url('individual/detail/'.$_pid); ?>"><img height="50px" src="<?php echo $people['photo']; ?>"></a></td>
		<td><?php echo ucwords($people['nama']).ucwords($people['alias']); ?></td>
        <td><?php echo $people['jenis_kelamin']; ?></td>
        <td><?php echo $people['tempat_lahir']; ?></td>
		<td><?php echo $people['tanggal_lahir']; ?></td>
		<td><?php echo $people['ortu'];?></td>
		<td><?php echo $people['nama_pasangan']; ?></td>
		<!--<td><button type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-plus-sign"></span>
        </button></td>-->
		<td><?php echo $people['tempat_tinggal']; ?></td>
		<td><?php echo $people['phone']." / ".$people['kontak_lain']; ?></td>
		</tr>

<?php endforeach; 
} else if ($mode == 'list_footer') {
?>
</table></div>
<?=$add_form?>
<?php
} else if ($mode == 'detail') {
?>
	?>
<div style="min-height:50px; " id="individual_list"></div>
	<div class="page_content" id=""><h4 class="text-primary"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo ucwords($people['nama']); ?></h4>
<table class="table table-striped table-condensed">
<colgroup>
    <col nowrap>
    <col nowrap>
    <col nowrap>
    <col  width="70%">
  </colgroup>
	<tr><td rowspan="7" class="text-center"><img style="margin:1px; " src="<?php echo $people['foto']; ?>"><br><?php echo $people['id']; ?></td><td>Nama / Alias</td><td>:</td><td><?php echo ucwords($people['nama_alias']); ?></td></tr>
    <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td><?php echo ucfirst($people['tempat_lahir']); ?>, <?php echo $people['tanggal_lahir']; ?>&nbsp;(<?php echo $people['umur']; ?>)</td></tr>
	<tr><td>Jenis Kelamin</td><td>:</td><td><?php echo ucfirst(($people['jenis_kelamin'] == "P") ? "perempuan" : "laki-laki"); ?></td></tr>
	<tr><td>Alamat</td><td>:</td><td><?php echo $people['tempat_tinggal']; ?></td></tr>
	<tr><td>Phone/HP/Kontak Lain</td><td>:</td><td><?php echo $people['phone']." / ".$people['kontak_lain']; ?></td></tr>
	<tr><td>Catatan</td><td>:</td><td><?php echo $people['note']; ?></td></tr>
	<tr><td>tanggal data add.edit</td><td>:</td><td><?php echo $people['tanggal_add']." / ".$people['tanggal_update']; ?></td></tr>
	<tr><td colspan="4">{edit} {hapus}<a href="<?=site_url('descendant/').'/'.$people['id']?>#graph"><button type="button" class="btn btn-default btn-sm" title="telusuri keturunan"><span class="glyphicon glyphicon-chevron-down"></span>&nbsp;descendant</button></a><a href="<?=site_url('ancestors/').'/'.$people['id']?>#graph"><button type="button" class="btn btn-default btn-sm" title="telusuri moyang"><span class="glyphicon glyphicon-chevron-up"></span>&nbsp;ancestors</button></a></td></tr>
</table>
</div>
<?php
} else if ($mode == 'mini_bio') {
	/* printing individual list on one content div*/
?>
		<span class="mini_bio" style=" "><a href="<?=site_url("individual/detail/{$people['id']}")?>"><img height="50px" style="margin:1px; " align="left" src="<?php echo $people['foto']; ?>">&nbsp;<?php echo $people['nama_alias']; ?><br></a>&nbsp;<?php echo $people['umur']; ?>&nbsp;<?php echo $people['id']; ?></span>
<?php
} else if ($mode == 'mini_bio_leaf') {
	/* printing individual list on one content div*/
	$add_class = ($marked == TRUE) ? 'br12 bg-igreen30' : '' ;
?>
		<span class="din mini_leaf <?=$add_class?>" style=" " id="leaf_<?=$people['id']?>"><a href="<?=site_url("individual/detail/{$people['id']}")?>"><img width="80px" style="margin:1px; " src="<?php echo $people['foto']; ?>"><br><div class="din w-80 ellip"><?=$people['nama']?></div></a><br><div class="btn-group person_option"><?=$get_parent_line?><?=$this_person_line?><?=$this_person_option?></div></span>
		<!--
<br><span class="w-75 ellip"><?php echo $people['nama_alias']; ?></span><br>&nbsp;<?php echo $people['umur']; ?><br>		
		-->
<?php
} else if ($mode == 'mini_bio_leaf_2') {
	/* printing individual list on one content div*/
	$add_class = ($marked == TRUE) ? 'br12 bg-igreen30' : '' ;
?>
		<span class="mini_bio <?=$add_class?>" style=" "><a href="<?=site_url("individual/detail/{$people['id']}")?>"><img height="50px" style="margin:1px; " align="left" src="<?php echo $people['foto']; ?>">&nbsp;<?php echo $people['nama_alias']; ?><br></a>&nbsp;<?php echo $people['umur']; ?>&nbsp;<?php echo $people['id']; ?></span>
<?php
} else if ($mode == 'add_edit') {
$submode = (!isset($submode)) ? "" : $submode ;
	if ($submode == 'edit') {
		$_pid = $people['id'];
		$people['label_pernikahan'] = ($people['id_pernikahan'] <> 0) ? $people['ayah']."/".$people['ibu'] : "" ;
		$people['photo_note'] = '<small class="text-primary">browse gambar baru untuk mengganti gambar lama/menambahkan gambar baru</small>';
		$photo_file = $people['photo'];
		$submit_label 	= "Update";
		$reset_label 	= "Batalkan Edit";
?>
<div class="page_content bg-iwhite75">
<form role="form" class="people_form" id="frm_people_edit_<?=$_pid?>">
<h4><span class="glyphicon glyphicon-edit"></span> Edit Anggota Keluarga (<?=ucwords($people['nama']);?>)</h4>
<div id="edit_message_panel_<?=$_pid?>" style="margin-bottom:10px; padding:5px; display:none; ">pesan edit data</div>
<?php	
	} else {
		$people = array(
			'id'=> 0,				'nama' => '',			'alias' => '',
			'jenis_kelamin' => '',	'tempat_lahir' => '', 	'tanggal_lahir' => '',
			'tempat_tinggal' => '',
			'phone' => '',			'kontak_lain' => '',
			'id_pernikahan' => 0,	'label_pernikahan' => '',
			'id_pasangan' => 0,		'nama_pasangan' => '',
			'photo_note' => '',		
			'note' => '',
		);
		$_pid = $people['id'];
		$photo_file = site_url().'assets/images/foto/umum.jpg';
		$submit_label 	= "Tambahkan";
		$reset_label 	= "Reset";
?>
<div style="min-height:50px; " id="individual_add"></div>
<div class="page_content">
<form role="form" class="people_form" id="frm_people">
<h4><span class="glyphicon glyphicon-plus-sign"></span> Tambahkan Anggota Keluarga {sub mode penambahan (orang tua (ayah/ibu) dari/ anak dari/ pasangan}</h4>
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
	<td>Nama / Alias</td>
	<td><input type="hiddens" id="people_id" name="people_id" value="<?=$people['id']?>"><div class="w-50p"><input type="text" class="form-control" id="nama" name="nama" placeholder="nama" size="30" value="<?=$people['nama']?>"></div><div class="w-50p"><input type="text" class="form-control" id="alias" name="alias" placeholder="alias" size="30" value="<?=$people['alias']?>"></div></td>
	</tr>
	<tr>
	<td class="text-nowrap">Jenis Kelamin / Tempat / Tanggal Lahir</td>
	<td><div class="w-25p"><select class="form-control" id="jenis_kelamin" name="jenis_kelamin"><option <?=($people['jenis_kelamin'] == 'L') ? 'selected' : '';?>>L</option><option <?=($people['jenis_kelamin'] == 'P') ? 'selected' : '';?>>P</option></select></div><div class="w-50p"><input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="tempat kelahiran (kota)" value="<?=$people['tempat_lahir']?>"></div><div class="w-25p"><input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?=$people['tanggal_lahir']?>"></div></td>
	</tr>
	<tr><td>Alamat</td><td><div class="w-100p"><input type="text" class="form-control" id="tempat_tinggal" name="tempat_tinggal" placeholder="tempat tinggal" size="70" value="<?=$people['tempat_tinggal']?>"></div></td></tr>
	<tr><td>Phone / Kontak Lainnya</td><td><div class="w-25p"><input type="number" class="form-control" id="phone" name="phone" placeholder="no telp" value="<?=$people['phone']?>"></div><div class="w-75p"><input type="text" class="form-control" id="kontak_lain" name="kontak_lain" placeholder="kontak lainnya" size="40" value="<?=$people['kontak_lain']?>"></div></td></tr>
	<tr>
	<td>Ayah / Ibu</td>
	<td><div class="w-50p"><input class="w-100 id_pernikahan_<?=$_pid?>" type="hiddens" name="id_pernikahan" id="id_pernikahan" value="<?=$people['id_pernikahan']?>">
	<input type="search" class="form-control" name="label_pernikahan" id="label_pernikahan" placeholder="anak dari pernikahan" value="<?=$people['label_pernikahan']?>"></div><span class="text-info"> <span class="glyphicon glyphicon-ok-sign"></span> bisa dilihat daftar pernikahannya melalui <a href="<?=base_url()?>weddings/">weddings!</a></span></td>
	</tr>
	<tr>
	<td id="suami_istri_label">Suami / Istri</td><td><div class="w-50p"><input class="w-100 id_pasangan_<?=$_pid?>" type="hiddens" name="id_pasangan" id="id_pasangan" value="<?=$people['id_pasangan']?>">
	<input type="search" class="form-control" id="nama_pasangan" name="nama_pasangan" placeholder="nama pasangan" value="<?=$people['nama_pasangan']?>"></div> <span class="text-info"><span class="glyphicon glyphicon-ok-sign"></span> bisa ditambahkan melaui <a href="<?=base_url()?>weddings/">weddings!</a></span>
</td></tr>
	<tr>
	  <td>Foto<br><small>ukuran minimal 165x200</small><br><?=$people['photo_note']?></td>
	  <td><div class="w-25p"><input class="form-control" type="file" id="people_image" name="people_image" accept="image/gif, image/jpeg, image/png" onchange="readURL(this);" ><img id="blah" src="<?=$photo_file?>" alt="your image" / height="200" style="margin:2px; box-shadow:0 0 3px #999999; "></div></td></tr>
	<tr>
	  <td>Catatan</td>
	  <td><div class="w-100p"><textarea class="form-control" rows="2" id="note" name="note" placeholder="catatan"><?=$people['note']?></textarea></div></td></tr>
	<tr><td></td><td><button type="submit" class="btn btn-warning"><?=$submit_label?></button>&nbsp;<button type="reset" class="btn btn-info"><?=$reset_label?></button></td></tr>
</table>	
</form>
</div>
<?php
}
?>
