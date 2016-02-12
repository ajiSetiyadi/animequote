<?php

class Marriage_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library(array('session'));
        $this->load->model('individual_model');
		$this->_default_couple = 1;
	}
	
	public function get_couple_data($id = FALSE, $gender = FALSE, $all_couple = FALSE)
	{
	/**
	 * dapatkan nama (people) pasangan dari tabel marriage 
	 * berdasarkan id dan juga gender (dari id) tersebut
	 */
	 	if ($id != FALSE) {
			if ($all_couple === TRUE) {
			// dapatkan seluruh pasangan dari orang yg dimaksudkan
				if ($gender == 'L') {
					$query = $this->db->select('id,id_istri')->get_where('mybf_marriage', array('id_suami' => $id));
					$person = $query->result_array();
					$cfield = "id_istri";
				} else if ($gender == 'P') {
					$query = $this->db->select('id,id_suami')->get_where('mybf_marriage', array('id_istri' => $id));
					$person = $query->result_array();
					$cfield = "id_suami";
				}
				
				$couple_data = array();
				foreach ($person as $d_person) {
					$id_person = $d_person[$cfield];
					$nama = $this->individual_model->get_name($id_person);
					$couple_data[$d_person['id']] = array('nama' => $nama, 'id' => $id_person, 'id_pernikahan' => $d_person['id']);
				}
				
				//print_r($couple_data);
				return $couple_data;
				
			} else {
			// dapatkan single data id person
				if ($gender == 'L') {
					$query = $this->db->select('id,id_istri')->get_where('mybf_marriage', array('id_suami' => $id));
					$person = $query->row_array();
					$id_person = $person['id_istri'];
				} else if ($gender == 'P') {
					$query = $this->db->select('id,id_suami')->get_where('mybf_marriage', array('id_istri' => $id));
					$person = $query->row_array();
					$id_person = $person['id_suami'];
				}
				$nama = $this->individual_model->get_name($id_person);
				return array('nama' => $nama, 'id' => $id_person, 'id_pernikahan' => $person['id']);
			}
	
		} else {
			return array('nama' => '', 'id' => '', 'id_pernikahan' => '');
		}
	}
	
	public function search_parent_by_name($n,$count=25) {
	/**
	 * dapatkan nama orang tua dari dari tabel marriage 
	 * searching for parent data by nama
	 */
		$content = $object = array();
		// get people id
		$query = $this->db->select('id')->like('nama', $n)->get_where('mybf_people');
		$data_people = $query->result_array();

		foreach ($data_people as $data_p) {
			//get couples data
			$query = $this->db->query("SELECT * FROM mybf_marriage 
				WHERE id_suami={$data_p['id']} 
				OR id_istri={$data_p['id']} 
				ORDER BY id ASC LIMIT 0,{$count}");
				
			$data_couple = $query->result_array();
			
			foreach ($data_couple as $data_c) {
			// get suami data
				$d_suami = $this->individual_model->get_people($data_c['id_suami']);
				
				$object[$data_c['id']]['id_suami'] = $data_c['id_suami'];
				$object[$data_c['id']]['id_istri'] = $data_c['id_istri'];
				$object[$data_c['id']]['tanggal_pernikahan'] = $data_c['tanggal_pernikahan'];
				$object[$data_c['id']]['status_pernikahan'] = $data_c['status_pernikahan'];
				$object[$data_c['id']]['alamat'] = $d_suami[$data_c['id_suami']]['tempat_tinggal'];
				$object[$data_c['id']]['label'] = $this->individual_model->get_name($data_c['id_suami'])."/".$this->individual_model->get_name($data_c['id_istri']);
			}
		}

		ksort($object); //sorting berdarkan keynya, 
		return $object;
	}
		
	public function search_couple_by_name($from_jk,$n,$count=25) {
	/**
	 * searching for couple data by nama istri/suami
	 */
		$content = $object = array();
		$query = $this->db->query("SELECT * FROM mybf_people WHERE (nama LIKE '%{$n}%' OR alias LIKE '%{$n}%') AND jenis_kelamin NOT LIKE '{$from_jk}'");
		$data_people = $query->result_array();

		foreach ($data_people as $data_p) {
			$object[$data_p['id']] = $data_p;
		}

		ksort($object); //sorting berdarkan keynya, 
		return $object;
	}

	public function get_couple($id = FALSE)
	{
	/** 
	 * dapatkan data pasangan pernikahan dengan id tertentu atau semuanya
	 */	
		global $error_tag;
		$this->db->order_by('tanggal_pernikahan,id', 'AESC');
		if ($id === FALSE) {
			$query 			= $this->db->get('mybf_marriage');
			$data_people 	= $query->result_array();
		}
		else {
			$query 			= $this->db->get_where('mybf_marriage', array('id' => $id));
			$data_people 	= $query->result_array();
		}
		
		$r_data = array();
		
		foreach ($data_people as $data) {
			$data['nama_suami'] = $this->individual_model->get_name($data['id_suami']);
			$data['nama_istri'] = $this->individual_model->get_name($data['id_istri']);
			
			$data['suami_istri'] = $this->individual_model->print_people_mini_bio($data['id_suami']);
			$data['suami_istri'] .= $this->individual_model->print_people_mini_bio($data['id_istri']);
			
			// load anak & menantu
			$data['anak'] = $data['menantu'] = "";
			$query = $this->db->order_by('tanggal_lahir', 'ASC')->get_where('mybf_people', array('id_pernikahan' => $data['id']));
			$data_anak = $query->result_array();
			foreach ($data_anak as $anak) {
				$data['anak'] 		.= $this->individual_model->print_people_mini_bio($anak['id']);
				// load data menantu
				$menantu 			= $this->get_couple_data($anak['id'],$anak['jenis_kelamin']);
				$data['menantu'] 	.= $this->individual_model->print_people_mini_bio($menantu['id']);
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
}

?>

