<?php

header('Content-Type:text/css');

//print basename($_SERVER['PHP_SELF']);
//if(basename($_SERVER['PHP_SELF']) == 'new_global.php') echo "<pre>";
/*
* php CSS class
* the simplest way to define multiple CSS for repeated values, better than replace teh value one by one
*/
echo "\n/*FONT SIZE*/\n\n";
for ($x=7;$x<=25;$x++){
	echo ".fs{$x}{font-size : {$x}px;}\n";
	echo ".lh".($x)."{line-height : ".($x)."px;}\n";
}
for ($x=1;$x<=5;$x++){
	echo ".fs".($x*5+25)."{font-size : ".($x*5+25)."px;}\n";
	//echo ".lh".($x*5+25)."{line-height : ".($x*5+25)."px;}\n";
}

echo "\n/*FONT-COLOR*/\n\n";
$fc_arr = array(
'w' => '#FFFFFF',
'b' => '#000000',
'r' => '#FF0000',
);
foreach($fc_arr as $k=>$v){
	print".ffc{$k},.ffc{$k}:hover,.ffc{$k}:link,.ffc{$k}:visited,.ffc{$k}:active{font-color:{$v};color:{$v};}\n";
}

echo "\n/*PADDING, MARGIN*/\n\n";
$pm_arr = array(0,1,2,3,5,10,15,20);
foreach($pm_arr as $v){
	print ".p{$v},.pt-{$v},.pt{$v},.pp-{$v} {padding-top:{$v}px;}\n";
	print ".p{$v},.pb-{$v},.pb{$v},.pp-{$v} {padding-bottom:{$v}px;}\n";
	print ".p{$v},.pr-{$v},.pr{$v},.ps-{$v} {padding-right:{$v}px;}\n";
	print ".p{$v},.pl-{$v},.pl{$v},.ps-{$v} {padding-left:{$v}px;}\n";
	print ".m{$v},.mt-{$v},.mp-{$v} {margin-top:{$v}px;}\n";
	print ".m{$v},.mb-{$v},.mp-{$v} {margin-bottom:{$v}px;}\n";
	print ".m{$v},.mr-{$v},.ms-{$v} {margin-right:{$v}px;}\n";
	print ".m{$v},.ml-{$v},.ms-{$v} {margin-left:{$v}px;}\n";
	print "\n";
}

echo "\n/*BACKGROUND COLOR / BORDER*/ /*FONT-COLOR*/ /*TABLE FORMAT*/ /*SHADOW/BOX COLOR*/\n";
$bc_arr = array(
	'ff' => '#FFFFFF', /*LIGHT*/
	'00' => '#000000', /*DARK*/
	'01' => '#DF1212', /*RED*/
	'02' => '#12DF12', /*GREEN*/
	'03' => '#1212DF', /*BLUE*/
	'04' => '#eeff11', /*YELLOW*/
	'05' => '#0F7196', /*BLUE dark*/
	'06' => '#CAEDF9', /*BLUE light*/
	'07' => '#25B7E7', /*BLUE CYAN*/
	'08' => '#77c7f7', /*BLUE sea*/
	'09' => '#f7c757', /*ORANGE*/
	'10' => '#97f7c7', /*GREEN SEA*/
	'11' => '#E6FFED', /*GREEN GREY*/
	'12' => '#009966', /*GREEN DARK*/
	'13' => '#666666', /*GRAY*/
);
foreach($bc_arr as $k=>$v){
	print "
.ffc-{$k},.ffc-{$k}:hover,.ffc-{$k}:link,.ffc-{$k}:visited,.ffc-{$k}:active{font-color:{$v};color:{$v};}
.bc{$k} {background-color: {$v};}
.br{$k} {border:1px solid {$v};}
.br{$k}-2 {border:2px solid {$v};}
.br{$k}-b {border-bottom:1px solid {$v};}
.br{$k}-bdash {border-bottom:1px dashed {$v};}
.br{$k}-2b {border-bottom:2px solid {$v};}
.br{$k}-t {border-top:1px solid {$v};}
.br{$k}-tdash {border-top:1px dashed {$v};}
.br{$k}-2t {border-top:2px solid {$v};}
.br{$k}-r {border-right:1px solid {$v};}
.br{$k}-rdash {border-right:1px dashed {$v};}
.br{$k}-2r {border-right:2px solid {$v};}
.br{$k}-l {border-left:1px solid {$v};}
.br{$k}-ldash {border-left:1px dashed {$v};}
.br{$k}-2l {border-left:2px solid {$v};}

table.table_type{$k} tr td, table.table_stand{$k} tr td, table.table_type{$k} tr th, table.table_stand{$k} tr th{	border-left:1px dashed {$v};	border-bottom:1px solid {$v};	padding:3px;	}
table.table_type{$k} tr td:last-child, table.table_stand{$k} tr td:last-child, table.table_type{$k} tr th:last-child, table.table_stand{$k} tr th:last-child{	border-right:1px dashed {$v};	}
table.table_type{$k} tr:first-child td, .br{$k}-3t{border-top:3px solid {$v};	}
table.table_type{$k} tr:last-child td, .br{$k}-3b{	border-bottom:3px solid {$v};	}

.ss-{$k}::-webkit-scrollbar-corner, .ss-{$k}::-webkit-scrollbar-thumb{
	background-color:{$v};
	border-color:{$v};
}

.sb{$k}{box-shadow: 0 0px 2px {$v};-webkit-box-shadow: 0 0px 2px {$v};}
.sb{$k}-2{-webkit-box-sizing: border-box;box-shadow: 0 0px 4px {$v};-webkit-box-shadow: 0 0px 4px {$v};}

	";
}
// , .ss-{$k}::-webkit-scrollbar-button:start:decrement, .ss-{$k}::-webkit-scrollbar-button:end:increment //<-- scrool end start

