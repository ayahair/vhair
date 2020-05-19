<?php
class ControllerSeoHbSeo extends Controller {
	private function authenticate() {
		$passkey = (isset($_GET['passkey']))? $_GET['passkey'] : '';
		$db_passkey = $this->config->get('hb_seo_bulk_passkey');
		if ($passkey == $db_passkey) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	public function estimatebatch(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$product_count = $this->db->query("SELECT count(*) as count FROM  `" . DB_PREFIX . "product` ORDER BY product_id ASC ");
		$product_count = $product_count->row['count'];
		
		$no_of_product = $this->config->get('hb_seo_bulk_ppb');//number of product links per page
		
		$number_of_batch = ceil($product_count / $no_of_product);
		$offset = 0;
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_seobulk_batch` WHERE `batch_id` > $number_of_batch");
		
		for ($t = 1; $t<=$number_of_batch; $t++){
			
			$ranges = $this->db->query("SELECT min(c.product_id) as min_id , max(c.product_id) as max_id FROM (SELECT a.product_id FROM " . DB_PREFIX . "product a ORDER BY a.product_id ASC LIMIT $no_of_product OFFSET $offset) c");
			$min_id = (isset($ranges->row['min_id']))? $ranges->row['min_id'] :'0';
			$max_id = (isset($ranges->row['max_id']))? $ranges->row['max_id'] :'0';
			
			$range_check = $this->db->query("SELECT count(*) as range_row_count FROM `" . DB_PREFIX . "hb_seobulk_batch` WHERE min_range = $min_id and max_range = $max_id and batch_id = $t");
			$range_row = $range_check->row['range_row_count'];
			if ($range_row == 0){
				$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_seobulk_batch` WHERE `batch_id` = $t");	
				
				$this->load->model('seo/hb_seo');
				$languages = $this->model_seo_hb_seo->getLanguages();
				foreach ($languages as $language){
					$language_id = $language['language_id'];
					$this->db->query("INSERT INTO `" . DB_PREFIX . "hb_seobulk_batch`(`batch_id`, `min_range`, `max_range`,`language_id`) VALUES ('".$t."','".$min_id."','".$max_id."','".$language_id."')");
				}
			}
			
			$offset = $offset + $no_of_product;
			
		} //foreach ends 
		
