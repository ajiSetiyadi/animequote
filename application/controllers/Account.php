<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
        parent::__construct();
        $this->load->model(array('user_model'));
	}
		
	public function index($nameid = FALSE)
	{
		$this->view($nameid);
	}
	
	
	public function detail($nameid = FALSE)
	{
	/*
	 * cetak detail individual*/
		if (preg_match("/\d/",$nameid)) {
			$data_user = $data['user'] = $this->user_model->get_user('id',$nameid);
		} else {
			$data_user = $data['user'] = $this->user_model->get_user('fname',$nameid);
		}
		
		//print "<br><br><br><br>";
		$graph_picture = $this->facebook->api('/me/picture?type=large&redirect=false');
		//print_r($graph_picture);
		
		$data['user']['large_picture_url'] 	= $graph_picture['data']['url'];
		$data['mode'] 	= 'user_detail';
		$nama			= $data_user['fname'];
		
		$content = $this->load->view('user_view',$data,TRUE);
		
		$data = array(
			'title' 	=> ucwords($nama),
			'content'	=> $content,
		);
		$this->load->view('page_normal',$data);
	
	}
	
	public function watchdata() {
	
		/*
		$fbuser = $this->facebook->getUser();
		//print_r($fbuser);
		if(!$fbuser){
			$login_state = FALSE;
			$user_data = "";
		}else{
			$user_profile = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
			$user_data = $this->user_model->checkUser('facebook',$user_profile['id'],$user_profile['first_name'],$user_profile['last_name'],$user_profile['email'],$user_profile['gender'],$user_profile['locale'],$user_profile['picture']['data']['url']);
			if(!empty($user_data)){
				$login_state = TRUE;
			}else{
				$login_state = FALSE;
			}
		}
		
		$sess_data = array(
			'user'     => $user_data,
			'logged_in' => $login_state
		);
		
		$this->session->set_userdata($sess_data);
		header("Location:{$_SESSION['last_page']}"); 		*/	
	}
	
	public function login()
	{
	/*
	 * login ke website dengan berbagai mode 
	 */
		$fbPermissions = 'email';  //Required facebook permissions

		//$fbuser = null;
		$loginUrl = $this->facebook->getLoginUrl(array('redirect_uri'=>site_url('').'/','scope'=>$fbPermissions));
		header("Location:{$loginUrl}"); 		
		
	}
	
	public function logout()
	{
	/*
	 * login ke website dengan berbagai mode 
	 */
	 	$last_page = $_SESSION['last_page'];
		// change redirect page if
		$last_page = preg_replace(
			array("/quote\/mylist/si","/quote\/add/si","/pooling\/mylist/si","/pooling\/add/si"),
			array("quote/browse","quote/browse","pooling/browse","pooling/browse"),
		$last_page);
		
		$this->facebook->destroySession();
		//session_start();
		unset($_SESSION['userdata']);
		session_destroy();
		header("Location:{$last_page}");
	}
}

?>