echo "\n/*DIMENSION : HEIGHT, WIDTH, HOVER POSITION, HOVER DIMENSION*/\n";
$dim_arr = array(
	10,15,16,20,24,25,30,32,40,48,50,64,67,75,80,96,100,128,150,175,180,200,230,235,240,250,260,270,290,295,300,360,380,400,450,500,600,612,800,1000 //icon size = 16,24,32,64,96,128
);
foreach($dim_arr as $wh){
	echo "
.hoverdim2{$wh}:hover {height:{$wh}px;}
.hoverdim2{$wh}{height: 0px; transition: height 0.2s;}
.hoverpos2{$wh}:hover {top:-{$wh}px;position:relative;}
.hoverpos2{$wh}{top:0px; transition: top 0.2s;}
.h-{$wh} {height:{$wh}px;max-height:{$wh}px;overflow:hidden;}
.w-{$wh} {width:{$wh}px;max-width:{$wh}px;overflow:hidden;white-space:normal;}
.maxh-{$wh} {max-height:{$wh}px;}
.maxw-{$wh} {max-width:{$wh}px;}
.minh-{$wh} {min-height:{$wh}px;}
.minw-{$wh} {min-width:{$wh}px;}";
}

echo "\n/*LARGE RADIUS*/";
$lra_arr = array(
	8,10,12,16,20,24,30,32,40,48,64 //icon size = 16,24,32,64,96,128
);
foreach($lra_arr as $brd){
	echo "
.large_radius_all_{$brd},.lra{$brd}{!important;
	-webkit-border-radius: {$brd}px;
	-moz-border-radius: {$brd}px;
	-o-border-radius: {$brd}px;
	border-radius: {$brd}px;
}";
}

echo "\n\n/*BACKGROUND IMAGE / CLASS FOR HOVER EVENT, DLL*/\n";
$bg_arr = array(
	'a' => 'green',
	'b' => 'red',
	'c' => 'blue',
	'd' => 'grey',
	'e' => 'pink',
	'f' => 'white',
	'g' => 'black',
	'h' => 'yellow',
);
foreach ($bg_arr as $k => $v){
	echo "
.hover-{$k},.hover-i{$v}{cursor:default;}
.bg-grad-i{$v},.hover-grad-i{$v}:hover{background:url('image/bg/bg_grad_white3.png'),url('image/bg/bg_{$v}_trans75.png'); background-size:100% 100%; background-repeat:no-repeat;}
.bg-i{$v},.hover-{$k}:hover,.hover-i{$v}:hover{background-image:url('image/bg/bg_{$v}_trans.png'); background-repeat:repeat;}
.bg-i{$v}75,.hover-i{$v}75:hover{background-image:url('image/bg/bg_{$v}_trans75.png'); background-repeat:repeat;}
.bg-i{$v}30,.hover-i{$v}30:hover{background-image:url('image/bg/bg_{$v}_trans30.png'); background-repeat:repeat;}";
}

echo "\n\n/*LINING BACKGROUND, DLL*/\n";
$bg_arr = array(
	'ld' => 'line_diag',
	'lh' => 'line_hatch',
	'ldb' => 'line_diag_blue',
	'lhb' => 'line_hatch_blue',
	'ldg' => 'line_diag_green',
	'lhg' => 'line_hatch_green',
	'bg' => 'block_green',
	'bb' => 'block_black',
);
foreach ($bg_arr as $k => $v){
	echo "
.hover-{$k},.hover-i{$v}{cursor:hand;}
.bg-i{$k},.bg-i{$v},.hover-i{$k}:hover,.hover-i{$v}:hover{background-image:url('image/bg/bg_{$v}.png'); background-repeat:repeat;}";
}

