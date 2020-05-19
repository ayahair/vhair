<?php
//SELECT * FROM `oc_cireview_invite` WHERE DATE_FORMAT(date_added,'%Y-%m-%d') <= CURRENT_DATE() - INTERVAL 2 DAY
class ControllerCiReviewProCiReviewCron extends Controller {

	public function reviewInviteOnOrder($order_id) {
		if($order_id && $this->config->get('cireviewpro_cron_onorder') !=1 && !empty($order_id['order_id'])) {


			$this->load->model('tool/image');
			$this->load->model('checkout/order');


			$order_info = $this->model_checkout_order->getOrder($order_id['order_id']);

			if($order_info) {

				$query1 = $this->db->query("SELECT * FROM ". DB_PREFIX . "order_product WHERE order_id='". $order_info['order_id'] ."' ");
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

					$orderproducts[] = array(
						/*31-10-2018*/
						'order_product_id' => $order_product['order_product_id'],
						/*31-10-2018*/
						'product_id' => $order_product['product_id'],
						'product_name' => $order_product['name'],
						'product_image' => $product_image,
						'product_link' => $this->url->link('product/product', 'product_id=' . $order_product['product_id']),
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
				$this->manageCiReviewInvite($mail_data, false);

			}
		}

		if($order_id && $this->config->get('cireviewpro_cron_onorder') && $this->config->get('cireviewpro_cron_status') && !empty($order_id['order_id'])) {
			$this->load->model('tool/image');
			$this->load->model('checkout/order');

			$order_info = $this->model_checkout_order->getOrder($order_id['order_id']);

			if($order_info) {

				// get new orders and send invite emails
				$orderstatuses = (array)$this->config->get('cireviewpro_cron_orderstatuses');
				$ignore_customer_groups = (array)$this->config->get('cireviewpro_cron_customer_groups');

				if((!empty($orderstatuses) && in_array($order_info['order_status_id'], $orderstatuses)) && (!in_array($order_info['customer_group_id'], $ignore_customer_groups))) {
					$this->orderData($order_info);
				}
			}
		}
	}

	public function cron() {

		if($this->config->get('cireviewpro_cron_status')) {

			
			$this->load->model('tool/image');
			$this->load->model('checkout/order');

			// get new orders and send invite emails

			$orderstatuses = (array)$this->config->get('cireviewpro_cron_orderstatuses');

			// send invites only, when we have new order after install the extension. Ignore past orders 
			$hasinvite_sql = $this->db->query("SELECT COUNT(*) AS total FROM ". DB_PREFIX . "cireview_invite WHERE status=1");

			if(!empty($orderstatuses) && $hasinvite_sql->row['total'] > 0) {

				$order_statuses = implode(",", $orderstatuses);

				$sql = "SELECT o.order_id FROM `". DB_PREFIX . "order` as `o` WHERE ( o.order_id > (IFNULL((SELECT cri.order_id FROM ". DB_PREFIX . "cireview_invite cri WHERE cri.status=1 ORDER BY cri.cireview_invite_id DESC LIMIT 0, 1 ),0))";

				// we include cireview_invite order ID. only when record has no reminder. this is the case when customer add order but no invite email send. when cron run, we must include last order as it does not get reminder at all
				$invite_orderids = '';
				$invite_sql = $this->db->query("SELECT cri.* FROM ". DB_PREFIX . "cireview_invite cri WHERE cri.status=1 AND cri.review=0");

				foreach ($invite_sql->rows as $key => $value) {
					$reminder_sql = $this->db->query("SELECT COUNT(*) AS total FROM ". DB_PREFIX . "cireview_invitereminder crir WHERE crir.cireview_invite_id='". $value['cireview_invite_id'] ."' ");
					if($reminder_sql->row['total'] <= 0) {
						$invite_orderids .= $value['order_id'].',';
					}
				}

				if($invite_orderids) {
					$invite_orderids = substr($invite_orderids, 0, -1);
					$sql .= " OR o.order_id IN (".$invite_orderids.")";
				}

				$sql .= " )";
				$sql .= " AND o.store_id='". (int)$this->config->get('config_store_id') ."' AND o.order_status_id IN(". $order_statuses .")";

				$ignore_customer_groups = (array)$this->config->get('cireviewpro_cron_customer_groups');


				if(!empty($ignore_customer_groups)) {
					$ignorecustomergroups = implode(",", $ignore_customer_groups);
					$sql .= " AND o.customer_group_id NOT IN (". $ignorecustomergroups .") ";
				}

				$orders_query = $this->db->query($sql);

				// we just collect user information and product information.

				foreach($orders_query->rows as $order) {
					$order_info = $this->model_checkout_order->getOrder($order['order_id']);
					if($order_info) {
						$this->orderData($order_info);
					}
				}
			}

			// resend invite emails to already invited customers who still not give review over product of their order

			if($this->config->get('cireviewpro_cron_resendold')) {
				$days = (int)$this->config->get('cireviewpro_cron_dayinterval') ? (int)$this->config->get('cireviewpro_cron_dayinterval') : 1;
				
				//SELECT * FROM `oc_cireview_invite` WHERE DATE_FORMAT(	date_added,'%Y-%m-%d') <= CURRENT_DATE() - INTERVAL 2 DAY
				$query3 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cireview_invite` WHERE status=1 AND review=0 AND DATE_FORMAT(date_added,'%Y-%m-%d') <= CURRENT_DATE() - INTERVAL ". $days ." DAY GROUP BY order_id");

				foreach ($query3->rows as $key => $order) {
					$order_info = $this->model_checkout_order->getOrder($order['order_id']);
					if($order_info) {
						$this->orderData($order_info);
					}
				}
			}
		}
	}

	private function orderData($order_info) {
		$query1 = $this->db->query("SELECT * FROM ". DB_PREFIX . "order_product WHERE order_id='". $order_info['order_id'] ."' ");
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

			$orderproducts[] = array(
				/*31-10-2018*/
				'order_product_id' => $order_product['order_product_id'],
				/*31-10-2018*/
				'product_id' => $order_product['product_id'],
				'product_name' => $order_product['name'],
				'product_image' => $product_image,
				'product_link' => $this->url->link('product/product', 'product_id=' . $order_product['product_id']),
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

		

		$mail_content = $this->config->get('cireviewpro_cron_mail');

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
			}

			/*31-10-2018 verify purchase info start*/
			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."cireview_verify WHERE order_id='". $mail_data['order_id'] ."' AND store_id='". $mail_data['store_id'] ."' AND customer_id='". $mail_data['customer_id'] ."' AND order_product_id='". $order_product['order_product_id'] ."' AND product_id='". $order_product['product_id'] ."' ");

			$cireview_verify_info = $query->row;
			if($query->num_rows) {
				$cireview_verify_id = $cireview_verify_info['cireview_verify_id'];
			} else {
				$this->db->query("INSERT INTO ". DB_PREFIX ."cireview_verify SET order_id='". $mail_data['order_id'] ."', store_id='". $mail_data['store_id'] ."', customer_id='". $mail_data['customer_id'] ."', order_product_id='". $order_product['order_product_id'] ."', product_id='". $order_product['product_id'] ."', status=1, date_added=NOW()");
				$cireview_verify_id = $this->db->getLastId();
			}

			// here we disable verify, when order is deleted
			if($mail_data['order_status_id'] == 0) {
				$this->db->query("UPDATE ". DB_PREFIX ."cireview_verify SET status='0', date_modified=NOW() WHERE order_id='". (int)$mail_data['order_id'] ."'");
			}
			/*31-10-2018 verify purchase info end*/
		}
	}
}
