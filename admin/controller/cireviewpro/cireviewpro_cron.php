<?php
class ControllerCiReviewProCiReviewProCron extends Controller {
	private $error = array();
	private $module_token = '';
	private $ci_token = '';

	public function __construct($registry) {
		parent :: __construct($registry);

		if(VERSION <= '2.3.0.2') {
			$this->module_token = 'token';
			$this->ci_token = $this->session->data['token'];
		} else {
			$this->module_token = 'user_token';
			$this->ci_token = $this->session->data['user_token'];
		}
	}

	public function index() {
		$this->document->addStyle('view/stylesheet/cireviewpro/cireview.css');
		
		$this->load->language('cireviewpro/cireviewpro_cron');
		$this->document->setTitle($this->language->get('heading_title'));

		if(VERSION > '2.0.3.1') {
			$this->load->model('customer/customer');
		} else {
			$this->load->model('sale/customer');
		}

		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('setting/setting');

		$this->load->model('cireviewpro/ciratingtype');
		$this->model_cireviewpro_ciratingtype->Buildtable();

		$store_id = 0;
		if(isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		}

		if ($this->request->server['HTTPS']) {
			$data['front_site'] = $base = HTTPS_CATALOG;
		} else {
			$data['front_site'] = $base = HTTP_CATALOG;
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			


			$this->model_setting_setting->editSetting('cireviewpro_cron',  $this->request->post, $store_id);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cireviewpro/cireviewpro_cron', $this->module_token .'=' . $this->ci_token, true));
		}


		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['legend_email'] = $this->language->get('legend_email');

		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_orderstatuses'] = $this->language->get('entry_orderstatuses');
		$data['entry_customer_groups'] = $this->language->get('entry_customer_groups');
		$data['entry_dayinterval'] = $this->language->get('entry_dayinterval');
		/*29-08-2018*/$data['entry_maxreminders'] = $this->language->get('entry_maxreminders');/*29-08-2018*/
		$data['entry_resendold'] = $this->language->get('entry_resendold');
		$data['entry_onorder'] = $this->language->get('entry_onorder');

		$data['help_orderstatuses'] = $this->language->get('help_orderstatuses');
		$data['help_selectmultiple'] = $this->language->get('help_selectmultiple');
		$data['help_orderstatuschange'] = $this->language->get('help_orderstatuschange');
		$data['help_customer_groups'] = $this->language->get('help_customer_groups');
		$data['help_dayinterval'] = $this->language->get('help_dayinterval');
		$data['help_dayinterval1'] = $this->language->get('help_dayinterval1');
		/*29-08-2018*/$data['help_maxreminders'] = $this->language->get('help_maxreminders');/*29-08-2018*/
		$data['help_resendold'] = $this->language->get('help_resendold');
		$data['help_onorder'] = $this->language->get('help_onorder');

		$data['button_save'] = $this->language->get('button_save');


		$data['code_code'] = $this->language->get('code_code');
		$data['code_translate'] = $this->language->get('code_translate');
		$data['code_firstname'] = $this->language->get('code_firstname');
		$data['code_lastname'] = $this->language->get('code_lastname');
		$data['code_email'] = $this->language->get('code_email');
		$data['code_store_name'] = $this->language->get('code_store_name');
		$data['code_logo'] = $this->language->get('code_logo');
		$data['code_products'] = $this->language->get('code_products');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['subject'])) {
			$data['error_subject'] = $this->error['subject'];
		} else {
			$data['error_subject'] = array();
		}

		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = array();
		}

		if (isset($this->error['orderstatuses'])) {
			$data['error_orderstatuses'] = $this->error['orderstatuses'];
		} else {
			$data['error_orderstatuses'] = '';
		}

		if (isset($this->error['dayinterval'])) {
			$data['error_dayinterval'] = $this->error['dayinterval'];
		} else {
			$data['error_dayinterval'] = '';
		}
		/*29-08-2018*/
		if (isset($this->error['maxreminders'])) {
			$data['error_maxreminders'] = $this->error['maxreminders'];
		} else {
			$data['error_maxreminders'] = '';
		}
		/*29-08-2018*/
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->module_token .'=' . $this->ci_token, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cireviewpro/cireviewpro_cron', $this->module_token .'=' . $this->ci_token, true)
		);
		

		$data['ci_token'] = $this->ci_token;
		$data['module_token'] = $this->module_token;

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['action'] = $this->url->link('cireviewpro/cireviewpro_cron', $this->module_token .'=' . $this->ci_token, true);

		$module_info = $this->model_setting_setting->getSetting('cireviewpro_cron', $store_id);

		$data['store_id'] = $store_id;

		
		if (isset($this->request->post['cireviewpro_cron_mail'])) {
			$data['cireviewpro_cron_mail'] = $this->request->post['cireviewpro_cron_mail'];
		} else if(!empty($module_info['cireviewpro_cron_mail'])) {
			$data['cireviewpro_cron_mail'] = (array)$module_info['cireviewpro_cron_mail'];
		} else {
			$data['cireviewpro_cron_mail'] = array();
		}
		
		if (isset($this->request->post['cireviewpro_cron_status'])) {
			$data['cireviewpro_cron_status'] = $this->request->post['cireviewpro_cron_status'];
		} else if(!empty($module_info['cireviewpro_cron_status'])) {
			$data['cireviewpro_cron_status'] = $module_info['cireviewpro_cron_status'];
		}  else {
			$data['cireviewpro_cron_status'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_cron_orderstatuses'])) {
			$data['cireviewpro_cron_orderstatuses'] = $this->request->post['cireviewpro_cron_orderstatuses'];
		} else if(!empty($module_info['cireviewpro_cron_orderstatuses'])) {
			$data['cireviewpro_cron_orderstatuses'] = (array)$module_info['cireviewpro_cron_orderstatuses'];
		}  else {
			$data['cireviewpro_cron_orderstatuses'] = array();
		}

		if (isset($this->request->post['cireviewpro_cron_ordercomment'])) {
			$data['cireviewpro_cron_ordercomment'] = $this->request->post['cireviewpro_cron_ordercomment'];
		} else if(!empty($module_info['cireviewpro_cron_ordercomment'])) {
			$data['cireviewpro_cron_ordercomment'] = $module_info['cireviewpro_cron_ordercomment'];
		}  else {
			$data['cireviewpro_cron_ordercomment'] = '';
		}

		if (isset($this->request->post['cireviewpro_cron_customer_groups'])) {
			$data['cireviewpro_cron_customer_groups'] = $this->request->post['cireviewpro_cron_customer_groups'];
		} else if(!empty($module_info['cireviewpro_cron_customer_groups'])) {
			$data['cireviewpro_cron_customer_groups'] = (array)$module_info['cireviewpro_cron_customer_groups'];
		}  else {
			$data['cireviewpro_cron_customer_groups'] = array();
		}
		/*29-08-2018*/
		if (isset($this->request->post['cireviewpro_cron_dayinterval'])) {
			$data['cireviewpro_cron_dayinterval'] = $this->request->post['cireviewpro_cron_dayinterval'];
		} else if(!empty($module_info['cireviewpro_cron_dayinterval'])) {
			$data['cireviewpro_cron_dayinterval'] = $module_info['cireviewpro_cron_dayinterval'];
		}  else {
			$data['cireviewpro_cron_dayinterval'] = 1;
		}
		/*29-08-2018*/
		if (isset($this->request->post['cireviewpro_cron_maxreminders'])) {
			$data['cireviewpro_cron_maxreminders'] = $this->request->post['cireviewpro_cron_maxreminders'];
		} else if(!empty($module_info['cireviewpro_cron_maxreminders'])) {
			$data['cireviewpro_cron_maxreminders'] = $module_info['cireviewpro_cron_maxreminders'];
		}  else {
			$data['cireviewpro_cron_maxreminders'] = 1;
		}
		
		if (isset($this->request->post['cireviewpro_cron_resendold'])) {
			$data['cireviewpro_cron_resendold'] = $this->request->post['cireviewpro_cron_resendold'];
		} else if(!empty($module_info['cireviewpro_cron_resendold'])) {
			$data['cireviewpro_cron_resendold'] = $module_info['cireviewpro_cron_resendold'];
		}  else {
			$data['cireviewpro_cron_resendold'] = 0;
		}

		if (isset($this->request->post['cireviewpro_cron_onorder'])) {
			$data['cireviewpro_cron_onorder'] = $this->request->post['cireviewpro_cron_onorder'];
		} else if(!empty($module_info['cireviewpro_cron_onorder'])) {
			$data['cireviewpro_cron_onorder'] = $module_info['cireviewpro_cron_onorder'];
		}  else {
			$data['cireviewpro_cron_onorder'] = 0;
		}

		// get all order statuses
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		// get all customer groups
		if(VERSION > '2.0.3.1') {
			$this->load->model('customer/customer_group');
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$this->load->model('sale/customer_group');
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		}
		


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_cron.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_cron', $data));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'cireviewpro/cireviewpro_cron')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// validate if orderstatus selected
		if(empty($this->request->post['cireviewpro_cron_orderstatuses'])) {
			$this->error['orderstatuses'] = $this->language->get('error_orderstatuses');
		}

		if(!$this->request->post['cireviewpro_cron_dayinterval']) {
			$this->error['dayinterval'] = $this->language->get('error_dayinterval');
		}
		/*29-08-2018*/
		if(!$this->request->post['cireviewpro_cron_maxreminders']) {
			$this->error['maxreminders'] = $this->language->get('error_maxreminders');
		}
		/*29-08-2018*/
		foreach ($this->request->post['cireviewpro_cron_mail'] as $language_id => $value) {
			if ((utf8_strlen($value['subject']) < 3) || (utf8_strlen($value['subject']) > 255)) {
				$this->error['subject'][$language_id] = $this->language->get('error_subject');
			}

			if ((utf8_strlen($value['message']) < 3)) {
				$this->error['message'][$language_id] = $this->language->get('error_message');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function sendInviteEmail() {
		$json = array();

		$this->load->language('cireviewpro/cireviewpro_cron');
		$this->load->model('tool/image');
		$this->load->model('sale/order');
		$this->load->model('setting/setting');
		

		$this->response->addHeader('Content-Type: application/json');
		if(!isset($this->request->post['multiple'])) {
			$json['error'] = $this->language->get('error_invalidrequest');
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}

		$order_ids = array();
	
		// single order
		if($this->request->post['multiple'] == 'false') {
			if(empty($this->request->post['order_id'])) {
				$json['error'] = $this->language->get('error_no_order');
				$this->response->setOutput(json_encode($json));
				$this->response->output();
				exit();
			} else {
				$order_ids[] = $this->request->post['order_id'];
			}
		}

		// multiple orders
		if($this->request->post['multiple'] == 'true') {
			if(empty($this->request->post['order_ids'])) {
				$json['error'] = $this->language->get('error_no_order');
				$this->response->setOutput(json_encode($json));
				$this->response->output();
				exit();
			} else {
				$order_ids =  $this->request->post['order_ids'];
			}
		}

		if(empty($order_ids)) {
			$json['error'] = $this->language->get('error_no_order');
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}
		
		$notfound = '';
		$no_orderstatus = '';
		$ingore_customer_group = '';
		$send = '';

		foreach ($order_ids as $order_id) {
			
			$order_info = $this->model_sale_order->getOrder($order_id);

			if($order_info) {
				$module_info = $this->model_setting_setting->getSetting('cireviewpro_cron', $order_info['store_id']);

				// get new orders and send invite emails
				$orderstatuses = array();
				if(!empty($module_info['cireviewpro_cron_orderstatuses'])) {
					$orderstatuses = $module_info['cireviewpro_cron_orderstatuses'];
				}
				
				$ignore_customer_groups = array();
				if(!empty($module_info['cireviewpro_cron_customer_groups'])) {
					$ignore_customer_groups = $module_info['cireviewpro_cron_customer_groups'];
				}
				
				if(!in_array($order_info['order_status_id'], $orderstatuses)) {
					$no_orderstatus .= $order_id.',';
				}

				if(in_array($order_info['customer_group_id'], $ignore_customer_groups)) {
					$ingore_customer_group .= $order_id.',';
				}

				if((!empty($orderstatuses) && in_array($order_info['order_status_id'], $orderstatuses)) && (!in_array($order_info['customer_group_id'], $ignore_customer_groups))) {
					$this->orderData($order_info);
					$send .= $order_id.',';
				}
			} else {
				$notfound .= $order_id.',';
			}


		}

		$json['success'] = $this->language->get('text_success_invite');
		if($send) {
			$send = substr($send, 0,-1);
			$json['success'] .= '<br>'. sprintf($this->language->get('text_invite_order_ids'), $send);
		}
		if($no_orderstatus) {
			$no_orderstatus = substr($no_orderstatus, 0,-1);
			$json['success'] .= '<br>'. sprintf($this->language->get('text_invite_order_notin_status'), $no_orderstatus);
		}
		if($ingore_customer_group) {
			$ingore_customer_group = substr($ingore_customer_group, 0,-1);
			$json['success'] .= '<br>'. sprintf($this->language->get('text_invite_order_is_ingore'), $ingore_customer_group);
		}
		if($notfound) {
			$notfound = substr($notfound, 0,-1);
			$json['success'] .= '<br>'. sprintf($this->language->get('text_invite_order_notfound'), $notfound);
		}
		
		$this->response->setOutput(json_encode($json));
	}

	private function orderData($order_info) {
		
		$query1 = $this->db->query("SELECT * FROM ". DB_PREFIX . "order_product WHERE order_id='". $order_info['order_id'] ."' ");
		if ($this->request->server['HTTPS']) {
			$base = HTTPS_CATALOG;
		} else {
			$base = HTTP_CATALOG;
		}

		$order_products = $query1->rows;
		$orderproducts = array();
		foreach ($order_products as $key => $order_product) {
			$product_image = false;
			$query2 = $this->db->query("SELECT * FROM ". DB_PREFIX . "product WHERE product_id='". $order_product['product_id'] ."'");
			$product_info = $query2->row;
			if($product_info) {
				if(!empty($product_info['image']) && file_exists(DIR_IMAGE . $product_info['image'])) {
					$product_image = $this->model_tool_image->resize($product_info['image'], 100, 100);
				}
			}

			$product_link = $base . 'index.php?route=product/product&product_id='. $order_product['product_id'];
			$product_link = $this->load->controller('cireviewpro/cireviewpro_invite/rewrite',$product_link);

			$orderproducts[] = array(
				'product_id' => $order_product['product_id'],
				'product_name' => $order_product['name'],
				'product_image' => $product_image,
				'product_link' => $product_link,
			);
		
		}

		
		$store_logo = false;
		if($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {

			$store_logo = $this->model_tool_image->resize($this->config->get('config_logo'), 200,200);
		}


		$mail_data = array(
			'store_logo' => $store_logo,
			'order_products' => $orderproducts,
		);

		$mail_data = array_merge($mail_data, $order_info);

		$this->sendMail($mail_data);
		
	}

	private function sendMail($mail_data) {


		// get langauge id from langauge code
		$lang_code_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE code = '" . $this->db->escape($mail_data['language_code']) . "'");

		$module_info = $this->model_setting_setting->getSetting('cireviewpro_cron', $mail_data['store_id']);
		
		
		if(isset($module_info['cireviewpro_cron_mail'])) {
			$mail_content = $module_info['cireviewpro_cron_mail'];
		} else {
			$mail_content =  $this->config->get('cireviewpro_cron_mail');
		}
		

		 if(!empty($lang_code_query->row) && isset($mail_content[$lang_code_query->row['language_id']])) {
			$mailcontent = $mail_content[$lang_code_query->row['language_id']];
		} else {
			reset($mail_content);
			$first_key = key($mail_content);
			$mailcontent = $mail_content[$first_key];
		}



		$find = array(
			'{FIRSTNAME}',
			'{LASTNAME}',
			'{EMAIL}',
			'{STORE_NAME}',
			'{LOGO}',
			'{ORDER_PRODUCTS}',

		);

		$replace = array(
			'FIRSTNAME' => $mail_data['firstname'],
			'LASTNAME'  => $mail_data['lastname'],
			'EMAIL'  => $mail_data['email'],
			'STORE_NAME' => $this->config->get('config_name'),
			'LOGO' => $mail_data['store_logo'] ? '<img src="'. $mail_data['store_logo'] .'" alt="'. $this->config->get('config_name') .'">' : '',

			'ORDER_PRODUCTS' => $this->orderProducts($mail_data),
		);

		$message = html_entity_decode($mailcontent['message'], ENT_QUOTES, 'UTF-8');
		$subject = html_entity_decode($mailcontent['subject'], ENT_QUOTES, 'UTF-8');

		$subject = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $subject))));
		$message = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $message))));

		$html = $this->header($subject);
		$html .= $message;
		$html .= $this->footer();

		$this->manageCiReviewInvite($mail_data);

		
		if(VERSION >= '3.0.0.0') {
			$mail = new Mail($this->config->get('config_mail_engine'));
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		} else if(VERSION <= '2.0.1.1') {
	     	$mail = new Mail($this->config->get('config_mail'));
	    } else {
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		}

		$mail->setTo($mail_data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject( html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setHtml($html);
		$mail->send();

	}

	private function header($title) {		
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>'.$title.'</title></head><body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;"><div style="width: 680px;">';
	}

	private function footer() {
		return  '</div></body></html>';
	}

	private function orderProducts($mail_data) {
		// Load the language for any mails that might be required to be sent out
		$language = new Language($mail_data['language_code']);
		$language->load($mail_data['language_code']);
		$language->load('cireviewpro/cireviewcron');

		$html = '<table>';
		$html .= '	<thead>';
		$html .= '		<tr>';
		$html .= '			<td>'. $language->get('text_product') .'</td>';
		$html .= '			<td>'. $language->get('text_image') .'</td>';
		$html .= '			<td>'. $language->get('text_link') .'</td>';
		$html .= '		</tr>';
		$html .= '	</thead>';
		$html .= '	<tbody>';
		foreach ($mail_data['order_products'] as $key => $order_product) {
		$html .= '		<tr>';
		$html .= '			<td><a href="'. $order_product['product_link'] .'">'. $order_product['product_name'] .'</a></td>';
		$html .= '			<td><a href="'. $order_product['product_link'] .'">'. '<img src="'. $order_product['product_image'] .'" alt="'. $order_product['product_name'] .'" />' .'</a></td>';
		$html .= '			<td>'. $order_product['product_link'] .'</td>';
		$html .= '		</tr>';
		}
		$html .= '	</tbody>';
		$html .= '</table>';

		return $html;
	}

	private function manageCiReviewInvite($mail_data, $reminder=true) {
		// check if we already have record

		foreach ($mail_data['order_products'] as $key => $order_product) {
			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."cireview_invite WHERE order_id='". $mail_data['order_id'] ."' AND store_id='". $mail_data['store_id'] ."' AND customer_id='". $mail_data['customer_id'] ."' AND product_id='". $order_product['product_id'] ."' ");

			$cireview_invite_info = $query->row;
			if($query->num_rows) {
				$cireview_invite_id = $cireview_invite_info['cireview_invite_id'];
			} else {
				$this->db->query("INSERT INTO ". DB_PREFIX ."cireview_invite SET order_id='". $mail_data['order_id'] ."', store_id='". $mail_data['store_id'] ."', customer_id='". $mail_data['customer_id'] ."', product_id='". $order_product['product_id'] ."', invite=1, status=1, date_added=NOW()");
				$cireview_invite_id = $this->db->getLastId();
				
			}
			if($reminder) {
				$this->db->query("INSERT INTO ". DB_PREFIX ."cireview_invitereminder SET cireview_invite_id='". $cireview_invite_id ."', reminder=1, date_added=NOW()");
				$cireview_invitereminder_id = $this->db->getLastId();
				$this->db->query("UPDATE ". DB_PREFIX ."cireview_invite SET last_reminder_id='". $cireview_invitereminder_id ."' WHERE cireview_invite_id='". $cireview_invite_id ."'");
			}
			$this->db->query("UPDATE ". DB_PREFIX ."cireview_invite SET last_reminder_date_added=NOW() WHERE cireview_invite_id='". $cireview_invite_id ."'");
		}
	}
}