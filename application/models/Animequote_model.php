<?php

class Animequote_model extends CI_Model {

	public $table_name = 'users';
	
	public function __construct(){
		//$this->load->database();
		parent::__construct();
        $this->load->model(array('user_model'));
		
		/**
		 * save last page
		 * add exclude : account/login|logout
		 */
		
		//apakah kode rari return FB ada
		$code 		= $this->input->get('code');
		$state 		= $this->input->get('state');
		$forcelogin = $this->input->get('forcelogin');
		
		$last_url = current_url();
		if (!preg_match("/(account\/login|account\/logout|login\/watchdata|\#\_\=\_)/si",$last_url)) {
			if (empty($code) || empty($state)) {$_SESSION['last_page'] = $last_url;}
		}
		
		if (!empty($code) && !empty($state)) {
			//jika ada maka update session dan juga databases
			//print "<br><br><br><br><br><br><br>";
			/**/
			$fbuser = $this->facebook->getUser();
			if(!$fbuser){
				$login_state = FALSE;
				$user_data = "";
			} else {
				print_r($fbuser);
				$user_profile = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
				print_r($user_profile);
				$user_data = $this->user_model->checkUser('facebook',$user_profile['id'],$user_profile['first_name'],$user_profile['last_name'],$user_profile['email'],$user_profile['gender'],$user_profile['locale'],$user_profile['picture']['data']['url']);
				if(!empty($user_data)){
					$login_state = TRUE;
				}else{
					$login_state = FALSE;
				}
			}
			
			$sess_data = array(
				'user'     		=> $user_data,
				'logged_in' 	=> $login_state
			);
			
			$this->session->set_userdata($sess_data);
			header("Location:{$_SESSION['last_page']}/"); 	
		} else if (!empty($forcelogin)) {
			/* override data for admin mode*/
			$user_data = $this->user_model->get_user('id',1);
			$login_state = TRUE;
			$sess_data = array(
				'user'     		=> $user_data,
				'logged_in' 	=> $login_state
			);
			
			$this->session->set_userdata($sess_data);
			header("Location:{$_SESSION['last_page']}"); 	
		}	
		
		if (isset($_SESSION['logged_in'])) {
			if ($_SESSION['logged_in'] == true) {
				define('ISLOGNED',true);
			} else {
				define('ISLOGNED',false);
			}
		} else {
			define('ISLOGNED',false);
		}
				
	}
	
}

?>

