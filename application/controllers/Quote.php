<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quote extends CI_Controller {

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
        $this->load->model(array('quote_model'));
		//$this->load->library(array('session'));
		//$this->load->helper(array('url_helper'));
	}
		
	public function index($started_id = FALSE)
	{
	/*
	 * browse daftar quote
	 */
		$this->browse();
	}
	
	public function browse()
	{
	/*
	 * browse daftar quote
	 */
		$content = $this->load->view('quote_view',array('mode' => 'quote_header'),TRUE);
		
		$data['mode'] 	= 'quote_content';
		$data['quotes'] = $this->quote_model->get_list();
		$content .= $this->load->view('quote_view',$data,TRUE);
		
		$content .= $this->load->view('quote_view',array('mode' => 'quote_footer'),TRUE);
		
		$page_content = array(
			'title' 		=> "Quote",
			'content'		=> $content,
			'javascript'	=> array('ani_handling','quote'),
		);
		
		$this->load->view('page_normal',$page_content);
	}
	
	public function mylist()
	{
	/*
	 * browse daftar quote yang dibuat oleh user yang bersangkutan
	 */
		$content = $this->load->view('quote_view',array('mode' => 'quote_header', 'by_user' => " by ".$_SESSION['user']['fname']),TRUE);
		
		$data['mode'] 	= 'quote_content';
		$data['quotes'] = $this->quote_model->get_list('user_id',$_SESSION['user']['id']);
		$content .= $this->load->view('quote_view',$data,TRUE);
		
		$content .= $this->load->view('quote_view',array('mode' => 'quote_footer'),TRUE);
		
		$page_content = array(
			'title' 		=> "Quote by ".$_SESSION['user']['fname'],
			'content'		=> $content,
			'javascript'	=> array('ani_handling','quote'),
		);
		
		$this->load->view('page_normal',$page_content);
	}
	
	public function view($titleid = FALSE)
	{
	/*
	 * browse daftar quote
	 */
		if (preg_match("/\d/",$titleid)) {
			$quote = $data['quote'] = $this->quote_model->get_quote('id',$titleid);
		} else {
			$quote = $data['quote'] = $this->quote_model->get_quote('shortname',$titleid);
		}
		
	 	//print "<br><br><br><br>";
		//print_r($quote);
		
		//update quotes count
		$data['quote']['view_count'] = $this->quote_model->update_counter($quote['id']);
		
		$data['mode'] 	= 'quote_view_detail';
		
		$content = $this->load->view('quote_view',$data,TRUE);
		
		$page_content = array(
			'title' 		=> $quote['title'],
			'description' 	=> $quote['description'],
			'creator' 		=> $quote['user_name'],
			'picture_url' 	=> $quote['picture_url'],
			'content'		=> $content,
		);
		
		$this->load->view('page_quote',$page_content);
	}
	
}

?>
