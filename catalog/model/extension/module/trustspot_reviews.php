<?php

class ModelExtensionModuleTrustSpotReviews extends Model {			// >= opencart 2.3
//class ModelModuleTrustSpotReviews extends Model {							// < opencart 2.3
	

	private $_api_add_review_product_description_length = 500;
	private $_api_add_review_product_image_width 				= 400;
	private $_api_add_review_product_image_height 			= 400;
	
	public function getConfigArray() {
		
		$merchant_id = $this->config->get('trustspot_reviews____merchant_id') ? $this->config->get('trustspot_reviews____merchant_id') : 0;
		
		$api_key = $this->config->get('trustspot_reviews_api_key') ? $this->config->get('trustspot_reviews_api_key') : '';
		
		$my_config_vars = array( 
			'api_key'			=> $api_key,
			
			'order_status_id' => $this->config->get('trustspot_reviews_order_status_id') ? $this->config->get('trustspot_reviews_order_status_id') : 0,
			
			'show_mini_widget_on_product_page'	=> $this->config->get('trustspot_reviews_show_mini_widget_on_product_page') ? true : false,
			'show_mini_widget_on_category_page'	=> $this->config->get('trustspot_reviews_show_mini_widget_on_category_page') ? true : false,
			'show_large_widget_on_product_page'	=> $this->config->get('trustspot_reviews_show_large_widget_on_product_page') ? true : false,
			
			'status' 			=> $this->config->get('trustspot_reviews_status') ? true : false,
			
			'css_style_1_href' => 'https://trustspot.io/index.php/api/pub/product_widget_css/' . $merchant_id . '/widget.css',
		);
		
		return $my_config_vars;
	}

	
	// send data to trustspot api
	public function trustspotApiAddReview($order_id, $order_status_id) {
		
		$trustspot_reviews_config_array = $this->getConfigArray();
		
		$trustspot_order_status_id = $trustspot_reviews_config_array['order_status_id'];
			
		if ($trustspot_order_status_id == $order_status_id) {
			
			//api_key, api_secret, 
			$trustspot_api_key 		= $trustspot_reviews_config_array['api_key'];
			$trustspot_api_secret = $api_key = $this->config->get('trustspot_reviews_api_secret') ? $this->config->get('trustspot_reviews_api_secret') : '';
			
			//merchantId
			$trustspot_merchant_id = $this->config->get('trustspot_reviews____merchant_id') ? $this->config->get('trustspot_reviews____merchant_id') : 0;
			
			//order_id, purchase_date
			$this->load->model('checkout/order');
			$trustspot_order_info = $this->model_checkout_order->getOrder($order_id);
			
			$trustspot_order_purchase_date = $trustspot_order_info['date_added'];
			
			
			//customer_name, customerEmail
			$trustspot_customer_fullname  = $trustspot_order_info['firstname'] . ' ' . $trustspot_order_info['lastname'];
			$trustspot_customer_email 		= $trustspot_order_info['email'];
			
			
			//product_id, product_name, product_desc, product_price, product_url, product_image
			$order_product_sql = "SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'";
			$trustspot_order_products_query = $this->db->query($order_product_sql);

			$this->load->model('tool/image');
			
			$trustspot_products = array();
			foreach ($trustspot_order_products_query->rows as $order_product) {
				$curr_product_id 		= $order_product['product_id'];
				
				$curr_product_name	= $order_product['name'];
				
				$curr_product_desc_array = $this->getProductDescriprion($order_product['product_id'], $trustspot_order_info['language_id']);
				//$curr_product_desc	= html_entity_decode($curr_product_desc_array['description'], ENT_QUOTES, 'UTF-8');
				$curr_product_desc	= utf8_substr(
					strip_tags(html_entity_decode($curr_product_desc_array['description'], ENT_QUOTES, 'UTF-8')), 
					0, 
					$this->_api_add_review_product_description_length
				) . '..';
			
				
				$curr_product_price	= $order_product['price'];
				
				$curr_product_url		= $this->url->link('product/product', '&product_id=' . $order_product['product_id']);
				
				$product_image_path = $this->getProductMainImage($order_product['product_id']);
				if ($product_image_path) {
					$curr_product_image = $this->model_tool_image->resize($product_image_path, $this->_api_add_review_product_image_width, $this->_api_add_review_product_image_height);
				} else {
					$curr_product_image = '';
				}
				
				$trustspot_products[] = array(
					'product_sku'		=>	$curr_product_id,
					'product_name'	=>	$curr_product_name,
					
					'product_desc'	=> 	$curr_product_desc,
					
					'product_price'	=>	$curr_product_price,
					
					'product_url'		=>	$curr_product_url,
					'product_image'	=>	$curr_product_image,
				);
			}

			
			// call API - add_product_review
			$data_for_hmac = $trustspot_merchant_id . $order_id . $trustspot_customer_email;
			$calculated_hmac = base64_encode(hash_hmac('sha256', $data_for_hmac, $trustspot_api_secret, true));
			
			$api_data = array(
					'merchant_id'       => $trustspot_merchant_id,
					'order_id'          => $order_id,
					'customer_name'     => $trustspot_customer_fullname,
					'customer_email'    => $trustspot_customer_email,
					'purchase_date'     => $trustspot_order_purchase_date,
					'key'               => $trustspot_api_key,
					'hmac'              => $calculated_hmac,
					'products'          => $trustspot_products
			);
			
			$api_add_product_review_url = 'https://trustspot.io/api/merchant/add_product_review';
			$response = $this->curl_post_array_json_call($api_data, $api_add_product_review_url);
			
			
			if (!$response) {
				$this->log->write('TrustSpot API - add product review - Error processing!');
				return false;
			}
			

			//get status field value
			$resp_xml = new SimpleXMLElement($response);
			$status_field_value = (string)$resp_xml->status;

			
			//Incorrect status
			if($status_field_value !== 'success'){
				$this->log->write('TrustSpot API - add product review - response return status not "success"!');
				return false;
			}	
			
			
			return true;
		}
		
		return false;
	}
	
	
	private function getProductDescriprion($product_id, $language_id) {
		$query = $this->db->query(
			"SELECT  * FROM " . DB_PREFIX . "product_description pd 
			WHERE 
				pd.product_id = '" . (int)$product_id . "' AND 
				pd.language_id = '" . (int)$language_id . "'"
		);

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
	
	private function getProductMainImage($product_id) {
		$query = $this->db->query(
			"SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'"
		);

		if (!$query->num_rows) {
			return false;
		} 
		
		return $query->row['image'];
	}
	
	
	private function curl_post_array_json_call($data = array(), $url) {
		
		if (!is_array($data) || empty($data)) {
			$this->log->write('TrustSpot Reviews - function curl_post_array_json_call: data input parameter is not array or empty!');
			return false;
		}
		
		$data_json_string = json_encode($data);
		
		// Get cURL resource
		$curl = curl_init();
		
		// Set some options
		$curl_settings = array(
			CURLOPT_URL 						=> $url,
				
			CURLOPT_RETURNTRANSFER 	=> true,
			
			CURLOPT_HEADER					=> false,
			CURLOPT_HTTPHEADER			=> array(
																	'Content-Type: application/json',
																	'Content-Length: ' . strlen($data_json_string)
																),
																
			CURLOPT_POST						=> true,													
			CURLOPT_POSTFIELDS			=> $data_json_string, //http_build_query($curl_post_fields),
			
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