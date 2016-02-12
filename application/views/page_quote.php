<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
	<meta name="author" 				content="<?=$creator?>">
	<meta name="description" 			   content="<?=$description?>">
	<meta property="fb:app_id"             content="1670402949883956" />
	<meta property="og:url"                content="<?=current_url();?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?=$title?>" />
	<meta property="og:description"        content="<?=$description?>" />
	<meta property="og:image"              content="<?=$picture_url?>" />
	<meta property="og:locale"             content="id_ID" />
	<meta property="og:locale:alternate"   content="en_US" />
	<meta property="fb:profile_id"   		content="100000464300634" />

	<link rel="stylesheet" href="<?=site_url();?>assets/css/bootstrap.css" charset="UTF-8">	
	<link rel="stylesheet" href="<?=site_url();?>assets/css/bootstrap-social.css" charset="UTF-8">
	<link rel="stylesheet" href="<?=site_url();?>assets/css/docs.css" charset="UTF-8">
	<link rel="stylesheet" href="<?=site_url();?>assets/css/font-awesome.css" charset="UTF-8">
	<link rel="stylesheet" href="<?=site_url();?>assets/css/new_global.css.php" charset="UTF-8">
	<link rel="stylesheet" href="<?=site_url();?>assets/css/my.css" charset="UTF-8">

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1670402949883956',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

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
<?php include_once('menu.php'); ?>
<div id="container" class="container">
	<?php print $content;
	//print_r($_SESSION);?>

</div>
<div id="footer">AnimeQuote Project, &copy; 2106 (Jan 18th)
<div class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>, & Bootstrap Version <strong>3.3.6</strong> </div></div>
</body>
</html>
