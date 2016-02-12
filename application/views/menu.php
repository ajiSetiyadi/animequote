<?php
/**
 * Navigation / Menu
 */
?>
	<?php
		$active_nav = array(1=>'','','','','','','','','');
		switch ($title) {
			case 'Home' : $active_nav[1] = 'active'; break;
			case 'Quote' : $active_nav[2] = 'active'; break;
			case 'Pooling' : $active_nav[3] = 'active'; break;
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
			  <li><a href="<?=site_url('quote/mylist');?>/"><span class="glyphicon glyphicon-th-list"></span> Your Creation</a></li>
			  <li><a href="<?=site_url('quote/add');?>/"><span class="glyphicon glyphicon-plus"></span> Add a Quote</a></li>
<?php } ?>
			</ul><!---->
		</li>
        <li class="<?=$active_nav[3]?> dropdown"><a class="dropdown-toggle" data-toggle="dropdown" onClick="" href="<?=site_url('pooling');?>"><span class="	glyphicon glyphicon-list"></span> Pooling <span class="caret"></span></a>
			<ul class="dropdown-menu">
			  <li><a href="<?=site_url('pooling/browse');?>/"><span class="glyphicon glyphicon-th-list"></span> Browse</a></li>
<?php if (ISLOGNED) { ?>
			  <li><a href="<?=site_url('pooling/mylist');?>/"><span class="glyphicon glyphicon-th-list"></span> Your Creation</a></li>
			  <li><a href="<?=site_url('pooling/add');?>/"><span class="glyphicon glyphicon-plus"></span> Add a Pooling</a></li>
<?php } ?>
			</ul><!---->
		</li>
        <li class="<?=$active_nav[4]?>"><a href="<?=site_url('blog');?>/"><span class="	glyphicon glyphicon-file"></span> Blog</a></li> 
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
<!--
<img src="<?=$_SESSION['user']['picture']?>" style=" border:1px solid #999999; " width="20px"> &nbsp;
-->
        <li><a href="<?=site_url('account/detail');?>/"><?=$_SESSION['user']['fname']?></a></li>
        <li class="<?=$active_nav[3]?>"><a href="<?=site_url('account/logout');?>/"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li> 
<?php } else { 

		//$fbPermissions = 'email';  //Required facebook permissions
//print $loginUrl = $this->facebook->getLoginUrl(array('redirect_uri'=>site_url('account/watchdata').'/','scope'=>$fbPermissions));
?>
        <li class="<?=$active_nav[3]?>"><span style=" display:inline-table; margin-top:10px; margin-right:20px; "><a href="<?=site_url('account/login');?>/" class="btn btn-m btn-social btn-facebook"><span class="fa fa-facebook"></span> Sign in with Facebook</a></span></li> 
<?php } ?>
      </ul>
    </div>
  </div>
</nav>