		echo '<br>Batch Estimated Successfully';
	}
	
	public function resetbatch(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_seobulk_batch`");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Batch Records Deleted!</div>';
			$this->response->setOutput(json_encode($json));	
	}
	
	public function checkdataforbatches(){
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hb_seobulk_batch` WHERE status = 0 ORDER BY batch_id");
		$records = $query->rows;
		
		foreach ($records as $record){
			$batch_id = $record['batch_id'];
			$min_range = $record['min_range'];
			$max_range = $record['max_range'];
			$language_id = $record['language_id'];
			
			$columns[] = array('productcolumn' => 'meta_title', 'batchcolumn' => 'meta_title');
			$columns[] = array('productcolumn' => 'custom_h1', 'batchcolumn' => 'h1');
			$columns[] = array('productcolumn' => 'custom_h2', 'batchcolumn' => 'h2');
			$columns[] = array('productcolumn' => 'img_alt', 'batchcolumn' => 'img_alt');
			$columns[] = array('productcolumn' => 'meta_description', 'batchcolumn' => 'meta_desc');
			$columns[] = array('productcolumn' => 'meta_keyword', 'batchcolumn' => 'meta_key');
			foreach ($columns as $column){
				$this->checkcolumn($column['productcolumn'],$column['batchcolumn'], $batch_id, $min_range, $max_range, $language_id);
			}
		}
		$this->updatebatchstatus();
		echo '<br>Data check for the batches completed successfully<br>';		
	
	}
	
	public function checkcolumn($column, $batchcolumn, $batch_id, $min_range, $max_range, $language_id){
		$query = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "product_description` where `".$column."` = '' or `".$column."` IS NULL and product_id >= $min_range and product_id >= $max_range and `language_id` = $language_id");
		$check = $query->row['count'];
		if ($check == 0){
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `".$batchcolumn."` = 1 WHERE batch_id = $batch_id and language_id = $language_id");
			//echo '<br>NO EMPTY VALUES FOUND FOR COLUMN '.$batchcolumn.' IN BATCH '.$batch_id.' AND LANGUAGE ID '.$language_id; //dev
		}else{
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `".$batchcolumn."` = 0 WHERE batch_id = $batch_id and language_id = $language_id");
			//echo '<br>EMPTY VALUES FOUND FOR COLUMN '.$batchcolumn.' IN BATCH '.$batch_id.' AND LANGUAGE ID '.$language_id; //dev
		}
	}
	
	public function updatebatchstatus(){
		$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `status` = 1 WHERE `meta_title` = 1 and `h1` = 1 and `h2` = 1 and `img_alt` = 1 and `meta_desc` = 1 and `meta_key` = 1");
		$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `status` = 0 WHERE `meta_title` = 0 or `h1` = 0 or `h2` = 0 or `img_alt` = 0 or `meta_desc` = 0 or `meta_key` = 0");
	}
	
	public function productcron(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		
		$this->estimatebatch();
		$this->checkdataforbatches();
		
		$time_start = microtime(true);
		
		$set_language = $this->config->get('hb_seo_bulk_auto_lang'); //get the value from the settings
		$generate_metatitle = $this->config->get('hb_seo_bulk_auto_pmt');
		$generate_h1 = $this->config->get('hb_seo_bulk_auto_ph1');
		$generate_h2 = $this->config->get('hb_seo_bulk_auto_ph2');
		$generate_imgalt = $this->config->get('hb_seo_bulk_auto_pia');
		$generate_md = $this->config->get('hb_seo_bulk_auto_pmd');
		$generate_mk = $this->config->get('hb_seo_bulk_auto_pmk');
		
		$timelimit = $this->config->get('hb_seo_bulk_time');
		//GET BATCHES (language id check) FOR WHICH OPERATION NEEDS TO BE DONE
		$sql = "SELECT * FROM `" . DB_PREFIX . "hb_seobulk_batch` WHERE status = 0";
		if ($set_language <> 'all' ){
			$sql.= " and `language_id` = '".$set_language."'";
		}
		$sql .= " ORDER BY batch_id";
		$query = $this->db->query($sql);
		$batches = $query->rows;
		
		foreach ($batches as $batch){
			if (microtime(true)-$time_start > $timelimit){ //in seconds. recommended value is between 20 to 29
				echo 'Script Execution time Exceeded. Stopping the Script.';
				break;
			}else{
			$id = $batch['id'];
			$batch_id = $batch['batch_id'];
			$min_range = $batch['min_range'];
			$max_range = $batch['max_range'];
			$language_id = $batch['language_id'];
			$title = $batch['meta_title'];
			$h1 = $batch['h1'];
			$h2 = $batch['h2'];
			$img_alt = $batch['img_alt'];
			$md = $batch['meta_desc'];
			$mk = $batch['meta_key'];
			
			//is user wants to generate meta title
			if (($generate_metatitle == 1) and ($title == 0)){
				//generate for this batch
				$parameter = $this->config->get('hb_seo_prod_title_param_'.$language_id);
				$this->generateProcess($parameter,'product',$language_id,'meta_title',$min_range,$max_range);
				$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `meta_title` = 1 WHERE id = $id");
				$this->updatebatchstatus();
				echo '<br>Product Meta Title Generated Successfully for batch '.$batch_id.' and language id '.$language_id;
			}
			
			if (($generate_h1 == 1) and ($h1 == 0)){
				//generate for this batch
				$parameter = $this->config->get('hb_seo_prod_h1_param_'.$language_id);
				$this->generateProcess($parameter,'product',$language_id,'custom_h1',$min_range,$max_range);
				$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `h1` = 1 WHERE id = $id");
				$this->updatebatchstatus();
				echo '<br>Product H1 Tag Generated Successfully for batch '.$batch_id.' and language id '.$language_id;
			}
			
			if (($generate_h2 == 1) and ($h2 == 0)){
				//generate for this batch
				$parameter = $this->config->get('hb_seo_prod_h2_param_'.$language_id);
				$this->generateProcess($parameter,'product',$language_id,'custom_h2',$min_range,$max_range);
				$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `h2` = 1 WHERE id = $id");
				$this->updatebatchstatus();
				echo '<br>Product H2 Tag Generated Successfully for batch '.$batch_id.' and language id '.$language_id;
			}
			
			if (($generate_imgalt == 1) and ($img_alt == 0)){
				//generate for this batch
				$parameter = $this->config->get('hb_seo_prod_alt_param_'.$language_id);
				$this->generateProcess($parameter,'product',$language_id,'img_alt',$min_range,$max_range);
				$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `img_alt` = 1 WHERE id = $id");
				$this->updatebatchstatus();
				echo '<br>Product Image Alt Tag Generated Successfully for batch '.$batch_id.' and language id '.$language_id;
			}
			
			if (($generate_md == 1) and ($md == 0)){
				//generate for this batch
				$parameter = $this->config->get('hb_seo_prod_mdesc_param_'.$language_id);
				$this->generateProcess($parameter,'product',$language_id,'meta_description',$min_range,$max_range);
				$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `meta_desc` = 1 WHERE id = $id");
				$this->updatebatchstatus();
				echo '<br>Product Meta-Description Tag Generated Successfully for batch '.$batch_id.' and language id '.$language_id;
			}
			
			if (($generate_mk == 1) and ($mk == 0)){
				//generate for this batch
				$parameter = $this->config->get('hb_seo_prod_mkey_param_'.$language_id);
				$this->generateProcess($parameter,'product',$language_id,'meta_keyword',$min_range,$max_range);
				$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `meta_key` = 1 WHERE id = $id");
				$this->updatebatchstatus();
				echo '<br>Product Meta-Keyword Generated Successfully for batch '.$batch_id.' and language id '.$language_id;
			}
		} //time check end
		} //foreach end
		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start);
		echo '<br>Product Cron exectued in '.$execution_time.' seconds';

	}
	//*****************************************************************************
	
	public function miccron(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$time_start = microtime(true);
		$this->autocategoryseo();
		$this->autoinfoseo();
		$this->autobrandseo();
		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start);
		echo '<br>Category Page SEO, Information Page SEO, Manufacturer Page SEO Cron exectued in '.$execution_time.' seconds';
	}
	
	//*****************************************************************************
	
	public function autocategoryseo(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$set_language = $this->config->get('hb_seo_bulk_auto_lang'); //get the value from the settings
		$generate_metatitle = 1;
		$generate_h1 = 1;
		$generate_h2 = 1;
		$generate_imgalt = 1;
		$generate_md = 1;
		$generate_mk = 1;
		
		if ($set_language == 'all' ){
			$this->load->model('seo/hb_seo');
			$languages = $this->model_seo_hb_seo->getLanguages();
		}else{
			$languages[] = array('language_id' => $set_language);
		}
		
		foreach ($languages as $language){
			$language_id = $language['language_id'];
			
			if ($generate_metatitle == 1){
				$parameter = $this->config->get('hb_seo_cat_title_param_'.$language_id);
				$this->generateProcess($parameter,'category',$language_id,'meta_title',0,0);
			}
			
			if ($generate_h1 == 1){
				$parameter = $this->config->get('hb_seo_cat_h1_param_'.$language_id);
				$this->generateProcess($parameter,'category',$language_id,'custom_h1',0,0);
			}
			
			if ($generate_h2 == 1){
				$parameter = $this->config->get('hb_seo_cat_h2_param_'.$language_id);
				$this->generateProcess($parameter,'category',$language_id,'custom_h2',0,0);
			}
			if ($generate_imgalt == 1){
				$parameter = $this->config->get('hb_seo_cat_alt_param_'.$language_id);
				$this->generateProcess($parameter,'category',$language_id,'img_alt',0,0);
			}
			if ($generate_md == 1){
				$parameter = $this->config->get('hb_seo_cat_mdesc_param_'.$language_id);
				$this->generateProcess($parameter,'category',$language_id,'meta_description',0,0);
			}
			if ($generate_mk == 1){
				$parameter = $this->config->get('hb_seo_cat_mkey_param_'.$language_id);
				$this->generateProcess($parameter,'category',$language_id,'meta_keyword',0,0);
			}
		}	
	}
	
	public function autoinfoseo(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$set_language = $this->config->get('hb_seo_bulk_auto_lang');//get the value from the settings
		$generate_metatitle = 1;
		$generate_md = 1;
		$generate_mk = 1;
		
		if ($set_language == 'all' ){
			$this->load->model('seo/hb_seo');
			$languages = $this->model_seo_hb_seo->getLanguages();
		}else{
			$languages[] = array('language_id'=> $set_language);
		}
		
		foreach ($languages as $language){
			$language_id = $language['language_id'];
			
			if ($generate_metatitle == 1){
				$parameter = $this->config->get('hb_seo_info_title_param_'.$language_id);
				$this->generateProcess($parameter,'information',$language_id,'meta_title',0,0);
			}
	
			if ($generate_md == 1){
				$parameter = $this->config->get('hb_seo_info_mdesc_param_'.$language_id);
				$this->generateProcess($parameter,'information',$language_id,'meta_description',0,0);
			}
			
			if ($generate_mk == 1){
				$parameter = $this->config->get('hb_seo_info_mkey_param_'.$language_id);
				$this->generateProcess($parameter,'information',$language_id,'meta_keyword',0,0);
			}
		}
	}
	
	public function autobrandseo(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$generate_metatitle = 1;
		$generate_h1 = 1;
		$generate_h2 = 1;
		$generate_md = 1;
		$generate_mk = 1;
		
		$language_id = $this->defaultLanguageid();
		if ($generate_metatitle == 1){
			$parameter = $this->config->get('hb_seo_brand_title_param');
			$this->generateProcess($parameter,'brand',$language_id,'custom_title',0,0);
		}
		
		if ($generate_h1 == 1){
			$parameter = $this->config->get('hb_seo_brand_h1_param');
			$this->generateProcess($parameter,'brand',$language_id,'custom_h1',0,0);
		}
		
		if ($generate_h2 == 1){
			$parameter = $this->config->get('hb_seo_brand_h2_param');
			$this->generateProcess($parameter,'brand',$language_id,'custom_h2',0,0);
		}

		if ($generate_md == 1){
			$parameter = $this->config->get('hb_seo_brand_mdesc_param');
			$this->generateProcess($parameter,'brand',$language_id,'brand_meta_description',0,0);
		}
		
		if ($generate_mk == 1){
			$parameter = $this->config->get('hb_seo_brand_mkey_param');
			$this->generateProcess($parameter,'brand',$language_id,'brand_meta_keyword',0,0);
		}
	}
	
	
	//*****************************************************************************
	
	public function generateProductTitle(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] : $this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_prod_title_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'product',$language_id,'meta_title',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product Title Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Product title tags already generated. No empty title tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));	
	}
	public function generateProducth1(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_prod_h1_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'product',$language_id,'custom_h1',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product H1 Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Product H1 tags already eee generated. No empty h1 tag found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateProducth2(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_prod_h2_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'product',$language_id,'custom_h2',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product H2 Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Product h2 tags already generated. No empty h2 tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateProductimgalt(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_prod_alt_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'product',$language_id,'img_alt',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product Alt Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Product alt tags already generated. No empty alt tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateProductmdesc(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_prod_mdesc_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'product',$language_id,'meta_description',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product Meta-description Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Product Meta-description already generated. No empty Meta-description found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateProductmkey(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_prod_mkey_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'product',$language_id,'meta_keyword',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product Meta-keyword Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Product Meta-keyword already generated. No empty Meta-keyword found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	//// CATEGORY ////////////////
	public function generateCategoryTitle(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] : $this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_cat_title_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'category',$language_id,'meta_title',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category Title Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Category title tags already generated. No empty title tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));	
	}
	public function generateCategoryh1(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_cat_h1_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'category',$language_id,'custom_h1',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category H1 Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Category H1 tags already generated. No empty h1 tag found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateCategoryh2(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_cat_h2_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'category',$language_id,'custom_h2',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category H2 Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Category h2 tags already generated. No empty h2 tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateCategoryimgalt(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_cat_alt_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'category',$language_id,'img_alt',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category Alt Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Category alt tags already generated. No empty alt tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateCategorymdesc(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_cat_mdesc_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'category',$language_id,'meta_description',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category Meta-description Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Category Meta-description already generated. No empty Meta-description found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateCategorymkey(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_cat_mkey_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'category',$language_id,'meta_keyword',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category Meta-keyword Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Category Meta-keyword already generated. No empty Meta-keyword found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	////////////////////////
	
	//// BRAND  ////////////////
	public function generateBrandTitle(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] : $this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_brand_title_param');
		$gen = $this->generateProcess($parameter,'brand',$language_id,'custom_title',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Brand Title Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Brand title tags already generated. No empty title tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));	
	}
	public function generateBrandh1(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_brand_h1_param');
		$gen = $this->generateProcess($parameter,'brand',$language_id,'custom_h1',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Brand H1 Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Brand H1 tags already generated. No empty h1 tag found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateBrandh2(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_brand_h2_param');
		$gen = $this->generateProcess($parameter,'brand',$language_id,'custom_h2',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Brand H2 Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Brand h2 tags already generated. No empty h2 tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateBrandmdesc(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_brand_mdesc_param');
		$gen = $this->generateProcess($parameter,'brand',$language_id,'brand_meta_description',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Brand Meta-description Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Brand Meta-description already generated. No empty Meta-description found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateBrandmkey(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_brand_mkey_param');
		$gen = $this->generateProcess($parameter,'brand',$language_id,'brand_meta_keyword',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Brand Meta-keyword Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Brand Meta-keyword already generated. No empty Meta-keyword found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}	
	////////////////////////
	//// INFO ////////////////
	public function generateInfoTitle(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] : $this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_info_title_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'information',$language_id,'meta_title',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Information Page Title Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Information Page title tags already generated. No empty title tag found!</div>';
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	public function generateInfomdesc(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_info_mdesc_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'information',$language_id,'meta_description',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Information Page Meta-description Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Information Page Meta-description already generated. No empty Meta-description found!</div>';
		}	
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateInfomkey(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$parameter = $this->config->get('hb_seo_info_mkey_param_'.$language_id);
		$gen = $this->generateProcess($parameter,'information',$language_id,'meta_keyword',0,0);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Information Page Meta-keyword Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-thumbs-up"></i> Information Page Meta-keyword already generated. No empty Meta-keyword found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	
	////////////////////////
	public function defaultLanguageid(){
		$this->load->model('seo/hb_seo');
		return $this->model_seo_hb_seo->defaultLanguage();
	}
	
	public function clearseo(){
		if ($this->authenticate() == false){
			echo 'ACCESS RESTRICTED';
			exit;
		}
		$this->load->model('seo/hb_seo');
		$tablename = $_POST['table'];
		$columnname = $_POST['column'];
		$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
		$this->model_seo_hb_seo->clearSeo($tablename, $columnname, $language_id);
		if ($tablename == 'product_description'){
			switch ($columnname){
			case 'meta_title':
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `meta_title` = 0 WHERE language_id = $language_id");
			break;
			
			case 'meta_description':
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `meta_desc` = 0 WHERE language_id = $language_id");
			break;
			
			case 'meta_keyword':
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `meta_key` = 0 WHERE language_id = $language_id");
			break;
			
			case 'custom_h1':
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `h1` = 0 WHERE language_id = $language_id");
			break;
			
			case 'custom_h2':
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `h2` = 0 WHERE language_id = $language_id");
			break;
			
			case 'img_alt':
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_seobulk_batch` SET `img_alt` = 0 WHERE language_id = $language_id");
			break;
			}
			$this->updatebatchstatus();
		}
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Cleared Successfully!</div>';
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateProcess($parameter,$pagetype,$language_id,$seotype,$min,$max){
		$this->load->model('seo/hb_seo');
		
		switch ($pagetype) {
		case "product":
			$records = $this->model_seo_hb_seo->productDataView($language_id,$min,$max);
			$count = 0;
			foreach ($records as $record){
				$product_id = $record['product_id'];
				$pname = $record['name'];
				$brand = $record['brand'];
				$model = $record['model'];
				$upc = $record['upc'];
				$image = $record['image'];
				$category = $this->model_seo_hb_seo->getCategoriesName($product_id,$language_id);
				if ($category){
					$category = $category;
				}else{
					$category = '';
				}
				
				if ($this->model_seo_hb_seo->getCheckSeo('product_description',$seotype, 'product_id', $product_id,$language_id) == 0){
					$processed_value = $this->replaceParameters($parameter,$pname,$brand,$model,$upc,$category,NULL,NULL,NULL);	
					$this->model_seo_hb_seo->insertSeo('product_description',$seotype, 'product_id',$product_id, $processed_value, $language_id);	
					$count = $count + 1;				
				}
			}//end of foreach loop
			
		break;
		
		case "category":
			$records = $this->model_seo_hb_seo->categoryDataView($language_id);
			$count = 0;
			foreach ($records as $record){
				$category_id = $record['category_id'];
				$cname = $record['name'];
				
						if ($this->model_seo_hb_seo->getCheckSeo('category_description',$seotype, 'category_id', $category_id,$language_id) == 0){
							$processed_value = $this->replaceParameters($parameter,NULL,NULL,NULL,NULL,NULL,$cname,NULL,NULL);	
							$this->model_seo_hb_seo->insertSeo('category_description',$seotype, 'category_id',$category_id, $processed_value, $language_id);	
							$count = $count + 1;				
						}
					
			}//end of foreach loop
			break;
		  case "brand":
			$records = $this->model_seo_hb_seo->getMViewBasic();
			$blang = $this->defaultLanguageid();
			$count = 0;
			foreach ($records as $record){
				$manufacturer_id = $record['manufacturer_id'];
				$bname = $record['name'];
				if ($this->model_seo_hb_seo->getCheckSeo('manufacturer',$seotype, 'manufacturer_id', $manufacturer_id, $blang) == 0){
					$processed_value = $this->replaceParameters($parameter,NULL,NULL,NULL,NULL,NULL,NULL,$bname,NULL);	
					$this->model_seo_hb_seo->insertSeo('manufacturer',$seotype, 'manufacturer_id',$manufacturer_id, $processed_value,$blang);	
					$count = $count + 1;				
				}
			}//end of foreach loop
			break;
		  case "information":
			$records = $this->model_seo_hb_seo->getIViewBasic($language_id);
			$count = 0;
			foreach ($records as $record){
				$information_id = $record['information_id'];
				$iname = $record['title'];
				
				if ($this->model_seo_hb_seo->getCheckSeo('information_description',$seotype, 'information_id', $information_id,$language_id) == 0){
					$processed_value = $this->replaceParameters($parameter,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$iname);	
					$this->model_seo_hb_seo->insertSeo('information_description',$seotype, 'information_id',$information_id, $processed_value, $language_id);	
					$count = $count + 1;				
				}
						
			}//end of foreach loop
			break;	
		  default:
			echo "Technical Error";
		}	
		return $count;	
	}
	
	public function replaceParameters($parameter,$pname,$brand,$model,$upc,$category,$cname,$bname,$iname){
		$parameter = str_replace("{p}",$pname,$parameter);
		$parameter = str_replace("{b}",$brand,$parameter);
		$parameter = str_replace("{c}",$category,$parameter);
		$parameter = str_replace("{m}",$model,$parameter);
		$parameter = str_replace("{u}",$upc,$parameter);
		$parameter = str_replace("{cn}",$cname,$parameter);
		$parameter = str_replace("{bn}",$bname,$parameter);
		$parameter = str_replace("{in}",$iname,$parameter);
		
		$parameter = str_replace("{xp}",$this->cleanwords($pname),$parameter);
		$parameter = str_replace("{xb}",$this->cleanwords($brand),$parameter);
		$parameter = str_replace("{xc}",$this->cleanwords($category),$parameter);
		$parameter = str_replace("{xm}",$this->cleanwords($model),$parameter);
		$parameter = str_replace("{xu}",$this->cleanwords($upc),$parameter);
		$parameter = str_replace("{xcn}",$this->cleanwords($cname),$parameter);
		$parameter = str_replace("{xbn}",$this->cleanwords($bname),$parameter);
		$parameter = str_replace("{xin}",$this->cleanwords($iname),$parameter);
		
		$parameter = htmlspecialchars_decode($parameter);
		$parameter = preg_replace('!\s+!', ' ',$parameter);
		$parameter = str_replace('()','',$parameter);
		$parameter = str_replace('( )','',$parameter);
		$parameter = str_replace('| |','|',$parameter);
		$parameter = str_replace('||','',$parameter);
		return $parameter;
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
		
		//*****************************************************************************
	
	
}
