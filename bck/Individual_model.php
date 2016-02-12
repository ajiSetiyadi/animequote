<?php

class Individual_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library(array('session'));
        $this->load->helper('url_helper');
        $this->load->model('marriage_model');
		$this->_default_individual = 000000001;
	}
	
	public function set_individual($id = FALSE)
	{
	/**
	 * set asal atau default untuk pembuatan family tree
	 */
		$this->_default_individual = $id;
	}
	
	public function get_name($id = FALSE)
	{
	/**
	 * dapatkan nama (people) dari tabel berdasarkan id tertentu
	 */
		$query = $this->db->select('nama')->get_where('mybf_people', array('id' => $id));
		$data_people = $query->row_array();
		return $data_people['nama'];
	}
	
	public function get_people_detail($id = FALSE, $empty_replacement = '')
	{
	/**
	 * cetak tampilan layer people dengan id tertentu
	 */
		$query = $this->db->get_where('mybf_people', array('id' => $id));
		$people = $query->row_array();
		
		if ($people['id'] != '') {
			$photo_file = "assets/images/foto/individual/{$people['id']}_thumbs.jpg";
			$gender_photo_file = ($people['jenis_kelamin'] == 'L') ? "assets/images/foto/laki.jpg" : "assets/images/foto/perempuan.jpg";
				
			if (file_exists($photo_file) && is_file($photo_file)) {
				$people['foto']	= site_url().$photo_file;
			} else {
				$people['foto']	= site_url().$gender_photo_file;
			}
			if ($people['tanggal_lahir'] != NULL) {
				$umur = $this->getAge(strtotime($people['tanggal_lahir']),1);
				$people['umur'] = "<span class='ffc-05'>{$umur},</span>";
			} else {
				$people['tanggal_lahir'] = $empty_replacement;
				$people['umur'] = $empty_replacement;
			}
			
			if ($people['id_pernikahan'] > 0) {
				$query = $this->db->get_where('mybf_marriage', array('id' => $people['id_pernikahan']));
				$data_nikah = $query->row_array();
				//print_r($data_nikah);
				$people['id_ayah'] 	= $data_nikah['id_suami'];
				$people['id_ibu'] 	= $data_nikah['id_istri'];
				$people['ayah'] 	= $this->get_name($data_nikah['id_suami']);
				$people['ibu'] 		= $this->get_name($data_nikah['id_istri']);
			}
			
			$people['nama_alias'] = (!empty($people['alias'])) ? "{$people['nama']}, <small class=\"text-primary\">({$people['alias']})</small>" : $people['nama'] ;
			
			$people['tempat_lahir'] 	= (!empty($people['tempat_lahir'])) ? $people['tempat_lahir'] : $empty_replacement ;
			$people['tempat_tinggal'] 	= (!empty($people['tempat_tinggal'])) ? $people['tempat_tinggal'] : $empty_replacement ;
			
			$_return_content = $people;
		} else {
			$_return_content = "";
		}
		
		return $_return_content;
	}
		
	public function print_people_mini_bio($id = FALSE)
	{
	/**
	 * cetak tampilan layer people dengan id tertentu
	 */
		$people_detail = $this->get_people_detail($id);
		$people			= $people_detail;
		//print_r($people);
		
		if (is_array($people)) {
			$_return_content = $this->load->view('individual_view',array('mode' => 'mini_bio','people' => $people),TRUE);;
		} else {
			$_return_content = "";
		}
		
		return $_return_content;
	}
	
	public function print_people_leaf($id = FALSE,$marked = FALSE)
	{
	/**
	 * cetak tampilan layer people dengan id tertentu, berdasarkan penggunaan untuk family tre dan lainnya
	 */
		$people_detail = $this->individual_model->get_people_detail($id);
		$people			= $people_detail;
		//print_r($people);
		
		if (is_array($people)) {
			$couple = $this->marriage_model->get_couple_data($id,$people['jenis_kelamin']);
			if (!empty($couple['id'])) {
				$query = $this->db->order_by('tanggal_lahir', 'ASC')->get_where('mybf_people', array('id_pernikahan' => $couple['id_pernikahan']));
				$data_anak = $query->result_array();
				$jumlah_anak = count($data_anak);
				$person_line = ($jumlah_anak > 0) ? '<a href="'.site_url('descendant/').'/'.$people['id'].'#graph"><button type="button" class="btn btn-default btn-xs" title="telusuri keturunan"><span class="glyphicon glyphicon-chevron-down"></span></button></a>' : '' ;
			} else {
				$person_line = '' ;
			}	
			
			$parent_line = ($people['id_pernikahan'] > 0) ? '<a href="'.site_url('descendant/').'/'.$people['id_ayah'].'#graph"><button type="button" class="btn btn-default btn-xs" title="telusuri orang tua"><span class="glyphicon glyphicon-chevron-up"></span></button></a>' : '' ;
			
			$person_option = ($_SESSION['logged_in'] == TRUE) ? '<a href=""><button type="button" class="btn btn-default btn-xs" title="perlihatkan opsi"><span class="glyphicon glyphicon-cog"></span></button></a>' : '' ;
			
			$_return_content = $this->load->view('individual_view',array(
				'mode' => 'mini_bio_leaf', 'people' => $people, 'marked' => $marked,
				'get_parent_line' => $parent_line, 'this_person_line' => $person_line, 'this_person_option' => $person_option),TRUE);
		} else {
			$_return_content = "";
		}
		
		return $_return_content;
	}
						
	public function getAge($timestamp, $precision = 2) { 
	/**
	 * dapatkan umur dari 
	 */
	  $time = time() - $timestamp; 
	  $a = array('th' => 31557600, 'bln' => 2629800, 'mgg' => 604800, 'hr' => 86400, 'jam' => 3600, 'mnt' => 60, 'det' => 1); 
	  $i = 0; 
		foreach($a as $k => $v) { 
		  $$k = floor($time/$v); 
		  if ($$k) $i++; 
		  $time = $i >= $precision ? 0 : $time - $$k * $v; 
		  $s = $$k > 1 ? '' : ''; 
		  $$k = $$k ? $$k.' '.$k.$s.'' : ''; 
		  @$result .= $$k; 
		} 
	  return $result ? $result : '1 sec to go'; 
	} 
		
	public function get_people_by_gender_name($from_jk,$n,$count=25) {
	/**
	 * browsing peoples data by gender, nama and alias
	 */
		$content = $object = array();
		//$this->db->like('nama', $n);
		//$this->db->like('jenis_kelamin', $from_jk);
		//$this->db->or_like('alias', $n);
		$query = $this->db->query("SELECT * FROM mybf_people WHERE (nama LIKE '%{$n}%' OR alias LIKE '%{$n}%') AND jenis_kelamin = '{$from_jk}'");
		$data_people = $query->result_array();

		foreach ($data_people as $data_p) {
			$object[$data_p['id']] = $data_p;
		}

		ksort($object); //sorting berdarkan keynya, 
		return $object;
	}
		
	public function get_people($id = FALSE)
	{
	/* dignakan untuk menampilkan data individu secara list
	 *
	 */	
		global $error_tag;
		$this->db->order_by('nama', 'AESC');
		if ($id === FALSE)
		{
			$query = $this->db->get('mybf_people');
			$data_people = $query->result_array();
		}
		else
		{
			$query = $this->db->get_where('mybf_people', array('id' => $id));
			$data_people = $query->result_array();
		}
		
		//print_r($data_people);
		$r_data = array();
		
		foreach ($data_people as $data) {
			$query = $this->db->get_where('mybf_marriage', array('id' => $data['id_pernikahan']));
			$data_nikah = $query->row_array();
			//print_r($data_nikah);
			$data['id_ayah'] 	= $data_nikah['id_suami'];
			$data['id_ibu'] 	= $data_nikah['id_istri'];
			$data['ayah'] 		= $this->get_name($data_nikah['id_suami']);
			$data['ibu'] 		= $this->get_name($data_nikah['id_istri']);
			$data_pasangan 		= $this->marriage_model->get_couple_data($data['id'],$data['jenis_kelamin']);
			$data['id_pasangan'] 	= $data_pasangan['id'];
			$data['nama_pasangan'] 	= $data_pasangan['nama'];
			
			$photo_file = "assets/images/foto/individual/{$data['id']}_thumbs.jpg";
			$gender_photo_file = ($data['jenis_kelamin'] == 'L') ? "assets/images/foto/laki.jpg" : "assets/images/foto/perempuan.jpg";
			
			if (file_exists($photo_file) && is_file($photo_file)) {
				$data['photo']		= site_url().$photo_file;
			} else {
				$data['photo']		= site_url().$gender_photo_file;
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

