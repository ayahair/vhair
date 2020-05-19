<?php
class ControllerExtensionModuleTrustSpotReviews extends Controller {	// >= opencart 2.3
//class ControllerModuleTrustSpotReviews extends Controller {					// < opencart 2.3	
					
	
	private $module_path = 'extension/module/trustspot_reviews';	// >= opencart 2.3
	//private $module_path = 'module/trustspot_reviews'; 						// < opencart 2.3
	
	private $module_path_template = 'extension/module/trustspot_reviews.tpl';		// >= opencart 2.3
	//private $module_path_template = 'module/trustspot_reviews.tpl';							// < opencart 2.3
	
	private $module_settings_prefix = 'trustspot_reviews_';
	
	
	private $oc_root_modules_path = 'extension/extension'; 	// >= opencart 2.3
	//private $oc_root_modules_path = 'extension/module'; 	// < opencart 2.3
	
	private $error = array();
	
	
	public function index() {
		$this->load->model('setting/setting');
		$this->load->language($this->module_path);
		
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->module_settings_prefix, $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			//$this->response->redirect($this->url->link($this->module_path, 'token=' . $this->session->data['token'], true));
			$this->response->redirect($this->url->link($this->module_path, 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['text_alert_allow_reviews'] = $this->language->get('text_alert_allow_reviews');
		
		
		//text_subsection
		$data['text_subsection_api_settings'] = $this->language->get('text_subsection_api_settings');
		$data['text_subsection_order_settings'] = $this->language->get('text_subsection_order_settings');
		$data['text_subsection_show_widgets_settings'] = $this->language->get('text_subsection_show_widgets_settings');
		$data['text_subsection_common_settings'] = $this->language->get('text_subsection_common_settings');
		
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_loading'] = $this->language->get('text_loading');

		//text entry		
		$data['entry_trustspot_reviews_email'] = $this->language->get('entry_trustspot_reviews_email');
		$data['entry_trustspot_reviews_api_key'] = $this->language->get('entry_trustspot_reviews_api_key');
		$data['entry_trustspot_reviews_api_secret'] = $this->language->get('entry_trustspot_reviews_api_secret');
		
		$data['entry_trustspot_reviews_order_status_id'] = $this->language->get('entry_trustspot_reviews_order_status_id');
		
		$data['entry_trustspot_reviews_show_mini_widget_on_product_page'] = $this->language->get('entry_trustspot_reviews_show_mini_widget_on_product_page');
		$data['entry_trustspot_reviews_show_mini_widget_on_category_page'] = $this->language->get('entry_trustspot_reviews_show_mini_widget_on_category_page');
		$data['entry_trustspot_reviews_show_large_widget_on_product_page'] = $this->language->get('entry_trustspot_reviews_show_large_widget_on_product_page');
		
		$data['entry_status'] = $this->language->get('entry_status');
		
		//text_help
		$data['help_trustspot_reviews_order_status_id'] = $this->language->get('help_trustspot_reviews_order_status_id');
		
		$data['help_trustspot_reviews_show_mini_widget_on_product_page'] = $this->language->get('help_trustspot_reviews_show_mini_widget_on_product_page');
		$data['help_trustspot_reviews_show_mini_widget_on_category_page'] = $this->language->get('help_trustspot_reviews_show_mini_widget_on_category_page');
		$data['help_trustspot_reviews_show_large_widget_on_product_page'] = $this->language->get('help_trustspot_reviews_show_large_widget_on_product_page');

		//buttons
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['button_verify_api'] = $this->language->get('button_verify_api');
		//buttons
		
		
		//Error processing...
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['trustspot_reviews_email'])) {
			$data['error_trustspot_reviews_email'] = $this->error['trustspot_reviews_email'];
		} else {
			$data['error_trustspot_reviews_email'] = '';
		}
		
		if (isset($this->error['trustspot_reviews_api_key'])) {
			$data['error_trustspot_reviews_api_key'] = $this->error['trustspot_reviews_api_key'];
		} else {
			$data['error_trustspot_reviews_api_key'] = '';
		}
		
		if (isset($this->error['trustspot_reviews_api_secret'])) {
			$data['error_trustspot_reviews_api_secret'] = $this->error['trustspot_reviews_api_secret'];
		} else {
			$data['error_trustspot_reviews_api_secret'] = '';
		}
		//Error processing...
		
		
		//breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link($this->oc_root_modules_path, 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->module_path, 'token=' . $this->session->data['token'], true)
		);
		//breadcrumbs


