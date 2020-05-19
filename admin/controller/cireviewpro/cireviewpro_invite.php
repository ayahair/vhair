<?php
class ControllerCiReviewProCiReviewProInvite extends Controller {
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


	public function rewrite($link) {
		$return = $link;
		if(VERSION <= '2.3.0.2' && $this->config->get('config_seo_url')) {
			// get seo keyword of product
			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."url_alias WHERE query='product/cireviewpro' ");
			$customseo = array();
			if($query->num_rows) {
				$customseo[$query->row['query']] = $query->row['keyword'];
			}

			$url_info = parse_url(str_replace('&amp;', '&', $link));

			$url = '';

			$data = array();

			parse_str($url_info['query'], $data);

			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					if (($data['route'] == 'product/product' && $key == 'product_id')) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];

							unset($data[$key]);
						}
					} elseif(isset($customseo[$key])) {
						$url .= '/' . $customseo[$key];
					}
				}
			}

			if ($url) {
				unset($data['route']);

				$query = '';

				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
					}

					if ($query) {
						$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
					}
				}

				$return = $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
			} else {
				$return = $link;
			}			
		} else if(VERSION >= '3.0.0.0' && $this->config->get('config_seo_url')) {
			// get seo keyword of product
			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."seo_url WHERE query='product/cireviewpro' ");
			$customseo = array();
			if($query->num_rows) {
				$customseo[$query->row['query']] = $query->row['keyword'];
			}

			$url_info = parse_url(str_replace('&amp;', '&', $link));

			$url = '';

			$data = array();

			parse_str($url_info['query'], $data);

			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					if (($data['route'] == 'product/product' && $key == 'product_id')) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];

							unset($data[$key]);
						}
					} elseif(isset($customseo[$key])) {
						$url .= '/' . $customseo[$key];
					}
				}
			}

			if ($url) {
				unset($data['route']);

				$query = '';

				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
					}

					if ($query) {
						$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
					}
				}

				$return = $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
			} else {
				$return = $link;
			}
			
		}

		return $return;
	}

	public function saveTemplate() {
		$json = array();

		$this->load->language('cireviewpro/cireviewpro_invite');
		$this->load->model('setting/setting');
		if (!empty($this->request->post)) {

			// unset 
			unset($this->request->post['cireviewpro_invite_customers']);
			unset($this->request->post['cireviewpro_invite_product_id']);
			

			$this->model_setting_setting->editSetting('cireviewpro_invite', $this->request->post, $this->request->get['store_id']);
		}

		$json['success'] = $this->language->get('text_templatesave');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function index() {
		$this->document->addStyle('view/stylesheet/cireviewpro/cireview.css');
		
		$this->load->language('cireviewpro/cireviewpro_invite');
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

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if ($this->request->server['HTTPS']) {
				$base = HTTPS_CATALOG;
			} else {
				$base = HTTP_CATALOG;
			}

			$cireviewpro_invite_customers = $this->request->post['cireviewpro_invite_customers'];
			$cireviewpro_invite_product_id = $this->request->post['cireviewpro_invite_product_id'];

			// unset 
			unset($this->request->post['cireviewpro_invite_customers']);
			unset($this->request->post['cireviewpro_invite_product_id']);

			$this->model_setting_setting->editSetting('cireviewpro_invite', $this->request->post, $store_id);


			foreach ($cireviewpro_invite_customers as $customer_id) {
		
				if(VERSION > '2.0.3.1') {
					$customer_info = $this->model_customer_customer->getCustomer($customer_id);
				} else {
					$customer_info = $this->model_sale_customer_group->getCustomer($customer_id);
				}

				$product_info = $this->model_catalog_product->getProduct($cireviewpro_invite_product_id);

				if($customer_info && $product_info) {

				$to = $customer_info['email'];
				$logo = '';
				if($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {

				$logo = $this->model_tool_image->resize($this->config->get('config_logo'), 200,200);
				}
				$product_image = '';
				if(!empty($product_info['image']) && file_exists(DIR_IMAGE . $product_info['image']) && !in_array($product_info['image'], array('no_image.png','placeholder.png'))) {
				$product_image = $this->model_tool_image->resize($product_info['image'], 200,200);
				}

				// direct link of product
				$link = $base . 'index.php?route=product/product&product_id='. $product_info['product_id'];
				$link = $this->rewrite($link);

				$product_link = $base . 'index.php?route=product/product&product_id='. $product_info['product_id'];
				$product_link = $this->rewrite($product_link);

				$find = array(
					'{FIRSTNAME}',
					'{LASTNAME}',
					'{EMAIL}',
					'{LINK}',
					'{STORE_NAME}',
					'{LOGO}',
					'{PRODUCT_NAME}',
					'{PRODUCT_IMAGE}',
					'{PRODUCT_LINK}',
				);
	
				$replace = array(
					'FIRSTNAME' => $customer_info['firstname'],
					'LASTNAME'  => $customer_info['lastname'],
					'EMAIL'  => $customer_info['email'],
					'LINK'   => $link,
					'STORE_NAME' => $this->config->get('config_name'),
					'LOGO' => $logo ? '<img src="'. $logo .'" alt="'. $this->config->get('config_name') .'">' : '',
					'PRODUCT_NAME' => $product_info['name'],
					'PRODUCT_IMAGE' => $product_image ? '<img src="'. $product_image .'" alt="'. $product_info['name'] .'">' : '',
					'PRODUCT_LINK' => $product_link,
					
				);

				$message = html_entity_decode($this->request->post['cireviewpro_invite_message'], ENT_QUOTES, 'UTF-8');
				$subject = html_entity_decode($this->request->post['cireviewpro_invite_subject'], ENT_QUOTES, 'UTF-8');

				$subject = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $subject))));
				$message = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $message))));
		
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

				$mail->setTo($to);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject( html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($message);
				$mail->send();

				}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cireviewpro/cireviewpro_invite', $this->module_token .'=' . $this->ci_token, true));
		}


		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['legend_email'] = $this->language->get('legend_email');

		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');


		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');
	
		$data['help_customer'] = $this->language->get('help_customer');
		$data['help_product'] = $this->language->get('help_product');
	
		$data['button_mail'] = $this->language->get('button_mail');
		$data['button_save'] = $this->language->get('button_save');

		$data['code_code'] = $this->language->get('code_code');
		$data['code_translate'] = $this->language->get('code_translate');
		$data['code_firstname'] = $this->language->get('code_firstname');
		$data['code_lastname'] = $this->language->get('code_lastname');
		$data['code_email'] = $this->language->get('code_email');
		$data['code_link'] = $this->language->get('code_link');
		$data['code_store_name'] = $this->language->get('code_store_name');
		$data['code_logo'] = $this->language->get('code_logo');
		$data['code_product_name'] = $this->language->get('code_product_name');
		$data['code_product_image'] = $this->language->get('code_product_image');
		$data['code_product_link'] = $this->language->get('code_product_link');
		
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

		if (isset($this->error['customers'])) {
			$data['error_customers'] = $this->error['customers'];
		} else {
			$data['error_customers'] = '';
		}

		if (isset($this->error['product'])) {
			$data['error_product'] = $this->error['product'];
		} else {
			$data['error_product'] = '';
		}

		if (isset($this->error['subject'])) {
			$data['error_subject'] = $this->error['subject'];
		} else {
			$data['error_subject'] = '';
		}

		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->module_token .'=' . $this->ci_token, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cireviewpro/cireviewpro_invite', $this->module_token .'=' . $this->ci_token, true)
		);
		

		$data['ci_token'] = $this->ci_token;
		$data['module_token'] = $this->module_token;

		$data['action'] = $this->url->link('cireviewpro/cireviewpro_invite', $this->module_token .'=' . $this->ci_token, true);

		$module_info = $this->model_setting_setting->getSetting('cireviewpro_invite', $store_id);

		$data['store_id'] = $store_id;

		
		if (isset($this->request->post['cireviewpro_invite_subject'])) {
			$data['cireviewpro_invite_subject'] = $this->request->post['cireviewpro_invite_subject'];
		} else if(!empty($module_info['cireviewpro_invite_subject'])) {
			$data['cireviewpro_invite_subject'] = $module_info['cireviewpro_invite_subject'];
		} else {
			$data['cireviewpro_invite_subject'] = '';
		}

		if (isset($this->request->post['cireviewpro_invite_message'])) {
			$data['cireviewpro_invite_message'] = $this->request->post['cireviewpro_invite_message'];
		} else if(!empty($module_info['cireviewpro_invite_message'])) {
			$data['cireviewpro_invite_message'] = $module_info['cireviewpro_invite_message'];
		} else {
			$data['cireviewpro_invite_message'] = '';
		}

		if (isset($this->request->post['cireviewpro_invite_product_id'])) {
			$data['cireviewpro_invite_product_id'] = $this->request->post['cireviewpro_invite_product_id'];
		} else {
			$data['cireviewpro_invite_product_id'] = 0;
		}

		if (isset($this->request->post['cireviewpro_invite_product'])) {
			$data['cireviewpro_invite_product'] = $this->request->post['cireviewpro_invite_product'];
		} else {
			$data['cireviewpro_invite_product'] = '';
		}


		if (isset($this->request->post['cireviewpro_invite_customer'])) {
			$data['cireviewpro_invite_customer'] = $this->request->post['cireviewpro_invite_customer'];
		} else {
			$data['cireviewpro_invite_customer'] = '';
		}

		// Customers
		
		if (isset($this->request->post['cireviewpro_invite_customers'])) {
			$customers = $this->request->post['cireviewpro_invite_customers'];
		} else {
			$customers = array();
		}

		$data['cireviewpro_invite_customers'] = array();

		foreach ($customers as $customer_id) {
			if(VERSION > '2.0.3.1') {
				$customer_info = $this->model_customer_customer->getCustomer($customer_id);
			} else {
				$customer_info = $this->model_sale_customer->getCustomer($customer_id);
			}

			if ($customer_info) {
				$data['cireviewpro_invite_customers'][] = array(
					'customer_id' => $customer_info['customer_id'],
					'name'        => $customer_info['firstname'] .' '. $customer_info['lastname']
				);
			}
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_invite.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_invite', $data));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'cireviewpro/cireviewpro_invite')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['cireviewpro_invite_subject']) < 3) || (utf8_strlen($this->request->post['cireviewpro_invite_subject']) > 255)) {
			$this->error['subject'] = $this->language->get('error_subject');
		}

		if ((utf8_strlen($this->request->post['cireviewpro_invite_message']) < 3)) {
			$this->error['message'] = $this->language->get('error_message');
		}

		if(empty($this->request->post['cireviewpro_invite_customers'])) {
			$this->error['customers'] = $this->language->get('error_customers');
		}
		
		if(empty($this->request->post['cireviewpro_invite_product'])) {
			$this->error['product'] = $this->language->get('error_product');
		}


		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
}