<?php
class ControllerExtensionHbSitemap extends Controller {
	
	private $error = array(); 
	
	public function index() {  
		$data['extension_version'] =  '4.4'; 

		$this->load->language('extension/hb_sitemap');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('setting/hb_sitemap');
		
		if ($this->config->get('hb_sitemap_installed') <> 1){
			$this->response->redirect($this->url->link('extension/hb_sitemap/install', 'token=' . $this->session->data['token'], true));
		}
		
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_sitemap', $this->request->post);	
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], true));
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
				'tab_sitemap',
				'tab_customlist',
				'tab_seoalias',
				'tab_setting',
				'header_product',
				'header_others',
				'header_sitemaps',
				'header_allstore',
				'col_batch_id',
				'col_batch_range',
				'col_batch_status',
				'col_batch_tstatus',
				'col_batch_date',
				'col_header',
				'col_priority',
				'col_freq',
				'col_product',
				'col_category',
				'col_brand',
				'col_info',
				'col_tag',
				'col_action',
				'text_no_records',
				'text_batch_generated',
				'text_category_map',
				'text_brand_map',
				'text_info_map',
				'text_tag_map',
				'text_index_map',
				'text_custom_map',  
				'text_link_count',
				'text_automatic',
				'btn_batch',
				'btn_add',
				'btn_dir',
				'btn_remove',
				'btn_auto_product','btn_auto_tag','btn_auto_category','btn_auto_brand','btn_auto_info','btn_auto_custom','btn_auto_index',
				'btn_generate',
				'btn_clear',
				'btn_clear_batch'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		$this->load->model('setting/store');
		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG
		);

		$data['store_total'] = $store_total = $this->model_setting_store->getTotalStores();

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url']
			);
		}
		
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (!$this->config->get('hb_sitemap_passkey')){
			$blog_link = 'http://www.huntbee.com/opencart-blog/opencart-seo-google-xml-sitemap?utm_source='.HTTP_CATALOG.'&utm_medium=installed_extension_16836&utm_campaign=XML%20Sitemap%20blog';
			$data['error_warning'] = 'SETTINGS NOT SAVED YET. KINDLY CHOOSE AND SAVE THE SETTINGS BEFORE GENERATING SITEMAPS! <hr> <a href="'.$blog_link.'" target="_blank">Read about XML Sitemap & How to use it effectively...</a>';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], true);
		$data['uninstall'] = $this->url->link('extension/hb_sitemap/uninstall', 'token=' . $this->session->data['token'], true);
		
		$data['token'] = $this->session->data['token'];
		
		foreach ($data['stores'] as $result){
	 		$store_id = $result['store_id'];	
			$data['all_batches'.$store_id] =  $this->model_setting_hb_sitemap->getbatch($store_id);
			$data['all_links'.$store_id] =  $this->model_setting_hb_sitemap->getlink($store_id);

		}
		
		$data['all_batches'] =  $this->model_setting_hb_sitemap->getallbatch();
		
		$data['hb_sitemap_max_entries'] = $this->config->get('hb_sitemap_max_entries');
		
		$data['hb_sitemap_product_priority'] = $this->config->get('hb_sitemap_product_priority');
		$data['hb_sitemap_category_priority'] = $this->config->get('hb_sitemap_category_priority');
		$data['hb_sitemap_brand_priority'] = $this->config->get('hb_sitemap_brand_priority');
		$data['hb_sitemap_info_priority'] = $this->config->get('hb_sitemap_info_priority');
		$data['hb_sitemap_tag_priority'] = $this->config->get('hb_sitemap_tag_priority');
		
		$data['hb_sitemap_product_freq'] = $this->config->get('hb_sitemap_product_freq');
		$data['hb_sitemap_category_freq'] = $this->config->get('hb_sitemap_category_freq');
		$data['hb_sitemap_brand_freq'] = $this->config->get('hb_sitemap_brand_freq');
		$data['hb_sitemap_info_freq'] = $this->config->get('hb_sitemap_info_freq');
		$data['hb_sitemap_tag_freq'] = $this->config->get('hb_sitemap_tag_freq');
		$data['hb_sitemap_automatic'] = $this->config->get('hb_sitemap_automatic');
		
		$data['hb_sitemap_passkey'] = $this->config->get('hb_sitemap_passkey');
		$data['hb_sitemap_time'] = $this->config->get('hb_sitemap_time');
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_sitemap', $data));

	}
		
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_sitemap')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function stores(){
		$this->load->model('setting/store');
		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG
		);

		$store_total = $this->model_setting_store->getTotalStores();

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url']
			);
		}
		
		return $data['stores'];

	}
	
	
	public function getstoreurl($store_id){
		if ($store_id == 0){
			return $url = HTTPS_CATALOG;
		}else{
			$query = $this->db->query("SELECT url FROM `" . DB_PREFIX . "store` WHERE store_id = $store_id LIMIT 1");
			return $url = $query->row['url'];
		}	
	}
	
	public function resetbatch(){
			$store_id = $_POST['store_id'];
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE store_id = $store_id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Batch Records Deleted!</div>';
			$this->response->setOutput(json_encode($json));	
	}
	
	public function resetproductbatch(){
			$id = $_POST['id'];
			$column = $_POST['column'];
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_sitemap_batch` SET `".$column."` = 0 WHERE id = $id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Reset Successful </div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function resetsitemapdir(){
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_batch`");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemaps`");
			$files = glob('../hbsitemaps/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}	
			$results = $this->stores();
			foreach ($results as $result){
				$store_id = $result['store_id'];
				$store_id = ($store_id == 0)? '' : $store_id;
				$indexfile = '../sitemap_index'.$store_id.'.xml';
				if(is_file($indexfile))
					unlink($indexfile); // delete file
			}
			
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Sitemap Directory Cleared!</div>';
		$this->response->setOutput(json_encode($json));	
	}

		
		public function addlink(){
			$store_id = $_POST['store_id'];
			$loc = $_POST['loc'];
			$freq = $_POST['freq'];
			$priority = $_POST['priority'];
			$counts = $this->db->query("SELECT count(*) as count FROM  `" . DB_PREFIX . "hb_sitemap_custom` WHERE `loc` = '".$loc."' and store_id = $store_id");
			if ($counts->row['count'] == 0){
				$this->db->query("INSERT INTO  `" . DB_PREFIX . "hb_sitemap_custom` (`loc`,`freq`,`priority`,`store_id`) VALUES ('".$this->db->escape($loc)."', '".$freq."', '".$priority."', '".$store_id."')");
			}
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Link Added Successfully. Reload the page to see changes.</div>';
			$this->response->setOutput(json_encode($json));		
		}
		
		public function removelink(){
			$id = $_POST['id'];
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_custom` WHERE id = $id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Link has been Removed!</div>';
		    $this->response->setOutput(json_encode($json));	
		}

		
		public function install(){
			$this->load->model('setting/hb_sitemap');
			$this->model_setting_hb_sitemap->install();
			$data['success'] = 'This extension has been installed successfully';
			$this->response->redirect($this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], true));
		}
		
		public function uninstall(){
				$this->load->model('setting/hb_sitemap');
				$this->model_setting_hb_sitemap->uninstall();
				$data['success'] = 'This extension is uninstalled successfully';
				$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		}
		
	
	public function loadsitemapfiles() {
		$data['storeid'] = $store_id = $this->request->get['store_id'];
		$data['store_url'] = $this->getstoreurl($store_id);
		$data['tpl_store_id'] =  ($store_id == 0)? '':$store_id;

		$this->language->load('extension/hb_sitemap');
		$this->load->model('setting/hb_sitemap');
		$data['text_sitemap_not_found'] = $this->language->get('text_sitemap_not_found');
		
		$text_strings = array(
				'header_sitemaps',
				'col_batch_id',
				'col_batch_range',
				'col_batch_status',
				'col_batch_tstatus',
				'col_batch_date',
				'text_no_records',
				'text_batch_generated',
				'text_category_map',
				'text_brand_map',
				'text_info_map',
				'text_tag_map',
				'text_index_map',
				'text_custom_map', 
				'btn_batch',
				'btn_generate',
				'btn_clear',
				'btn_clear_batch'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		$this->load->model('setting/store');
		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG
		);

		$store_total = $this->model_setting_store->getTotalStores();

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url']
			);
		}
		
		foreach ($data['stores'] as $result){
	 		$store_id = $result['store_id'];	
			$data['all_batches'.$store_id] =  $this->model_setting_hb_sitemap->getbatch($store_id);
			$data['all_links'.$store_id] =  $this->model_setting_hb_sitemap->getlink($store_id);

		}
		
		$data['all_batches'] =  $this->model_setting_hb_sitemap->getallbatch();

		$this->response->setOutput($this->load->view('extension/hbsitemapfiles', $data));
	}
	
	//seo url alias
	
	public function loadseourlholder() {
		$this->language->load('extension/hb_sitemap');
		$this->load->model('setting/hb_sitemap');
		
		$text_strings = array(
				'text_product_seo',
				'text_category_seo',
				'text_information_seo',
				'text_brand_seo',
				'btn_generate_seo',
				'btn_clear',
				'text_available',
				'text_total'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		$data['product_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('product_id');
		$data['category_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('category_id');
		$data['information_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('information_id');
		$data['brand_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('manufacturer_id');
		
		$language_id = $this->model_setting_hb_sitemap->defaultLanguage();
		$data['product_total'] =  $this->model_setting_hb_sitemap->getCountRecords('product_description', $language_id);
		$data['category_total'] =  $this->model_setting_hb_sitemap->getCountRecords('category_description', $language_id);
		$data['information_total'] =  $this->model_setting_hb_sitemap->getCountRecords('information_description', $language_id);
		$data['brand_total'] =  $this->model_setting_hb_sitemap->getCountRecordsNL('manufacturer');
		
		$this->response->setOutput($this->load->view('extension/hbseourlholder', $data));
	}

}
?>