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
        $this->load->model('individual_model');
        $this->load->model('marriage_model');
        $this->load->model('db_model');
        $this->load->helper(array('url','form','json','mysql','image'));
	}
		
	public function pernikahan()
	{
		$src = $this->input->get('term');
		$max = $this->input->get('max');
		$object = $this->marriage_model->search_parent_by_name($src,$max);
		
		$content = array();
		foreach ($object as $k => $v){
			$label = $v['label'];
			$content[$label]['id'] 		= $k;
			$content[$label]['value'] 	= $label;
			$content[$label]['label'] 	= $label;
			
			$photo_file1 = "assets/images/foto/individual/{$v['id_suami']}_thumbs.jpg";
			$photo_file2 = "assets/images/foto/individual/{$v['id_istri']}_thumbs.jpg";
			
			if (file_exists($photo_file1) && is_file($photo_file1)) {
				$foto_suami		= site_url().$photo_file1;
			} else {
				$foto_suami		= site_url()."assets/images/foto/laki.jpg";
			}
			
			if (file_exists($photo_file2) && is_file($photo_file2)) {
				$foto_istri		= site_url().$photo_file2;
			} else {
				$foto_istri		= site_url()."assets/images/foto/perempuan.jpg";
			}
			
			print_r($v);
			
			if ($v['tanggal_pernikahan'] != '') {
				$usiaPern = $this->individual_model->getAge(strtotime($v['tanggal_pernikahan']),1);
				$usiaPern = "<span class='ffc-01'>{$usiaPern}, </span>";
			} else {
				$usiaPern = "";
			}

			$content[$label]['foto_suami'] = $foto_suami;
			$content[$label]['foto_istri'] = $foto_istri;
			$content[$label]['description'] = "{$usiaPern}<span class=\"ffc-12\">{$v['alamat']}</span>";
		}
		ksort($content);
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
	
	public function pasangan()
	{
		$jk 	= $this->input->get('jk');
		$src 	= $this->input->get('term');
		$max 	= $this->input->get('max');
		$object = $this->marriage_model->search_couple_by_name($jk,$src,$max);
		
		$content = array();
		foreach ($object as $k => $v){
			$nama = $v['nama'];
			$content[$nama]['id'] 		= $k;
			$content[$nama]['value'] 	= $nama;
			$alias 						= ($v['alias'] == '') ? "" : "&nbsp;<span class=\"text-primary\">({$v['alias']})</span>";
			$content[$nama]['label'] 	= $nama.$alias;
			
			$photo_file = "assets/images/foto/individual/{$k}_thumbs.jpg";
			$gender_photo_file = ($jk == 'P') ? "assets/images/foto/laki.jpg" : "assets/images/foto/perempuan.jpg";
			
			if (file_exists($photo_file) && is_file($photo_file)) {
				$foto		= site_url().$photo_file;
			} else {
				$foto		= site_url().$gender_photo_file;
			}

			if ($v['tanggal_lahir'] != '') {
				$umur = $this->individual_model->getAge(strtotime($v['tanggal_lahir']),1);
				$umur = "<span class='ffc-05'>{$umur},</span>";
			} else {
				$umur = "";
			}

			$content[$nama]['foto'] 		= $foto;
			$content[$nama]['description'] 	= $umur."<span class=\"ffc-12\">({$v['tempat_tinggal']})</span>"; // usia/ alamat
		}
		
		if (!is_null($content)) ksort($content);
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
	
	public function hapus()
	{
		$id 	= $this->input->post('couple_id'); //validasi
		//print_r($_POST);
		$rem_couple = $this->db->delete('mybf_marriage', array('id' => $id));
		
		if ($rem_couple) {
			$content['message'] = "removing marriage data success";
		} else {
			$content['message'] = "remove marriage data failed (no index selected or data maybe unavailable)".ERROR_TAG;
		}
		
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
	
	public function sunting()
	{
		$id = $this->input->post('couple_id'); //validasi
		//$id = '000000001';
		//print_r($_POST);
		$data_couple 		= $this->marriage_model->get_couple($id);
		if ($data_couple[$id]['id_suami'] != NULL) {
			$content['message'] = "loaded available data success!";
			$data['couple']		= $data_couple[$id];
			$data['mode'] 		= 'add_edit';
			$data['submode'] 	= 'edit';
			$content['row'] 	= $this->load->view('marriage_view',$data,TRUE); //print rows function
		} else {
			$content['message'] = "data empty".ERROR_TAG;
			$content['row'] 	= "data empty or record not found"; //print rows function
		}
		
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
	
	public function register($submode='update') 
	{
		/** 
		 * proses register data people
		 * - get latest id
		 * - get posted data
		 */
		 
		//$this->load->library('image_lib');
		$MYFILE = new MyFile;
		$now = date('U');
		
		if ($submode == 'add') {
			$data['id']	= sprintf('%09d',$this->db_model->select_max('id','mybf_marriage')+1);
			$data['date_added'] = $now;
		} else if ($submode == 'update') {
			$updated_id = $this->input->post('couple_id');
			$data['id']	= $updated_id;
		}
		$data['date_updated'] = $now;
		
		$data['id_suami'] 	= $this->input->post('id_suami'); //validasi
		$data['id_istri'] 	= $this->input->post('id_istri'); //validasi
		$data['tanggal_pernikahan'] 	= $this->input->post('tanggal_pernikahan'); //validasi
		$data['status_pernikahan'] 		= $this->input->post('status_pernikahan'); 
		$data['note'] 	= $this->input->post('note');
		
		if ($submode == 'add') {
			//validasi exitensi data person
			// cek existensi data
			$id = $this->db_model->get_value('id','mybf_marriage',"id_suami = {$data['id_suami']} AND id_istri = {$data['id_istri']}");
			if ($id > 0) {
				$content['message'] = "adding marriage data failed!<br>same data already exists".ERROR_TAG;
			} else {
				$query_marriage_add = $this->db->insert('mybf_marriage', $data);
				if ($query_marriage_add) {
					$content['message'] = "adding marriage data success";
				} else {
					$content['message'] = "adding marriage data failed".ERROR_TAG;
				}			
			}

		} else if ($submode == 'update') {
			//validasi exitensi data person
			print_r($data);

			/**/
			$this->db->where('id', $updated_id);
			//$this->db->update('mybf_marriage', $data);
			$query_marriage_update = $this->db->update('mybf_marriage', $data);
			if ($query_marriage_update) {
				$content['message'] = "updating marriage data success";
			} else {
				$content['message'] = "updating marriage data failed".ERROR_TAG;
			}
		}
		
		//output
		$data['couples'] = $this->marriage_model->get_couple($data['id']);
		$data['mode'] 	= 'list_content';
		$content['row'] = $this->load->view('marriage_view',$data,TRUE); //print rows function
		
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
}

?>