		//actions
		$data['action'] = $this->url->link($this->module_path, 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link($this->oc_root_modules_path, 'token=' . $this->session->data['token'] . '&type=module', true);
		//actions
		
		
		$data['token'] = $this->session->data['token'];
		$data['module_path'] = $this->module_path;


		// load settings
		$config_vars = array(
			$this->module_settings_prefix . 'email', //trustspot_reviews_email
			
			$this->module_settings_prefix . 'api_key',		//trustspot_reviews_api_key
			$this->module_settings_prefix . 'api_secret',	//trustspot_reviews_api_secret
			
			$this->module_settings_prefix . 'order_status_id',	//'trustspot_reviews_order_status_id'
				
			$this->module_settings_prefix . 'show_mini_widget_on_product_page',		//trustspot_reviews_show_mini_widget_on_product_page
			$this->module_settings_prefix . 'show_mini_widget_on_category_page',	//trustspot_reviews_show_mini_widget_on_category_page
			$this->module_settings_prefix . 'show_large_widget_on_product_page',	//trustspot_reviews_show_large_widget_on_product_page
			
			$this->module_settings_prefix . 'status',	//'trustspot_reviews_status'
    );
		
    foreach ($config_vars as $config_var) {
			if (isset($this->request->post[$config_var])) {
				$data[$config_var] = $this->request->post[$config_var];
			} else {
				$data[$config_var] = $this->config->get($config_var);
			}
    }
		// settings


		//order_statuses
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		//order_statuses
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->module_path_template, $data));
	}

	
	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->module_path)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		//trustspot_reviews_email
		if ((utf8_strlen($this->request->post['trustspot_reviews_email']) > 96) || !filter_var($this->request->post['trustspot_reviews_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['trustspot_reviews_email'] = $this->language->get('error_trustspot_reviews_email');
		}
		
		//trustspot_reviews_api_key
		if ((utf8_strlen(trim($this->request->post['trustspot_reviews_api_key'])) < 1) || (utf8_strlen(trim($this->request->post['trustspot_reviews_api_key'])) > 255)) {
			$this->error['trustspot_reviews_api_key'] = $this->language->get('error_trustspot_reviews_api_key');
		}
		
		//trustspot_reviews_api_secret
		if ((utf8_strlen(trim($this->request->post['trustspot_reviews_api_secret'])) < 1) || (utf8_strlen(trim($this->request->post['trustspot_reviews_api_secret'])) > 255)) {
			$this->error['trustspot_reviews_api_secret'] = $this->language->get('error_trustspot_reviews_api_secret');
		}
		
		return !$this->error;
	}
	
	public function uninstall() {
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting($this->module_settings_prefix);
		$this->model_setting_setting->deleteSetting($this->module_settings_prefix . '___');
	}
	
	public function getVerifyApiData() {
		$this->load->model('setting/setting');
		$this->load->language($this->module_path);

		$json = array();
		
		if (!$this->user->hasPermission('modify', $this->module_path)) {
			$json['error'] = $this->language->get('error_permission');
			$this->sentJsonToAjax($json);
			return true;
		}
		
		if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
			$this->sentJsonToAjax($json);
			return true;
		}	
			
		
		
		//$this->request->server['REQUEST_METHOD'] == 'POST'
		// .................................................
		
		//trustspot_reviews_email
		$trustspot_reviews_email = $this->request->post['trustspot_reviews_email'];
		if ((utf8_strlen($trustspot_reviews_email) > 96) || !filter_var($trustspot_reviews_email, FILTER_VALIDATE_EMAIL)) {
			$json['error'] = $this->language->get('error_trustspot_reviews_email');
			$this->sentJsonToAjax($json);
			return true;
		}
	
		//trustspot_reviews_api_key
		$trustspot_reviews_api_key = $this->request->post['trustspot_reviews_api_key'];
		if ((utf8_strlen(trim($trustspot_reviews_api_key)) < 1) || (utf8_strlen(trim($trustspot_reviews_api_key)) > 255)) {
			$json['error'] = $this->language->get('error_trustspot_reviews_api_key');
			$this->sentJsonToAjax($json);
			return true;
		}
			
			
		//verify API data
		$verifyUrl = "https://trustspot.io/api/merchant/verify_api";

		$data = array(
			'email' => $trustspot_reviews_email,
			'key' 	=> $trustspot_reviews_api_key,
		);
		
		$response = $this->curl_post_array_json_call($data, $verifyUrl);
		if (!$response) {
			$this->log->write('TrustSpot Reviews - While API data verification error occurred!');
			
			$json['error'] = $this->language->get('error_verify_api_processing');
			$this->sentJsonToAjax($json);
			return true;
		}
			
			
		//get merchant_id
		$resp_xml = new SimpleXMLElement($response);
		$merchant_id = (int)$resp_xml->status;

		
		//Incorrect API data
		if($merchant_id <= 0){
			$json['error'] = $this->language->get('error_verify_api_data');  
			$this->sentJsonToAjax($json);
			return true;
		}	
			
		$json['merchant_id'] = $merchant_id;	
			
		//save merchant_id in BD
		$save_info = array(
			$this->module_settings_prefix . '___' . 'merchant_id' => $merchant_id,
		);
		$this->model_setting_setting->editSetting($this->module_settings_prefix . '___', $save_info);

		
		//success message
		$json['success'] = $this->language->get('success_verify_api');
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	

	
	private function sentJsonToAjax($json_data) {
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json_data));
		return true;
	}	
	
	private function curl_post_array_json_call($data = array(), $url) {
		if (!is_array($data) || empty($data)) {
			$this->log->write('TrustSpot Reviews - function curl_post_array_json_call: data input parameter is not array or empty!');
			return false;
		}
		
		$dataString = json_encode($data);

		
		// Get cURL resource
		$curl = curl_init();
		
		// Set some options
		$curl_settings = array(
			CURLOPT_URL 						=> $url,
				
			CURLOPT_RETURNTRANSFER 	=> true,
			
			CURLOPT_HEADER					=> false,
			CURLOPT_HTTPHEADER			=> array(
																	'Content-Type: application/json',
																	'Content-Length: ' . strlen($dataString)
																),
																
			CURLOPT_POST						=> true,													
			CURLOPT_POSTFIELDS			=> $dataString, //http_build_query($curl_post_fields),
			
			CURLOPT_CONNECTTIMEOUT 	=> 10,
			CURLOPT_TIMEOUT					=> 30,
			
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2
		);
		curl_setopt_array($curl, $curl_settings);

		
		// Send the request 
		$resp = curl_exec($curl);
		
		// if have errors
		if(curl_errno($curl)) {
			//detailed info
			//$info = curl_getinfo($curl);	

			$this->log->write('TrustSpot Reviews - Curl error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl) . ' - Response: ' . $resp);
			return false;
		}
		
		// Close request to clear up some resources
		curl_close($curl);
		
		return $resp;
	}
	
}
