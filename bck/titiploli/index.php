<html>
<head>
<?php
$pics = array(
	1 => array('file' => 'loli_is_justice.jpg', 'title' => 'loli is justice (chino-chan)'),
	2 => array('file' => 'dont_bully_loli.jpg', 'title' => 'jangan bully loli (tsukiko-chan)'),
	3 => array('file' => 'loli_play.jpg', 		'title' => 'jangan ganggu loli saat dia lagi main (yam-chan)'),
);

$pic_id = array_rand($pics);

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Nitip Loli, Jangan diapa2 in</title>
<meta name="description" content="Jangan Budayakan Meninggalkan Jejak dengan Nitipin Loli, ntar bisa di karungin orang">

<meta property="og:url"                content="http://animequote.tk/titiploli" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="Nitip Loli, Jangan diapa2 in" />
<meta property="og:description"        content="Jangan Budayakan Meninggalkan Jejak dengan Nitipin Loli, ntar bisa di karungin orang" />
<meta property="og:image"              content="http://animequote.tk/titiploli/<?=$pics[$pic_id]['file']?>" />
<!--
<script async="" src="analytics.js"></script><script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-70824464-1', 'auto');
  ga('send', 'pageview');
</script>-->
<style>
body{
padding-top:20px;
background-color:#000000;
color:#FFFFFF;
font-size:20px;
font-family:Tahoma, Arial, Helvetica, sans-serif;
text-align:center;
padding:0px;
margin:0px;
}
.footer{
	height:60px;
}
.footer_banner{
	height:50px;
	position:fixed;
	bottom:0px;
	background-color:#333333;
	padding:0px;
	width:100%;
	padding:5px;
}
h2{font-weight:300;}
.titipan{
	display:inline-table;
	margin:5px;
	padding:5px 10px;
	color:#FFFFFF;
	background-color:#000000;
}
.titipan:hover{background-color:#999999;}
</style>
</head>
<body>

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

<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>

<p>&nbsp;</p>
<p><h1>TITIP LOLI</h1></p>
<p><h2>Titip Loli Ini, Jangan diapa-apain!<br><i>(Jangan Budayakan Meninggalkan Jejak dengan Nitipin Loli, ntar bisa di karungin orang)</i></h2></p>
<img src="<?=$pics[$pic_id]['file']?>">
<p><h2><?=$pics[$pic_id]['title']?></h2></p>
<?php
	$page_counter = 0;
	$counter_file = "counter.txt";
	
	$handle = fopen($counter_file, "rb");
	$contents = fread($handle, filesize($counter_file));
	fclose($handle);
	
	$page_counter = $contents+1;
	
	$fp = fopen($counter_file, 'w');
	fwrite($fp, $page_counter);
	fclose($fp);
?>
<p><h2>hit counter : <?=$page_counter?></h2></p>
<?php
$titipan = array(
	'titip doa' 	=> 'titipdoay.esy.es',
	'titip loli' 	=> 'titiploli.esy.es',	
	'BYE' 			=> 'byey.esy.es',	
);	
$titipan_lain = "";
foreach ($titipan as $title => $link) {
	$host = $_SERVER['HTTP_HOST'];
	if (!preg_match("/".preg_quote($link)."/si",$host)) {
		$titipan_lain .= "<a href=\"http://{$link}/\"><span class=\"titipan\">".ucwords($title)."</span></a>";
	}
}
//untuk titipan lainnya belum tersedia, tunggu aja tanggal releasenya
?>
<div class="footer"></div>
<div class="footer_banner"><?=$titipan_lain?></div>
</body>
</html>