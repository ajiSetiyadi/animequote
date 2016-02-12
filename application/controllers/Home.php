<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		//$this->load->model(array('facebook_model'));
	}
		
	public function index()
	{
		$data['mode'] = 'welcome';
				
		$home_content = $this->load->view('home_view',$data,TRUE);
		$home_content = str_replace('(pr)','<span class="text-danger"><strong>(Pekerjaan Rumah) </strong></span>',$home_content);
		$home_content = str_replace('(ok)','<span class="text-important"><strong>(OK) </strong></span>',$home_content);
		
		$data = array(
			'title' 	=> "Home",
			'content'	=> $home_content,
		);
				
		$this->load->view('page_normal',$data);
	}
}

?>
