<?php
class ControllerExtensionHbSearchtag extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$data['extension_version'] = '1.1';

		$this->load->language('extension/hb_searchtag');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_searchtag', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/hb_searchtag', 'token=' . $this->session->data['token'], true));
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		
		$text_strings = array(
				'heading_title',
				'text_search',
				'text_tag',
				'text_meta_title',
				'text_meta_description',
				'text_meta_keyword',
				'text_mt_shortcodes',
				'text_md_shortcodes',
				'text_mk_shortcodes',
				'text_success',
				'button_save',
				'button_cancel'
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
			'href'      => $this->url->link('extension/hb_searchtag', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_searchtag', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		$data['languages'] = $languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language){
			$language_id = $language['language_id'];
			$data['hb_searchtag_smt_'.$language_id] = $this->config->get('hb_searchtag_smt_'.$language['language_id']);
			$data['hb_searchtag_smd_'.$language_id] = $this->config->get('hb_searchtag_smd_'.$language['language_id']);
			$data['hb_searchtag_smk_'.$language_id] = $this->config->get('hb_searchtag_smk_'.$language['language_id']);
			$data['hb_searchtag_tmt_'.$language_id] = $this->config->get('hb_searchtag_tmt_'.$language['language_id']);
			$data['hb_searchtag_tmd_'.$language_id] = $this->config->get('hb_searchtag_tmd_'.$language['language_id']);
			$data['hb_searchtag_tmk_'.$language_id] = $this->config->get('hb_searchtag_tmk_'.$language['language_id']);
		}		
						
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_searchtag', $data));

	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_searchtag')) {
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