<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Individual extends CI_Controller {

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
        $this->load->model('db_model');
        $this->load->helper(array('url','form','json','mysql','image'));
	}
			
	public function personal()
	{
		$jk 	= $this->input->get('jk');
		$src 	= $this->input->get('term');
		$max 	= $this->input->get('max');
		$object = $this->individual_model->get_people_by_gender_name($jk,$src,$max);
		
		$content = array();
		foreach ($object as $k => $v){
			$nama = $v['nama'];
			$content[$nama]['id'] 		= $k;
			$content[$nama]['value'] 	= $nama;
			$alias 						= ($v['alias'] == '') ? "" : "&nbsp;<span class=\"text-primary\">({$v['alias']})</span>";
			$content[$nama]['label'] 	= $nama.$alias;
			
			$photo_file = "assets/images/foto/individual/{$k}_thumbs.jpg";
			$gender_photo_file = ($jk == 'L') ? "assets/images/foto/laki.jpg" : "assets/images/foto/perempuan.jpg";
			
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
		$id 	= $this->input->post('people_id'); //validasi
		//print_r($_POST);
		$rem_people = $this->db->delete('mybf_people', array('id' => $id));
		
		if ($rem_people) {
			$content['message'] = "removing individual data success";
			//removing data pernikahan
			$rem_marriage = $this->db->query("DELETE FROM mybf_marriage WHERE id_suami={$id} OR id_istri={$id}");
			
			//hapus file foto
			$id = sprintf('%09d',$id);
			$newFileName 			= $id.".jpg";//.$path_parts['extension'];
			$newThumbsFileName 		= $id."_thumbs.jpg";//.$path_parts['extension'];
			$newThumbsFileName_mini = $id."_thumbs_mini.jpg";//.$path_parts['extension'];
			$targetPath 	= "assets/images/foto/individual/";
			if (is_file($targetPath .$newFileName)) {unlink($targetPath .$newFileName);}
			if (is_file($targetPath .$newThumbsFileName)) {unlink($targetPath .$newThumbsFileName);}
			if (is_file($targetPath .$newThumbsFileName_mini)) {unlink($targetPath .$newThumbsFileName_mini);}
			
		} else {
			$content['message'] = "remove individual data failed".ERROR_TAG;
		}
		
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
	
	public function sunting()
	{
		$id = $this->input->post('people_id'); //validasi
		//$id = '000000001';
		//print_r($_POST);
		$data_people 		= $this->individual_model->get_people($id);
		if ($data_people[$id]['nama'] != NULL) {
			$content['message'] = "loaded available data success!";
			$data['people']		= $data_people[$id];
			$data['mode'] 		= 'add_edit';
			$data['submode'] 	= 'edit';
			$content['row'] 	= $this->load->view('individual_view',$data,TRUE); //print rows function
		} else {
			$content['message'] = "data empty".ERROR_TAG;
			$content['row'] 	= "data empty or record not found"; //print rows function
		}
		
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
	
	public function register($submode='') 
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
			$data['id']	= sprintf('%09d',$this->db_model->select_max('id','mybf_people')+1);
			$data['date_added'] = $now;
		} else if ($submode == 'update') {
			$updated_id = $this->input->post('people_id');
			$data['id']	= $updated_id;
		}
		$data['date_updated'] = $now;
		
		$data['nama'] 			= $this->input->post('nama'); //validasi
		$data['alias'] 			= $this->input->post('alias'); //validasi
		$data['jenis_kelamin'] 	= $this->input->post('jenis_kelamin'); //validasi
		$data['tempat_lahir'] 	= $this->input->post('tempat_lahir'); 
		$data['tanggal_lahir'] 	= $this->input->post('tanggal_lahir'); //validasi
		$data['tempat_tinggal'] = $this->input->post('tempat_tinggal');
		$data['phone'] 			= $this->input->post('phone');//validasi
		$data['kontak_lain'] 	= $this->input->post('kontak_lain');
		$data['id_pernikahan'] 	= $this->input->post('id_pernikahan');
		$data['note'] 			= $this->input->post('note');
		
		$data['tanggal_lahir']	= ($data['tanggal_lahir'] == '') ? '0000-00-00' : $data['tanggal_lahir'] ;	 
		$data['id_pernikahan'] 	= ($data['tanggal_lahir'] == '') ? '0' : $data['id_pernikahan'] ;
		
		$id_pasangan 			= $this->input->post('id_pasangan');
		
		// jika ada file gambar dilampirkan, upload gambar 
		if(is_array($_FILES)) {
			if(is_uploaded_file($_FILES['people_image']['tmp_name'])) {
				print_r($_FILES);
				$path_parts 	= pathinfo($_FILES['people_image']['name']);
				$newFileName 	= $data['id'].".".$path_parts['extension'];
				$newThumbsFileName 			= $data['id']."_thumbs.".$path_parts['extension'];
				$newThumbsFileName_mini 	= $data['id']."_thumbs_mini.".$path_parts['extension'];
				$sourcePath 	= $_FILES['people_image']['tmp_name'];
				$targetPath 	= "assets/images/foto/individual/";
				if(move_uploaded_file($sourcePath,$targetPath.$newFileName)) {
					$data['photo'] 	= $_FILES['people_image']['name'];
					//success
					$MYFILE -> makeImageThumbs($targetPath.$newFileName,$targetPath.$newThumbsFileName,165,200,"fill","center",array(),80);
					$MYFILE -> makeImageThumbs($targetPath.$newThumbsFileName,$targetPath.$newThumbsFileName_mini,50,50,"fit-h","center",array(),80);
				}
			}
		}
		
		if ($submode == 'add') {
			//validasi exitensi data person
			$query_people_add = $this->db->insert('mybf_people', $data);
			if ($query_people_add) {
				$content['message'] = "adding individual data success";
			} else {
				$content['message'] = "adding individual data failed".ERROR_TAG;
			}
		} else if ($submode == 'update') {
			//validasi exitensi data person
			//print_r($data);

			/**/
			$this->db->where('id', $updated_id);
			//$this->db->update('mybf_people', $data);
			$query_people_update = $this->db->update('mybf_people', $data);
			if ($query_people_update) {
				$content['message'] = "updating individual data success";
			} else {
				$content['message'] = "updating individual data failed".ERROR_TAG;
			}
		}
		/**/
		
		if (is_numeric($id_pasangan) && $id_pasangan > 0) {
			//registrasikan pasangan jika belum ada di db
			/*
			$query = $this->db->query("SELECT * FROM mybf_people 
				WHERE nama='{$data['nama']}'
				OR tempat_lahir='{$data['tempat_lahir']}'
				ORDER BY id DESC LIMIT 0,1");
				
			$data_people 	= $query->result_array();*/
			$people_id 		= $data['id'];
			
			//validasi urutan
			if ($data['jenis_kelamin'] == 'L') {
				$data_pasangan = array('id_suami' => $people_id,'id_istri' => $id_pasangan);
			} else {
				$data_pasangan = array('id_istri' => $people_id,'id_suami' => $id_pasangan);
			}
			$data_pasangan['date_added'] = $data_pasangan['date_updated'] = $now;
		
			$query_couple = $this->db->select('id')->get_where('mybf_marriage', $data_pasangan);
			$c_data = $query_couple->result_array();
			if (empty($c_data['id'])) { 
				// jika tidak ada di tabel, tambahkan
				$this->db->insert('mybf_marriage', $data_pasangan);
			}
		}
		
		//output
		$data['peoples'] = $this->individual_model->get_people($data['id']);
		$data['mode'] 	= 'list_content';
		$content['row'] = $this->load->view('individual_view',$data,TRUE); //print rows function
		
		print DATA_SPLITER.print_json($content,false).DATA_SPLITER;
	}
}

?>
