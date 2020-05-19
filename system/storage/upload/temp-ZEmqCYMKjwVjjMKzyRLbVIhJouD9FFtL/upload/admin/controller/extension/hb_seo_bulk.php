<?php
class ControllerExtensionHbSeoBulk extends Controller {
	
	private $error = array(); 
	
	public function index() {  
	$data['extension_version'] =  '7.2';

		$this->load->language('extension/hb_seo_bulk');

		$this->document->setTitle($this->language->get('heading_title_seo'));

		$this->load->model('setting/setting');
		$this->load->model('setting/hb_seo_bulk');
		
		//check if seo is installed? If not install the extension
		if ($this->config->get('hb_seo_bulk_instalr') <> 1){
			$this->response->redirect($this->url->link('extension/hb_seo_bulk/install', 'token=' . $this->session->data['token'], true));
		}
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_seo', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/hb_seo_bulk', 'token=' . $this->session->data['token'], true));
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		
		$text_strings = array(
				'heading_title_seo',
				'text_header',
				'text_header_product','text_header_category','text_header_brand','text_header_information',
				'col_process_name','col_process_guide','col_process_parameter','col_process_action','col_automation',
				'text_shortcodes',
				'text_shortcodes_list',
				'button_save',
				'button_cancel',
				'col_title',
				'col_h1',
				'col_h2',
				'col_img_alt',
				'col_meta_desc',
				'col_meta_key',
				'btn_generate',
				'btn_clear'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		//guide
		for ($i = 1;$i<21;$i++){
		  	$data['guide'.$i] = $this->language->get('guide'.$i);
		}
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (!$this->config->get('hb_seo_bulk_auto')){
			$data['error_warning'] = 'SETUP IS INCOMPLETE. KINDLY SET ALL THE PARAMETERS PROPERLY AND CLICK ON SAVE BUTTON. DO NOT CLICK ON GENERATE BUTTON WITHOUT SAVING PARAMETERS.';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_seo'),
			'href'      => $this->url->link('extension/hb_seo_bulk', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_seo_bulk', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], true);
		$data['uninstall'] = $this->url->link('extension/hb_seo_bulk/uninstall', 'token=' . $this->session->data['token'], true);
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		$data['languages'] = $languages = $this->model_localisation_language->getLanguages();
		
	foreach ($languages as $language){
	 	$language_id = $language['language_id'];
		
		$data['all_product_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountRecords('product_description', $language_id);
		$data['p_title_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('product_description','meta_title', $language_id);
		$data['p_h1_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('product_description','custom_h1', $language_id);
		$data['p_h2_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('product_description','custom_h2', $language_id);
		$data['p_imgalt_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('product_description','img_alt', $language_id);
		$data['p_desc_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('product_description','meta_description', $language_id);
		$data['p_key_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('product_description','meta_keyword', $language_id);
		
  		$data['all_cat_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountRecords('category_description', $language_id);
		$data['c_title_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('category_description','meta_title', $language_id);
		$data['c_h1_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('category_description','custom_h1', $language_id);
		$data['c_h2_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('category_description','custom_h2', $language_id);
		$data['c_imgalt_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('category_description','img_alt', $language_id);
		$data['c_desc_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('category_description','meta_description', $language_id);
		$data['c_key_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('category_description','meta_keyword', $language_id);
				
		$data['all_info_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountRecords('information_description',$language_id);
		$data['i_title_count'.$language_id] = $this->model_setting_hb_seo_bulk->getCountNullRecords('information_description', 'meta_title',$language_id);
		$data['i_desc_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('information_description','meta_description',$language_id);
		$data['i_key_count'.$language_id] =  $this->model_setting_hb_seo_bulk->getCountNullRecords('information_description','meta_keyword',$language_id);
		//configs
		$data['hb_seo_prod_title_param_'.$language_id] = $this->config->get('hb_seo_prod_title_param_'.$language['language_id']);
		$data['hb_seo_prod_h1_param_'.$language_id] = $this->config->get('hb_seo_prod_h1_param_'.$language['language_id']);
		$data['hb_seo_prod_h2_param_'.$language_id] = $this->config->get('hb_seo_prod_h2_param_'.$language['language_id']);
		$data['hb_seo_prod_alt_param_'.$language_id] = $this->config->get('hb_seo_prod_alt_param_'.$language['language_id']);
		$data['hb_seo_prod_mdesc_param_'.$language_id] = $this->config->get('hb_seo_prod_mdesc_param_'.$language['language_id']);
		$data['hb_seo_prod_mkey_param_'.$language_id] = $this->config->get('hb_seo_prod_mkey_param_'.$language['language_id']);
		
		$data['hb_seo_cat_title_param_'.$language_id] = $this->config->get('hb_seo_cat_title_param_'.$language['language_id']);
		$data['hb_seo_cat_h1_param_'.$language_id] = $this->config->get('hb_seo_cat_h1_param_'.$language['language_id']);
		$data['hb_seo_cat_h2_param_'.$language_id] = $this->config->get('hb_seo_cat_h2_param_'.$language['language_id']);
		$data['hb_seo_cat_alt_param_'.$language_id] = $this->config->get('hb_seo_cat_alt_param_'.$language['language_id']);
		$data['hb_seo_cat_mdesc_param_'.$language_id] = $this->config->get('hb_seo_cat_mdesc_param_'.$language['language_id']);
		$data['hb_seo_cat_mkey_param_'.$language_id] = $this->config->get('hb_seo_cat_mkey_param_'.$language['language_id']);

		$data['hb_seo_info_title_param_'.$language_id] = $this->config->get('hb_seo_info_title_param_'.$language['language_id']);
		$data['hb_seo_info_mdesc_param_'.$language_id] = $this->config->get('hb_seo_info_mdesc_param_'.$language['language_id']);
		$data['hb_seo_info_mkey_param_'.$language_id] = $this->config->get('hb_seo_info_mkey_param_'.$language['language_id']);

	}		
	
	  	$data['all_brand_count'] =  $this->model_setting_hb_seo_bulk->getCountRecordsNL('manufacturer');
		$data['b_title_count'] = $this->model_setting_hb_seo_bulk->getCountNullRecordsNL('manufacturer', 'custom_title');
		$data['b_h1_count'] = $this->model_setting_hb_seo_bulk->getCountNullRecordsNL('manufacturer', 'custom_h1');
		$data['b_h2_count'] = $this->model_setting_hb_seo_bulk->getCountNullRecordsNL('manufacturer', 'custom_h2');
		$data['b_desc_count'] =  $this->model_setting_hb_seo_bulk->getCountNullRecordsNL('manufacturer','brand_meta_description');
		$data['b_key_count'] =  $this->model_setting_hb_seo_bulk->getCountNullRecordsNL('manufacturer','brand_meta_keyword');

		$data['hb_seo_brand_title_param'] = $this->config->get('hb_seo_brand_title_param');
		$data['hb_seo_brand_h1_param'] = $this->config->get('hb_seo_brand_h1_param');
		$data['hb_seo_brand_h2_param'] = $this->config->get('hb_seo_brand_h2_param');
		$data['hb_seo_brand_mdesc_param'] = $this->config->get('hb_seo_brand_mdesc_param');
		$data['hb_seo_brand_mkey_param'] = $this->config->get('hb_seo_brand_mkey_param');
		
		$data['default_language'] = $this->defaultLanguageid();
		
		$data['hb_seo_bulk_auto'] = $this->config->get('hb_seo_bulk_auto');
		
		$data['hb_seo_bulk_passkey'] = $this->config->get('hb_seo_bulk_passkey');
		$data['hb_seo_bulk_ppb'] = $this->config->get('hb_seo_bulk_ppb');
		$data['hb_seo_bulk_time'] = $this->config->get('hb_seo_bulk_time');
		$data['hb_seo_bulk_auto_lang'] = $this->config->get('hb_seo_bulk_auto_lang');
		
		$data['hb_seo_bulk_auto_pmt'] = $this->config->get('hb_seo_bulk_auto_pmt');
		$data['hb_seo_bulk_auto_ph1'] = $this->config->get('hb_seo_bulk_auto_ph1');
		$data['hb_seo_bulk_auto_ph2'] = $this->config->get('hb_seo_bulk_auto_ph2');
		$data['hb_seo_bulk_auto_pia'] = $this->config->get('hb_seo_bulk_auto_pia');
		$data['hb_seo_bulk_auto_pmd'] = $this->config->get('hb_seo_bulk_auto_pmd');
		$data['hb_seo_bulk_auto_pmk'] = $this->config->get('hb_seo_bulk_auto_pmk');
		
		$data['hb_seo_bulk_auto_cmt'] = $this->config->get('hb_seo_bulk_auto_cmt');
		$data['hb_seo_bulk_auto_ch1'] = $this->config->get('hb_seo_bulk_auto_ch1');
		$data['hb_seo_bulk_auto_ch2'] = $this->config->get('hb_seo_bulk_auto_ch2');
		$data['hb_seo_bulk_auto_cia'] = $this->config->get('hb_seo_bulk_auto_cia');
		$data['hb_seo_bulk_auto_cmd'] = $this->config->get('hb_seo_bulk_auto_cmd');
		$data['hb_seo_bulk_auto_cmk'] = $this->config->get('hb_seo_bulk_auto_cmk');
		
		$data['hb_seo_bulk_auto_bmt'] = $this->config->get('hb_seo_bulk_auto_bmt');
		$data['hb_seo_bulk_auto_bh1'] = $this->config->get('hb_seo_bulk_auto_bh1');
		$data['hb_seo_bulk_auto_bh2'] = $this->config->get('hb_seo_bulk_auto_bh2');
		$data['hb_seo_bulk_auto_bmd'] = $this->config->get('hb_seo_bulk_auto_bmd');
		$data['hb_seo_bulk_auto_bmk'] = $this->config->get('hb_seo_bulk_auto_bmk');
		
		$data['hb_seo_bulk_auto_imt'] = $this->config->get('hb_seo_bulk_auto_imt');
		$data['hb_seo_bulk_auto_imd'] = $this->config->get('hb_seo_bulk_auto_imd');
		$data['hb_seo_bulk_auto_imk'] = $this->config->get('hb_seo_bulk_auto_imk');
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_seo_bulk', $data));

	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_seo_bulk')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	
	
	
	////////////////////////
	public function defaultLanguageid(){
		$this->load->model('setting/hb_seo_bulk');
		return $this->model_setting_hb_seo_bulk->defaultLanguage();
	}
	
	
		public function install(){
			$this->load->model('setting/hb_seo_bulk');
			$this->model_setting_hb_seo_bulk->install();
			$data['success'] = 'This extension has been installed successfully';
			$this->response->redirect($this->url->link('extension/hb_seo_bulk', 'token=' . $this->session->data['token'], true));
		}
		
		public function uninstall(){
				$this->load->model('setting/hb_seo_bulk');
				$this->model_setting_hb_seo_bulk->uninstall();
				$data['success'] = 'This extension is uninstalled successfully';
				$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		}
			
	//*******************************************************

}
?>