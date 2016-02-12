<?php

class Quote_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
        //$this->load->model(array('individual_model','marriage_model'));
	}
	
	public function get_list($by = FALSE, $item = FALSE)
	{
	/* dignakan untuk menampilkan data individu secara list
	 *
	 */	
		global $error_tag;
		$this->db->order_by('id', 'AESC');
		if ($by)
		{
			$query = $this->db->get_where('anime_quote', array($by => $item));
			$data_people = $query->result_array();
		}
		else
		{
			$query = $this->db->get('anime_quote');
			$data_people = $query->result_array();
		}
		
		//print_r($data_people);
		$r_data = array();
		
		foreach ($data_people as $data) {
			//$query = $this->db->get_where('users', array('id' => $data['user_id']));
			//$data_nikah = $query->row_array();
			//print_r($data_nikah);
			$data['user_name'] 		= $this->user_model->get_name($data['user_id']);
			/**/
			$picture_file = "assets/images/quotes/{$data['id']}.jpg";//_thumbs
			$default_picture_file = "assets/images/quotes/none.jpg";
			
			if (file_exists($picture_file) && is_file($picture_file)) {
				$data['picture_url']		= site_url().$picture_file;
			} else {
				$data['picture_url']		= site_url().$default_picture_file;
			}			
			
			$y_data[$data['id']] = $data;
			unset($data);
		}
		
		foreach ($y_data as $data) {
			$r_data[$data['id']] = $data;
			unset($data);
		}
		
		return $r_data;
	}
	
	public function get_quote($by = 'id', $item = FALSE)
	{
	/**
	 * dapatkan quote data dengan kriteria tertentu
	 */	
		if ($by) {
			$query = $this->db->get_where('anime_quote', array($by => $item));
			$data = $query->row_array();
		} else {
			$query = $this->db->get_where('anime_quote', array('id' => $item));
			$data = $query->row_array();
		}
		
		//print_r($data);
		$r_data = array();
		
		$data['user_name'] 		= $this->user_model->get_name($data['user_id']);
		/**/
		$picture_file = "assets/images/quotes/{$data['id']}.jpg";//_thumbs
		$default_picture_file = "assets/images/quotes/none.jpg";
		
		if (file_exists($picture_file) && is_file($picture_file)) {
			$data['picture_url']	= site_url().$picture_file;
		} else {
			$data['picture_url']	= site_url().$default_picture_file;
		}			
			
		$y_data[$data['id']] = $data;
		
		return $data;
	}
	
	function update_counter($id = 'id',$new_counter = FALSE) {
	//updating counter
		$query = $this->db->select('id,counter')->get_where('anime_quote', array('id' => $id));
		$data = $query->row_array();
		$data['counter']++;
		// prevent update all data
		//$this->db;
		$u_data = array('counter' => $data['counter']);
		$query_people_update = $this->db->where('id', $data['id'])->update('anime_quote', $u_data);
		return $data['counter'];
	}
				
}

?>

