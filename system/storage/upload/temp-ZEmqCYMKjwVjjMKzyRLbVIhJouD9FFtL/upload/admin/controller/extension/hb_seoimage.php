<?php
class ControllerExtensionHbSeoimage extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$data['extension_version'] =  '7.2';

		$this->load->language('extension/hb_seoimage');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('setting/hb_seoimage');
		
		if ($this->config->get('hb_seoimage_installed') <> 1){
			$this->response->redirect($this->url->link('extension/hb_seoimage/install', 'token=' . $this->session->data['token'], true));
		}
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_seoimage', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/hb_seoimage', 'token=' . $this->session->data['token'], true));
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		
		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'tab_dashboard',
				'tab_setting',
				'col_batch_id',
				'col_batch_range',
				'col_batch_status',
				'col_batch_tstatus',
				'col_batch_date',
				'col_action',
				'text_no_records',
				'text_batch_generated', 
				'text_link_count',
				'text_language','text_target_folder','text_unassigned_folder','text_retain_filetype',
				'btn_batch',
				'btn_generate',
				'btn_clear_batch'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/hb_seoimage', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_seoimage', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
		$data['uninstall'] = $this->url->link('extension/hb_seoimage/uninstall', 'token=' . $this->session->data['token'], true);
		$data['token'] = $this->session->data['token'];
		
		$data['all_batches'] =  $this->model_setting_hb_seoimage->getbatch();
		
		$data['hb_seoimage_max_entries'] = $this->config->get('hb_seoimage_max_entries');
		$data['hb_seoimage_language'] = $this->config->get('hb_seoimage_language');
		$data['hb_seoimage_target_folder'] = $this->config->get('hb_seoimage_target_folder');
		$data['hb_seoimage_unassigned_folder'] = $this->config->get('hb_seoimage_unassigned_folder');
		$data['hb_seoimage_retain_type'] = $this->config->get('hb_seoimage_retain_type');
		
		$this->load->model('localisation/language');
		$data['languages'] = $languages = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_seoimage', $data));

	}
	
	public function estimatebatch(){
		$product_count = $this->db->query("SELECT count(*) as count FROM  `" . DB_PREFIX . "product` ORDER BY product_id ASC ");
		$product_count = $product_count->row['count'];
		
		$no_of_product = $this->config->get('hb_seoimage_max_entries'); //number of product links per page
		
		$number_of_batch = ceil($product_count / $no_of_product);
		$offset = 0;
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE `batch_id` > $number_of_batch");
		
		for ($t = 1; $t<=$number_of_batch; $t++){
			
			$ranges = $this->db->query("SELECT min(c.product_id) as min_id , max(c.product_id) as max_id FROM (SELECT a.product_id FROM " . DB_PREFIX . "product a ORDER BY a.product_id ASC LIMIT $no_of_product OFFSET $offset) c");
			$min_id = (isset($ranges->row['min_id']))? $ranges->row['min_id'] :'0';
			$max_id = (isset($ranges->row['max_id']))? $ranges->row['max_id'] :'0';
			
			$range_check = $this->db->query("SELECT count(*) as range_row_count FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE min_range = $min_id and max_range = $max_id and batch_id = $t");
			$range_row = $range_check->row['range_row_count'];
			if ($range_row == 0){
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE `batch_id` = $t");	
			$this->db->query("INSERT INTO `" . DB_PREFIX . "hb_seoimage_batch`(`batch_id`, `min_range`, `max_range`, `status`) VALUES ('".$t."','".$min_id."','".$max_id."','0')");
			}
			
			$offset = $offset + $no_of_product;
			
		} //foreach ends 
		
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Batch Estimated Succesfully!</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function resetbatch(){
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_seoimage_batch`");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Batch Records Deleted!</div>';
			$this->response->setOutput(json_encode($json));	
	}
		
	public function renameproductimage($id=0){
		$time_start = microtime(true);
		if (isset($_POST['id'])){
			$id = $_POST['id'];
		}
		$count = 0;
		$language_id = $this->config->get('hb_seoimage_language'); //get the default language	
		$target_parent_folder_name = $this->config->get('hb_seoimage_target_folder');//'product_image';
		$target_image_path = DIR_IMAGE.$target_parent_folder_name;
		$unassigned_category_folder = $this->config->get('hb_seoimage_unassigned_folder');//'misc';
			
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE id = $id LIMIT 1");
		$batch_id = $query->row['batch_id'];
		$min_range = $query->row['min_range'];
		$max_range = $query->row['max_range'];
				
		$this->load->model('setting/hb_seoimage');
	
		$products = $this->db->query("SELECT a.product_id, a.image, b.name FROM  `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "product_description` b WHERE a.product_id = b.product_id and b.language_id = $language_id and a.status = 1 and a.product_id >= $min_range and a.product_id <= $max_range ORDER BY a.product_id ASC ");
		$products_count = $products->num_rows;
		$products = $products->rows;
		
		foreach ($products as $product){
			$product_id = $product['product_id'];
			$image = $product['image'];
			$name = $product['name'];
			$category = $this->model_setting_hb_seoimage->getCategoriesName($product_id,$language_id);
				if ($category){
					$category = $category;
				}else{
					$category = '';
				}
				
			if ($image <> ''){ //checking if image is set for the given product
					$filetypeextension = substr(strrchr($image,'.'),1);
					if ($this->config->get('hb_seoimage_retain_type') == 1){
						$filetypeextension = 'jpg';
					}else{
						$filetypeextension = $filetypeextension;
					}
					$oldpath = DIR_IMAGE.$image;
					//echo $image.'<br>'; //DEV
					//$pos = strpos($image,'data');
					
					if (strpos($image,$target_parent_folder_name) === false) { 
						$seoimage = $this->url_slug($name);
						if ($category <> ''){
							if (strpos($category,'|') !== false) {
								$cats = explode('|',$category);
								$foldername = $this->url_slug($cats[0]); //multiple category but taking the parent category
							}else {
								$foldername = $this->url_slug($category); //single category
							}
							if (!file_exists($target_image_path.$foldername)) {
								mkdir($target_image_path.$foldername, 0777, true);
							}
						}else{
							$foldername = $unassigned_category_folder;
							if (!file_exists($target_image_path.$foldername)) {
								mkdir($target_image_path.$foldername, 0777, true);
							}
						}
						$renamedimage = $target_parent_folder_name.$foldername.'/'.$seoimage.'.'.$filetypeextension;
						if ($this->model_setting_hb_seoimage->checkimagename($renamedimage) > 0){ //this checks if same image name is already present
							$renamedimage = $target_parent_folder_name.$foldername.'/'.$seoimage.'-'.$product_id.'.'.$filetypeextension;
						}
						$newpath = DIR_IMAGE.$renamedimage;
						if (file_exists($oldpath)){
							rename ($oldpath,$newpath);	
						}
						$this->model_setting_hb_seoimage->generatepimgrename($image, $renamedimage);
						$count = $count + 1;
					}
				}	
		}//foreach ends
				
		$this->db->query("UPDATE `" . DB_PREFIX . "hb_seoimage_batch` SET status = 1, count = $products_count WHERE id = $id");
		$time_end = microtime(true);
		$execution_time = number_format(($time_end - $time_start),3);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Image renaming process completed in '.$execution_time.' seconds</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function renameadditionalproductimage($id=0){
		$time_start = microtime(true);
		if (isset($_POST['id'])){
			$id = $_POST['id'];
		}

		$count = 0;
		$language_id = $this->config->get('hb_seoimage_language'); //get the default language	$this->config->get('hb_seoimage_product_freq');
		$target_parent_folder_name = $this->config->get('hb_seoimage_target_folder');//'product_image';
		$target_image_path = DIR_IMAGE.$target_parent_folder_name;
		$unassigned_category_folder = $this->config->get('hb_seoimage_unassigned_folder');//'misc';
			
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE id = $id LIMIT 1");
		$batch_id = $query->row['batch_id'];
		$min_range = $query->row['min_range'];
		$max_range = $query->row['max_range'];
				
		$this->load->model('setting/hb_seoimage');
	
		$products = $this->db->query("SELECT a.product_id, a.product_image_id, a.image, b.name FROM  `" . DB_PREFIX . "product_image` a, `" . DB_PREFIX . "product_description` b WHERE a.product_id = b.product_id and b.language_id = $language_id and a.product_id >= $min_range and a.product_id <= $max_range ORDER BY a.product_id ASC ");
		$products_count = $products->num_rows;
		$products = $products->rows;
		
		foreach ($products as $product){
			$product_id = $product['product_id'];
			$product_image_id = $product['product_image_id'];
			$image = $product['image'];
			$name = $product['name'];
			$category = $this->model_setting_hb_seoimage->getCategoriesName($product_id,$language_id);
				if ($category){
					$category = $category;
				}else{
					$category = '';
				}
				
			if ($image <> ''){ //checking if image is set for the given product
					$filetypeextension = substr(strrchr($image,'.'),1);
					if ($this->config->get('hb_seoimage_retain_type') == 1){
						$filetypeextension = 'jpg';
					}else{
						$filetypeextension = $filetypeextension;
					}
					$oldpath = DIR_IMAGE.$image;
					
					if (strpos($image,$target_parent_folder_name) === false) {
						$seoimage = $this->url_slug($name);
						if ($category <> ''){
							if (strpos($category,'|') !== false) {
								$cats = explode('|',$category);
								$foldername = $this->url_slug($cats[0]); //multiple category but taking the parent category
							}else {
								$foldername = $this->url_slug($category); //single category
							}
							if (!file_exists($target_image_path.$foldername)) {
								mkdir($target_image_path.$foldername, 0777, true);
							}
						}else{
							$foldername = $unassigned_category_folder;
							if (!file_exists($target_image_path.$foldername)) {
								mkdir($target_image_path.$foldername, 0777, true);
							}
						}
						
						$renamedimage = $target_parent_folder_name.$foldername.'/'.$seoimage.'-'.$product_image_id.'.'.$filetypeextension;
			
						$newpath = DIR_IMAGE.$renamedimage;
						if (file_exists($oldpath)){
							rename ($oldpath,$newpath);	
						}
						$this->model_setting_hb_seoimage->generatepimgrename($image, $renamedimage);
						$count = $count + 1;
					}
				}	
		}//foreach ends
				
		$this->db->query("UPDATE `" . DB_PREFIX . "hb_seoimage_batch` SET astatus = 1 WHERE id = $id");
		$time_end = microtime(true);
		$execution_time = number_format(($time_end - $time_start),3);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Product additional image renaming process completed in '.$execution_time.' seconds</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function resetproductbatch(){
			$id = $_POST['id'];
			$column = $_POST['column'];
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seoimage_batch` SET `".$column."` = 0 WHERE id = $id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Reset Successful </div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogeneratemain(){
		$time_start = microtime(true);
		$query = $this->db->query("SELECT id FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE status = 0");
		$results = $query->rows;
		if (isset($results)){
			foreach ($results as $result){
				$this->renameproductimage($result['id']);
			}
		}
		$time_end = microtime(true);
		$execution_time = number_format(($time_end - $time_start),3);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Image renaming process completed in '.$execution_time.' seconds</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogenerateadditional(){
		$time_start = microtime(true);
		$query = $this->db->query("SELECT id FROM `" . DB_PREFIX . "hb_seoimage_batch` WHERE astatus = 0");
		$results = $query->rows;
		if (isset($results)){
			foreach ($results as $result){
				$this->renameadditionalproductimage($result['id']);
			}
		}
		$time_end = microtime(true);
		$execution_time = number_format(($time_end - $time_start),3);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Product additional image renaming process completed in '.$execution_time.' seconds</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogenerateall(){
		$time_start = microtime(true);
		$this->autogeneratemain();
		$this->autogenerateadditional();
		$time_end = microtime(true);
		$execution_time = number_format(($time_end - $time_start),3);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Image renaming process completed in '.$execution_time.' seconds</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function loaddashboard() {
		$this->language->load('extension/hb_seoimage');
		$this->load->model('setting/hb_seoimage');
		
		$text_strings = array(
				'col_batch_id',
				'col_batch_range',
				'col_batch_status',
				'col_batch_tstatus',
				'col_batch_date',
				'text_no_records',
				'text_batch_generated',
				'btn_batch',
				'btn_generate',
				'btn_clear_batch'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		$data['all_batches'] =  $this->model_setting_hb_seoimage->getbatch();
		$target_parent_folder_name = $this->config->get('hb_seoimage_target_folder');
		$data['target'] = 		DIR_IMAGE.$target_parent_folder_name;

		$this->response->setOutput($this->load->view('extension/hb_seoimage_batch.tpl', $data));
	}
	
	public function url_slug($string){
		  $string = htmlspecialchars_decode($string);
		  $string = $this->cleanwords($string);
		  $string = preg_replace('!\s+!', ' ',$string);
		  $string = str_replace(' ','-',$string);
		  $string = trim(preg_replace('/-+/', '-', $string), '-');
		  return $string;
	}	
	
	public function cleanwords($str, $options = array()) {
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = htmlspecialchars_decode($str);
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		$defaults = array(
		'delimiter' => ' ',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => true,
		);
		// Merge options
		$options = array_merge($defaults, $options);
		$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
		'ß' => 'ss',
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
		'ÿ' => 'y',
		 
		// Latin symbols
		'©' => '(c)',
		 
		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
		 
		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
		 
		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',
		 
		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
		 
		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
		'Ž' => 'Z',
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z',
		 
		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
		'Ż' => 'Z',
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',
		
		//Arabic
		"ا"=>"a", "أ"=>"a", "آ"=>"a", "إ"=>"e", "ب"=>"b", "ت"=>"t", "ث"=>"th", "ج"=>"j",
		"ح"=>"h", "خ"=>"kh", "د"=>"d", "ذ"=>"d", "ر"=>"r", "ز"=>"z", "س"=>"s", "ش"=>"sh",
		"ص"=>"s", "ض"=>"d", "ط"=>"t", "ظ"=>"z", "ع"=>"'e", "غ"=>"gh", "ف"=>"f", "ق"=>"q",
		"ك"=>"k", "ل"=>"l", "م"=>"m", "ن"=>"n", "ه"=>"h", "و"=>"w", "ي"=>"y", "ى"=>"a",
		"ئ"=>"'e", "ء"=>"'",   
		"ؤ"=>"'e", "لا"=>"la", "ة"=>"h", "؟"=>"?", "!"=>"!", 
		"ـ"=>"", 
		"،"=>",", 
		"َ‎"=>"a", "ُ"=>"u", "ِ‎"=>"e", "ٌ"=>"un", "ً"=>"an", "ٍ"=>"en", "ّ"=>"",
		
		//persian
		"ا" => "a", "أ" => "a", "آ" => "a", "إ" => "e", "ب" => "b", "ت" => "t", "ث" => "th",
		"ج" => "j", "ح" => "h", "خ" => "kh", "د" => "d", "ذ" => "d", "ر" => "r", "ز" => "z",
		"س" => "s", "ش" => "sh", "ص" => "s", "ض" => "d", "ط" => "t", "ظ" => "z", "ع" => "'e",
		"غ" => "gh", "ف" => "f", "ق" => "q", "ك" => "k", "ل" => "l", "م" => "m", "ن" => "n",
		"ه" => "h", "و" => "w", "ي" => "y", "ى" => "a", "ئ" => "'e", "ء" => "'", 
		"ؤ" => "'e", "لا" => "la", "ک" => "ke", "پ" => "pe", "چ" => "che", "ژ" => "je", "گ" => "gu",
		"ی" => "a", "ٔ" => "", "ة" => "h", "؟" => "?", "!" => "!", 
		"ـ" => "", 
		"،" => ",", 
		"َ‎" => "a", "ُ" => "u", "ِ‎" => "e", "ٌ" => "un", "ً" => "an", "ٍ" => "en", "ّ" => "",
		 
		// Latvian
		'Ā'  =>  'A', 'Č'  =>  'C', 'Ē'  =>  'E', 'Ģ'  =>  'G', 'Ī'  =>  'i', 'Ķ'  =>  'k', 'Ļ'  =>  'L', 'Ņ'  =>  'N',
		'Š'  =>  'S', 'Ū'  =>  'u', 'Ž'  =>  'Z',
		'ā'  =>  'a', 'č'  =>  'c', 'ē'  =>  'e', 'ģ'  =>  'g', 'ī'  =>  'i', 'ķ'  =>  'k', 'ļ'  =>  'l', 'ņ'  =>  'n',
		'š'  =>  's', 'ū'  =>  'u', 'ž'  =>  'z'
		);
		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		// Transliterate characters to ASCII
		if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
		}
		
	public function install(){
			$this->load->model('setting/hb_seoimage');
			$this->model_setting_hb_seoimage->install();
			$data['success'] = 'This extension has been installed successfully';
			$this->response->redirect($this->url->link('extension/hb_seoimage', 'token=' . $this->session->data['token'], true));
		}
		
	public function uninstall(){
			$this->load->model('setting/hb_seoimage');
			$this->model_setting_hb_seoimage->uninstall();
			$data['success'] = 'This extension is uninstalled successfully';
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_seoimage')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

}
?>