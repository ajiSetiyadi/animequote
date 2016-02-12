<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Cross PHP Java live vaiables
|--------------------------------------------------------------------------
|
| variable2 dibawan ini diperlukan untuk menghandel script,
| yang akan dipanngil di java script melalui variabel PHP ini
| variabel belum bisa digunakan secaraglobal, 
| maka untuk sementara menggunakan constant
*/
$config['data_spliter'] 	= $data_spliter 	= '<:data-spliter:>';
$config['error_tag'] 		= $error_tag 	= '<!--someerrorwasfoundhere-->';

define('ERROR_TAG',$error_tag);
define('DATA_SPLITER',$data_spliter);

?>

