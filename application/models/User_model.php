<?php

class User_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	
  /**
   * checking facebook user data's
   * req : user must be logned via site
   */
	public function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$picture){
		
		$fb_query = $this->db->query("SELECT * FROM users WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'");
		$userdata = $fb_query->result_array();
		if(count($userdata)>0){
			$update = $this->db->query("UPDATE users SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'");
		}else{
			$insert = $this->db->query("INSERT INTO users SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'");
		}
		
		$query = $this->db->query("SELECT * FROM users WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'");
		$result = $query->row_array();
		return $result;
	}
	
	public function setUserData() {
			//define('FACEBOOKUSER',array('name' => 'vheissa'));
	}
	
	public function get_user($by = FALSE, $item= FALSE)
	{
	/**
	 * dapatkan nama (people) dari tabel berdasarkan id tertentu
	 */
	 	if ($by == 'id') {
			$query = $this->db->get_where('users', array('id' => $item));
			$data = $query->row_array();
		} else {
			$query = $this->db->get_where('users', array('fname' => $item));
			$data = $query->row_array();
		}

		//$query = $this->db->select('*')->get_where('users', array('id' => $id));
		//$data_people = $query->row_array();
		return $data;
	}

	public function get_name($id = FALSE)
	{
	/**
	 * dapatkan nama (people) dari tabel berdasarkan id tertentu
	 */
		$query = $this->db->select('fname')->get_where('users', array('id' => $id));
		$data_people = $query->row_array();
		return $data_people['fname'];
	}

}

?>

