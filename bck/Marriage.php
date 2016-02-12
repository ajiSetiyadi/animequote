<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marriage extends CI_Controller {

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
       // $this->load->model('individual_model');
        $this->load->model('marriage_model');
       // $this->load->helper('url_helper');
	}
		
	public function index()
	{
	/**
	 * perlihatkan seluruh data pernikahan
	 */
		$data['couples'] = $this->marriage_model->get_couple();
		$data['mode'] 	= 'list_content';
		$add_form 		= $this->load->view('marriage_view',array('mode' => 'add_edit'),TRUE);
		
		$content = $this->load->view('marriage_view',array('mode' => 'list_header'),TRUE);
		$content .= $this->load->view('marriage_view',$data,TRUE);
		$content .= $this->load->view('marriage_view',array('mode' => 'list_footer', 'add_form' => $add_form),TRUE);
		
		$page_content = array(
			'title' 	=> "Marriage",
			'content'	=> $content,
			'javascript'	=> array('ani_handling','marriage','individual'),
		);
		$this->load->view('page_normal',$page_content);
	}
	
	public function detail($id)
	{
	/**
	 * perlihatkan data pernikahan detail berdasarkan id tertentu
	
		$data['people'] 	= $this->individual_model->get_people($id);
		$data['mode'] 		= 'detail';
		$nama 				= $data['people']['nama'];
		
		$project = $this->load->view('individual_view',$data,TRUE);
		
		$data = array(
			'title' 	=> ucwords($nama),
			'content'	=> $project,
		);
		$this->load->view('page_normal',$data); */
	}
}

?>
