<?php

class Db_model extends CI_Model {

	public function __construct()
    {
        $this->load->database();
    }
		
	public function select_max($field,$table)
	{
	/* dapatkan nilai maksimal suatu field dalam suatu table 
	 */
		$query = $this->db->select_max($field)->get_where($table);
		$data = $query->row_array();
		return $data[$field];
	}
		
	public function get_value($field,$table,$where=NULL)
	{
	/* dapatkan nilai maksimal suatu field dalam suatu table 
	 */
	 	$wh = ($where == NULL) ? "" : "WHERE {$where}";
		$query = $this->db->query("SELECT {$field} FROM {$table} {$wh}");
		$data = $query->row_array();
		print_r($data);
		return $data[$field];
	}
		
}