echo "\n\n/*ICON BACKGROUND : FILESYSTEM (DIR,IMAGE,VIDEO,DLL), DLL*/\n";
$icon_set_arr = array(
	'16' => 'filesystem_icon_set16',
	'24' => 'filesystem_icon_set24',
	'32' => 'filesystem_icon_set32',
	'48' => 'filesystem_icon_set48',
	'64' => 'filesystem_icon_set64',
	'128' => 'filesystem_icon_set128',
);
$icon_index_arr = array(
	'0,0' => 'folder',
	'0,1' => 'bluefolder',
	'0,2' => 'redfolder',
	'0,3' => 'greenfolder',
	'0,4' => 'pinkfolder',
	//file
	'1,0' => 'unknown',	'2,0' => 'music',	'3,0' => 'video',	'4,0' => 'archieve',
	'1,1' => 'image',	'2,1' => 'text',	'3,1' => 'subtitle',	'4,1' => 'html',
	'1,2' => 'part',	'2,2' => 'playlist',
	'1,3' => 'wiki',	'2,3' => 'wiki2',
);
foreach ($icon_set_arr as $k => $v){
	foreach ($icon_index_arr as $ka => $va){
	list($x,$y) = explode(',',$ka);
		echo "
.icon_{$k}_{$va}{display:inline-block;width:{$k};height:{$k};background-image:url('image/icon/{$v}.png'); background-repeat:no-repeat; background-size:".($k*5)."px ".($k*5)."px ; background-position:-".$x*$k."px -".$y*$k."px;}";
	}
}

echo "\n\n/*ICON BACKGROUND : ACTION IMAGE / BUTTON, DLL*/\n";
$icon_set_arr = array(
	'16' => 'action_icon_set16',
	'20' => 'action_icon_set20',
	'24' => 'action_icon_set24',
	'32' => 'action_icon_set32',
	'48' => 'action_icon_set48',
	'64' => 'action_icon_set64',
/*	'16' => 'action_icon_set128',
	'20' => 'action_icon_set128',
	'24' => 'action_icon_set128',
	'32' => 'action_icon_set128',
	'64' => 'action_icon_set128',*/
	'128' => 'action_icon_set128',
);
$icon_index_arr = array(
	'0,0' => 'animehdd','1,0' => 'menu',	'2,0' => 'tag',		'3,0' => 'help',	
	'4,0' => 'minimize', '5,0' => 'search', '6,0' => 'filter', 	'7,0' => 'close',
	
	'0,1' => 'avatar',	'1,1' => 'soundoff','2,1' => 'soundon',	'3,1' => 'play',	
	'4,1' => 'k',		'5,1' => 'k',
	
	'0,2' => 'edit',	'1,2' => 'remove',	'2,2' => 'add',		'3,2' => 'ok',
	'4,2' => 'no',		'5,2' => 'subobject',
	
	'0,3' => 'reset',	'1,3' => 'crop',	'2,3' => 'rotateccw','3,3' => 'rotatecw',
	'4,3' => 'rotate180','5,3' => 'null',
	
	'0,4' => 'prev',	'1,4' => 'next',	'2,4' => 'first',	'3,4' => 'last',	
	'4,4' => 'up',		'5,4' => 'down',
	
	'0,5' => 'favorite','1,5' => 'request',	'2,5' => 'seticon',	'3,5' => 'c',	
	'4,5' => 'b',		'5,5' => 'colorpicker',
	
	'0,6' => 'gallery',	'1,6' => 'calendar','2,6' => 'wecard',	'3,6' => 'c',		
	'4,6' => 'cover_bg','5,6' => 'slideshow',
	
	'0,7' => 'meme',	'1,7' => 'post',	'2,7' => 'comment',	'3,7' => 'vert-bars',
	'4,7' => 'hori-bars','5,7' => 'grids',	'6,7' => 'memechat','7,7' => 'gadget',
);
foreach ($icon_set_arr as $k => $v){
	foreach ($icon_index_arr as $ka => $va){
	list($x,$y) = explode(',',$ka);
		echo "
.icon_{$k}_{$va}{display:inline-block;width:{$k};height:{$k};background-image:url('image/icon/{$v}.png'); background-repeat:no-repeat; background-size:".($k*8)."px ".($k*8)."px ; background-position:-".$x*$k."px -".$y*$k."px;}";
	}
}

echo "\n\n/*ICON : FLAG, DLL*/\n";
$icon_set_arr = array(
	'24' => 'flag_icon_set64',
	'32' => 'flag_icon_set64',
	'64' => 'flag_icon_set64',
	'128' => 'flag_icon_set128',
);
$icon_index_arr = array(
	'0,0' => 'jp', '1,0' => 'en',	'2,0' => 'id',	'3,0' => 'sk',	'4,0' => 'archieve',
);
foreach ($icon_set_arr as $k => $v){
	foreach ($icon_index_arr as $ka => $va){
	list($x,$y) = explode(',',$ka);
		echo "
.flagicon_{$k}_{$va}{display:inline-block;width:{$k}px;height:".(5/8*$k)."px;background-image:url('image/icon/{$v}.png'); background-repeat:no-repeat; background-size:".($k*5)."px ".(5/8*$k*1)."px ; background-position:-".$x*$k."px -".$y*$k."px;}";
	}
}

//if(basename($_SERVER['PHP_SELF']) == 'new_global.php') echo "</pre>";

exit;
?>

