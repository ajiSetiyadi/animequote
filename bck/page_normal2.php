<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?> .: AnimeQuote :.</title>
	<link rel="stylesheet" href="<?=site_url();?>assets/css/bootstrap.css" charset="UTF-8">	
	<link rel="stylesheet" href="<?=site_url();?>assets/css/bootstrap-social.css" charset="UTF-8">
	<link rel="stylesheet" href="<?=site_url();?>assets/css/new_global.css.php" charset="UTF-8">
	<link rel="stylesheet" href="<?=site_url();?>assets/css/my.css" charset="UTF-8">
	<script>
		var site_url 		= '<?=site_url();?>';
		var base_url 		= '<?=base_url();?>';
		var data_spliter 	= '<:data-spliter:>';
		var error_tag 		= '<!--someerrorwasfoundhere-->';
	</script>
	
	<script language="javascript" src="<?=site_url();?>assets/js/jquery-2.1.4.min.js" charset="UTF-8"></script>
	<script language="javascript" src="<?=site_url();?>assets/js/jquery-ui-1.11.4/jquery-ui.js" charset="UTF-8"></script>
	<link rel="stylesheet" href="<?=site_url();?>assets/js/jquery-ui-1.11.4/jquery-ui.css" charset="UTF-8">
	
	<script language="javascript" src="<?=site_url();?>assets/js/bootstrap.min.js" charset="UTF-8"></script>
	<script language="javascript" src="<?=site_url();?>assets/js/mjava.js" charset="UTF-8"></script>
	<?php
	if (isset($javascript)) { 
		foreach ($javascript as $script) : ?>
			<script language="javascript" src="<?=site_url();?>assets/js/<?=$script?>.js" charset="UTF-8"></script>
	<?php	
		endforeach; 
	}
	?>
</head>
<body>
	<?php
		$active_nav = array(1=>'','','','','','','','','');
		switch ($title) {
			case 'Home' : $active_nav[1] = 'active'; break;
			case 'People' : $active_nav[2] = 'active'; break;
			case 'Marriage' : $active_nav[3] = 'active'; break;
			case 'Ancestor' : $active_nav[4] = 'active'; break;
			case 'Descendant' : $active_nav[5] = 'active'; break;
			case 'Family Tree' : $active_nav[6] = 'active'; break;
		}
	?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="<?=site_url();?>">AnimeQuote</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?=$active_nav[1]?>"><a href="<?=site_url();?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <li class="<?=$active_nav[2]?> dropdown"><a class="dropdown-toggle" data-toggle="dropdown" onClick="" href="<?=site_url('quote');?>"><span class="	glyphicon glyphicon-cloud"></span> Quote <span class="caret"></span></a>
			<ul class="dropdown-menu">
			  <li><a href="<?=site_url('quote/browse');?>/"><span class="glyphicon glyphicon-th-list"></span> Browse</a></li>
<?php if (ISLOGNED) { ?>
			  <li><a href="<?=site_url('quote/list');?>/"><span class="glyphicon glyphicon-th-list"></span> Your Creation</a></li>
			  <li><a href="<?=site_url('quote/add');?>/"><span class="glyphicon glyphicon-plus"></span> Add a Quote</a></li>
<?php } ?>
			</ul><!---->
		</li>
        <li class="<?=$active_nav[2]?> dropdown"><a class="dropdown-toggle" data-toggle="dropdown" onClick="" href="<?=site_url('pooling');?>"><span class="	glyphicon glyphicon-list"></span> Pooling <span class="caret"></span></a>
			<ul class="dropdown-menu">
			  <li><a href="<?=site_url('pooling/browse');?>/"><span class="glyphicon glyphicon-th-list"></span> Browse</a></li>
<?php if (ISLOGNED) { ?>
			  <li><a href="<?=site_url('pooling/list');?>/"><span class="glyphicon glyphicon-th-list"></span> Your Creation</a></li>
			  <li><a href="<?=site_url('pooling/add');?>/"><span class="glyphicon glyphicon-plus"></span> Add a Pooling</a></li>
<?php } ?>
			</ul><!---->
		</li>
        <li class="<?=$active_nav[3]?>"><a href="<?=site_url('blog');?>/"><span class="	glyphicon glyphicon-file"></span> Blog</a></li> 
	  <li class="">
    <div class="" style="vertical-align:baseline; padding-top:10px; max-width:300px;">
	
	<div class="input-group">
	  <input type="text" class="form-control" placeholder="Search for...">
      <div class="input-group-btn">
	 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="	glyphicon glyphicon-search"></span>&nbsp;<span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="#"><span class="	glyphicon glyphicon-search"></span>&nbsp;Quote</a></li>
          <li><a href="#"><span class="	glyphicon glyphicon-search"></span>&nbsp;Pooling</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#"><span class="	glyphicon glyphicon-search"></span>&nbsp;All</a></li>
        </ul>     
      </div>
    </div></div><!-- /input-group -->
  </li><!-- /.col-lg-6 -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
<?php if (ISLOGNED) { ?>
        <li><a href="<?=site_url('account/detail');?>/"><span class="btn btn-xs btn-social-icon btn-twitter"><span class="fa fa-twitter"></span></span> <?=$_SESSION['fb_1670402949883956_user_id']?></a></li>
        <li class="<?=$active_nav[3]?>"><a href="<?=site_url('account/logout');?>/"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li> 
<?php } else { ?>
        <li class="<?=$active_nav[3]?>"><a href="<?=site_url('account/login');?>/"><span class="glyphicon glyphicon-log-in"></span> LogIn</a></li> 
        <li class="<?=$active_nav[3]?>"><a href="<?=site_url('account/login');?>/"><span class="glyphicon glyphicon-log-in"></span> LogIn with Facebook</a></li> 
<?php } ?>
      </ul>
    </div>
  </div>
</nav>
<div id="container" class="container">
	<?php print $content;
			print "<br></br><br>";//. $login_url = $this->facebook->getAccessToken();
		
		print_r($_SESSION);?>

<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        Apa yang Ada disini</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">Maaf sebelumnya, karena aplikasi web ini baru dibuat makanya belum banyak isinya XP .</div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        Apa yang bisa kamu dapatkan disini</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">Kami tidak menawarkan hal-hal muluk,
	  seperti aplikasi super ataupun lainnya, yang ada disini cuma aplikasi sederhana.</div>
    </div>
  </div>
</div>

</div>
<div id="footer">AnimeQuote Project, &copy; 2106 (Jan 18th)
<div class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>, & Bootstrap Version <strong>3.3.6</strong> </div></div>
</body>
</html>
