<?php
class ModelCiReviewProCiReview extends Model {
	
	public function getCiRatingTypes($product_id=0) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciratingtype p LEFT JOIN " . DB_PREFIX . "ciratingtype_description pd ON(p.ciratingtype_id=pd.ciratingtype_id) LEFT JOIN " . DB_PREFIX . "ciratingtype_to_store p2s ON(p.ciratingtype_id=p2s.ciratingtype_id) WHERE pd.language_id='". (int)$this->config->get('config_language_id') ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND p.status=1 ORDER BY p.sort_order");

		$data = array();


		if($product_id) {

			$this->load->model('catalog/product');

			$product_info = $this->model_catalog_product->getProduct($product_id);

			foreach($query->rows as $row) {

				// Product
				$product_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."ciratingtype_product WHERE ciratingtype_id = '". (int)$row['ciratingtype_id'] ."' AND product_id = '". (int)$product_id ."'");

				// Find Tabs
				$find_again = true;
				if($product_query->num_rows) {
					$find_again = false;
				}

				if($find_again) {
					// Category
					$categories = $this->model_catalog_product->getCategories($product_id);
					$category_ids = array();

					foreach($categories as $category) {
						$category_ids[] = $category['category_id'];
					}

					if($category_ids) {
						$category_ids = implode(',', $category_ids);
						$category_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."ciratingtype_category WHERE ciratingtype_id = '". (int)$row['ciratingtype_id'] ."' AND category_id IN (". $category_ids .")");

						$category_query_num_rows = $category_query->num_rows;
					} else{
						$category_query_num_rows = 0;
					}


					if($category_query_num_rows) {
						$find_again = false;
					}
				}

				if($find_again) {

					// Manufacturer
					if(!empty($product_info['manufacturer_id'])) {
						$manufacturer_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."ciratingtype_manufacturer WHERE ciratingtype_id = '". (int)$row['ciratingtype_id'] ."' AND manufacturer_id = '". $product_info['manufacturer_id'] ."'");

						$manufacturer_query_num_rows = $manufacturer_query->num_rows;
					} else{
						$manufacturer_query_num_rows = 0;
					}

					if($manufacturer_query_num_rows) {
						$find_again = false;
					}
				}


				if($find_again == false) {					
					$data[] = $row;
				}
			}

			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciratingtype p LEFT JOIN " . DB_PREFIX . "ciratingtype_description pd ON(p.ciratingtype_id=pd.ciratingtype_id) LEFT JOIN " . DB_PREFIX . "ciratingtype_to_store p2s ON(p.ciratingtype_id=p2s.ciratingtype_id) WHERE pd.language_id='". (int)$this->config->get('config_language_id') ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND p.status=1 AND p.ciratingtype_id NOT IN( SELECT ciratingtype_id FROM " . DB_PREFIX . "ciratingtype_product ) AND p.ciratingtype_id NOT IN( SELECT ciratingtype_id FROM " . DB_PREFIX . "ciratingtype_category ) AND p.ciratingtype_id NOT IN( SELECT ciratingtype_id FROM " . DB_PREFIX . "ciratingtype_manufacturer ) ORDER BY p.sort_order");

			$data = array_merge($data, $query->rows);

		} else {
			$data = $query->rows;
		}


		return $data;
		
	}

	public function getCiRatingType($ciratingtype_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciratingtype p LEFT JOIN " . DB_PREFIX . "ciratingtype_description pd ON(p.ciratingtype_id=pd.ciratingtype_id) LEFT JOIN " . DB_PREFIX . "ciratingtype_to_store p2s ON(p.ciratingtype_id=p2s.ciratingtype_id) WHERE p.ciratingtype_id='". (int)$ciratingtype_id ."' AND pd.language_id='". (int)$this->config->get('config_language_id') ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND p.status=1 ORDER BY p.sort_order");
		return $query->row;
		
	}

	public function getCiRatingTypeDescription($ciratingtype_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciratingtype_description pd LEFT JOIN " . DB_PREFIX . "ciratingtype p ON(pd.ciratingtype_id=p.ciratingtype_id) LEFT JOIN " . DB_PREFIX . "ciratingtype_to_store p2s ON(pd.ciratingtype_id=p2s.ciratingtype_id) WHERE p.ciratingtype_id='". (int)$ciratingtype_id ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."'");
		return $query->rows;
		
	}

	public function isCiReviewVoted($data) {
		/*$product_id, $review_id, $cireview_id, $customer_id=null*/
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "cireview_vote WHERE cireview_id='". (int)$data['cireview_id'] ."' AND product_id='". (int)$data['product_id'] ."' AND review_id='". (int)$data['review_id'] ."' AND status=1";
		if($this->customer->isLogged()) {
			$sql .= " AND customer_id='". (int)$this->customer->getId() ."'";
		} else {
			$sql .= " AND session_id='". $this->db->escape($this->session->getId()) ."'";
		}
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function addCiReviewVote($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "cireview_vote SET cireview_id='". (int)$data['cireview_id'] ."', product_id='". (int)$data['product_id'] ."', review_id='". (int)$data['review_id'] ."', status=1, session_id='". $this->db->escape($this->session->getId()) ."', customer_id='". (int)$this->customer->getId() ."', date_added=now(), vote='". (int)$data['action'] ."'");
		return $this->db->getLastId();
	}

	public function getCiAbReasons($product_id=0) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciabreason p LEFT JOIN " . DB_PREFIX . "ciabreason_description pd ON(p.ciabreason_id=pd.ciabreason_id) LEFT JOIN " . DB_PREFIX . "ciabreason_to_store p2s ON(p.ciabreason_id=p2s.ciabreason_id) WHERE pd.language_id='". (int)$this->config->get('config_language_id') ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND p.status=1 ORDER BY p.sort_order");

		$data = array();

		if($product_id) {

			$this->load->model('catalog/product');

			$product_info = $this->model_catalog_product->getProduct($product_id);

			foreach($query->rows as $row) {

				// Product
				$product_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."ciabreason_product WHERE ciabreason_id = '". (int)$row['ciabreason_id'] ."' AND product_id = '". (int)$product_id ."'");

				// Find Tabs
				$find_again = true;
				if($product_query->num_rows) {
					$find_again = false;
				}

				if($find_again) {
					// Category
					$categories = $this->model_catalog_product->getCategories($product_id);
					$category_ids = array();

					foreach($categories as $category) {
						$category_ids[] = $category['category_id'];
					}

					if($category_ids) {
						$category_ids = implode(',', $category_ids);
						$category_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."ciabreason_category WHERE ciabreason_id = '". (int)$row['ciabreason_id'] ."' AND category_id IN (". $category_ids .")");

						$category_query_num_rows = $category_query->num_rows;
					} else{
						$category_query_num_rows = 0;
					}


					if($category_query_num_rows) {
						$find_again = false;
					}
				}

				if($find_again) {

					// Manufacturer
					if(!empty($product_info['manufacturer_id'])) {
						$manufacturer_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."ciabreason_manufacturer WHERE ciabreason_id = '". (int)$row['ciabreason_id'] ."' AND manufacturer_id = '". $product_info['manufacturer_id'] ."'");

						$manufacturer_query_num_rows = $manufacturer_query->num_rows;
					} else{
						$manufacturer_query_num_rows = 0;
					}

					if($manufacturer_query_num_rows) {
						$find_again = false;
					}
				}


				if($find_again == false) {					
					$data[] = $row;
				}
			}


			$gquery = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciabreason p LEFT JOIN " . DB_PREFIX . "ciabreason_description pd ON(p.ciabreason_id=pd.ciabreason_id) LEFT JOIN " . DB_PREFIX . "ciabreason_to_store p2s ON(p.ciabreason_id=p2s.ciabreason_id) WHERE pd.language_id='". (int)$this->config->get('config_language_id') ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND p.status=1 AND p.ciabreason_id NOT IN( SELECT crp.ciabreason_id FROM " . DB_PREFIX . "ciabreason_product crp ) AND p.ciabreason_id NOT IN( SELECT crc.ciabreason_id FROM " . DB_PREFIX . "ciabreason_category crc ) AND p.ciabreason_id NOT IN( SELECT crm.ciabreason_id FROM " . DB_PREFIX . "ciabreason_manufacturer crm ) ORDER BY p.sort_order");


			$data = array_merge($data, $gquery->rows);



		} else {
			$data = $query->rows;
		}


		return $data;
		
	}

	public function getCiAbReason($ciabreason_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciabreason p LEFT JOIN " . DB_PREFIX . "ciabreason_description pd ON(p.ciabreason_id=pd.ciabreason_id) LEFT JOIN " . DB_PREFIX . "ciabreason_to_store p2s ON(p.ciabreason_id=p2s.ciabreason_id) WHERE p.ciabreason_id='". (int)$ciabreason_id ."' AND pd.language_id='". (int)$this->config->get('config_language_id') ."' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND p.status=1 ORDER BY p.sort_order");
		return $query->row;
	}

	public function addCiAbReason($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "cireview_abuse SET cireview_id='". (int)$data['cireview_id'] ."', product_id='". (int)$data['product_id'] ."', review_id='". (int)$data['review_id'] ."', status=1, session_id='". $this->db->escape($this->session->getId()) ."', customer_id='". (int)$this->customer->getId() ."', date_added=now(), ciabreason_id='". $this->db->escape($data['ciabreason']) ."', ciabreason_name='". $this->db->escape($data['ciabreason_name']) ."', `text`='". $this->db->escape($data['ciabreason_other']) ."'");
		return $this->db->getLastId();
	}
	
	public function getCiReviewsByProductId($data=array() ) {
		
		$sql = "SELECT r.review_id, r.author, r.rating, r.text, p.product_id, pd.name, p.price, p.image, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND 
				CASE WHEN (SELECT COUNT(*) as total FROM " . DB_PREFIX . "cireview cr WHERE cr.review_id=r.review_id ) > 0 THEN 
					CASE WHEN (SELECT COUNT(*) as total FROM " . DB_PREFIX . "cireview cr1 WHERE cr1.review_id=r.review_id";
		
		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr1.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr1.language_id='". (int)$this->config->get('config_language_id') ."'";
		}
		if (isset($data['filter_imp']) && !is_null($data['filter_imp'])) {
			$sql .= " AND cr1.imp='". (int)$data['filter_imp'] ."'";
		}
		
		if (isset($data['filter_attachimages']) && $data['filter_attachimages'] != '') {
			if((int)$data['filter_attachimages']==1) {
				$sql .= " AND CASE WHEN (SELECT COUNT(*) FROM " . DB_PREFIX . "cireview_image ri WHERE ri.cireview_id = cr1.cireview_id AND ri.status=1) > 0 THEN true ELSE false END";
			} else {
				$sql .= " AND CASE WHEN (SELECT COUNT(*) FROM " . DB_PREFIX . "cireview_image ri WHERE ri.cireview_id = cr1.cireview_id AND ri.status=1) <= 0 THEN true ELSE false END";
			}
		}
		
		$sql.=		" ) > 0 THEN 
						true 
					ELSE 
						false 
					END 
				ELSE 
					true 
				END ";
		
		if (!empty($data['product_id'])) {
			$sql .= " AND p.product_id = '" . (int)$data['product_id'] . "' ";
		}

		if (!empty($data['filter_rating'])) {
			$sql .= " AND r.rating = '" . (int)$data['filter_rating'] . "' ";
		}

		$sort_data = array(
			'r.date_added',
			'r.date_modified',
			'r.rating',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	

	public function getTotalCiReviewsByProductId($data = array()) {
		$sql ="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id='". (int)$this->config->get('config_store_id') ."' AND 
				CASE WHEN (SELECT COUNT(*) as total FROM " . DB_PREFIX . "cireview cr WHERE cr.review_id=r.review_id ) > 0 THEN 
					CASE WHEN (SELECT COUNT(*) as total FROM " . DB_PREFIX . "cireview cr1 WHERE cr1.review_id=r.review_id";
		
		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr1.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr1.language_id='". (int)$this->config->get('config_language_id') ."'";
		}
		if (isset($data['filter_imp']) && !is_null($data['filter_imp'])) {
			$sql .= " AND cr1.imp='". (int)$data['filter_imp'] ."'";
		}
		
		if (isset($data['filter_attachimages']) && $data['filter_attachimages'] != '') {
			if((int)$data['filter_attachimages']==1) {
				$sql .= " AND CASE WHEN (SELECT COUNT(*) FROM " . DB_PREFIX . "cireview_image ri WHERE ri.cireview_id = cr1.cireview_id AND ri.status=1) > 0 THEN true ELSE false END";
			} else {
				$sql .= " AND CASE WHEN (SELECT COUNT(*) FROM " . DB_PREFIX . "cireview_image ri WHERE ri.cireview_id = cr1.cireview_id AND ri.status=1) <= 0 THEN true ELSE false END";
			}
		}
		
		$sql .=		" ) > 0 THEN 
						true 
					ELSE 
						false 
					END 
				ELSE 
					true 
				END ";

		if (!empty($data['product_id'])) {
			$sql .= " AND p.product_id = '" . (int)$data['product_id'] . "' ";
		}

		if (!empty($data['filter_rating'])) {
			$sql .= " AND r.rating = '" . (int)$data['filter_rating'] . "' ";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function addUpload($image, $mask, $ext) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "cireview_image SET image='". $this->db->escape($image) ."', mask='". $this->db->escape($mask) ."', ext='". $this->db->escape($ext) ."', session_id='". $this->db->escape($this->session->getId()) ."', status='1'");
		
		$cireview_image_id = $this->db->getLastId();

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();

		foreach($languages as $language) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "cireview_image_description SET cireview_image_id='". (int)$cireview_image_id ."', language_id='". (int)$language['language_id'] ."', title='". $this->db->escape(basename($image)) ."', alt='". $this->db->escape(basename($image)) ."', session_id='". $this->db->escape($this->session->getId()) ."'");
		}

		return $cireview_image_id;
	}
	
	public function getUploadedImage() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_image WHERE cireview_id='0' AND session_id='". $this->db->escape($this->session->getId()) ."' AND status=1");
		return $query->rows;
	}

	public function removeUpload($cireview_image_id) {
		$cireview_image_info = $this->getCiReviewImage($cireview_image_id);
		if($cireview_image_info){
			@unlink(DIR_IMAGE . $cireview_image_info['image']);
			$this->db->query("DELETE FROM " . DB_PREFIX . "cireview_image WHERE cireview_image_id='". $this->db->escape($cireview_image_id) ."'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "cireview_image_description WHERE cireview_image_id='". $this->db->escape($cireview_image_id) ."'");

		}
	}

	public function getCiReviewImage($cireview_image_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_image WHERE cireview_image_id='". (int)$cireview_image_id ."' AND status=1");
		return $query->row;
	}

	public function getCiReviewAttachImages($cireview_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_image WHERE cireview_id='". (int)$cireview_id ."' AND status=1");
		return $query->rows;
	}

	public function getCiReviewImagesDescriptions($cireview_image_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_image_description WHERE cireview_image_id='".  (int)$cireview_image_id ."' AND language_id='". (int)$this->config->get('config_language_id') ."'");

		return $query->row;
	}

	public function getCiReviewByReviewId($review_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview WHERE review_id='". (int)$review_id ."'");
		/*here we do little magic behind the scene*/
		if(!$query->num_rows) {
			$review_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "review WHERE review_id='". (int)$review_id ."'");
			if($review_query->num_rows) {
				$email = '';
				if($review_query->row['customer_id']) {
					$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id='". (int)$review_query->row['customer_id'] ."'");
					if($customer_query->num_rows) {
						$email = $customer_query->row['email'];
					}

				}
				$this->db->query("INSERT INTO " . DB_PREFIX . "cireview SET review_id='". (int)$review_id ."', product_id='". (int)$review_query->row['product_id'] ."', email='". $this->db->escape($email) ."', store_id='". (int)$this->config->get('config_store_id') ."', language_id='". (int)$this->config->get('config_language_id') ."'");
				$cireview_id = $this->db->getLastId();
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview WHERE review_id='". (int)$review_id ."'");
			}
		}
		return $query->row;
	}

	public function getCiReviewRatings($cireview_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cireview_rating WHERE cireview_id='". (int)$cireview_id ."' AND status=1");
		return $query->rows;
	}
	
	public function getCiReviewVotes($cireview_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cireview_vote WHERE cireview_id='". (int)$cireview_id ."' AND status=1");
		return $query->rows;
		
	}

	public function addCiReview($product_id, $data) {

		// get product information
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');
		$this->load->model('tool/image');

		$status = 0;
		if($this->customer->isLogged() && $this->config->get('cireviewpro_reviewapprove')=='LOGGED') {
			$status = 1;
		} elseif($this->config->get('cireviewpro_reviewapprove')=='BOTH') {
			$status = 1;
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['ciname']) . "', customer_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', status = '" . (int)$status . "', text = '" . $this->db->escape($data['cireview']) . "', date_added = NOW()");

		$review_id = $this->db->getLastId();
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "cireview SET email = '" . $this->db->escape($data['ciemail']) . "', title = '" . $this->db->escape($data['cititle']) . "', product_id = '" . (int)$product_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . (int)$this->config->get('config_language_id') . "', review_id = '" . (int)$review_id . "', coupon_code='".( !empty($data['coupon_code']) ? $this->db->escape($data['coupon_code']) : '' )."', coupon_id='".( isset($data['coupon_id']) ? (int)$data['coupon_id'] : 0 )."', reward_points='".( isset($data['reward_points']) ? (int)$data['reward_points'] : 0 )."', customer_reward_id='".( isset($data['customer_reward_id']) ? (int)$data['customer_reward_id'] : 0 )."'");
		
		$cireview_id = $this->db->getLastId();

		$this->db->query("UPDATE " . DB_PREFIX . "cireview_image SET cireview_id = '" . (int)$cireview_id . "' WHERE session_id = '" . $this->db->escape($this->session->getId()) . "' AND cireview_id='0'");
		$this->db->query("UPDATE " . DB_PREFIX . "cireview_image_description SET cireview_id = '" . (int)$cireview_id . "' WHERE session_id = '" . $this->db->escape($this->session->getId()) . "' AND cireview_id='0'");

		
		if(!empty($data['cireview_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "cireview_image SET cireview_id = '" . (int)$cireview_id . "' WHERE cireview_image_id IN(". $data['cireview_image'] .") AND cireview_id='0'");
			$this->db->query("UPDATE " . DB_PREFIX . "cireview_image_description SET cireview_id = '" . (int)$cireview_id . "' WHERE cireview_image_id IN(". $data['cireview_image'] .") AND cireview_id='0'");
		}

		$review = array();
		$review['author'] = $data['ciname'];
		$review['email'] = $data['ciemail'];
		$review['title'] = $data['cititle'];
		$review['text'] = $data['cireview'];
		$review['rating'] = '';
		$review['all_rating'] = '';
	
		if($this->config->get('cireviewpro_rating')) {
			$ratings = 0;
			$rating = 0;
			
			if(isset($data['cirating'])) {
				foreach($data['cirating'] as $ciratingtype_id => $cirating) {
					$ratingtype_info = $this->getCiRatingTypeDescription($ciratingtype_id);

					if($ratingtype_info) {
					$ratings += $cirating;

					$ciratingtype_names = array();
					$ciratingtype_name = '';
					foreach ($ratingtype_info as $key => $value) {
						$ciratingtype_names[$value['language_id']] = $value['name'];
						if($value['language_id'] == $this->config->get('config_language_id')) {
							$ciratingtype_name = $value['name'];

						}
					}

					$this->db->query("INSERT INTO " . DB_PREFIX . "cireview_rating SET  product_id = '" . (int)$product_id . "', status = '1', rating = '" . (int)$cirating . "', review_id = '" . (int)$review_id . "', cireview_id = '" . (int)$cireview_id . "', ciratingtype_id = '" . (int)$ciratingtype_id . "', ciratingtype_name = '" . ($this->db->escape(json_encode($ciratingtype_names))) . "'");

					$review['all_rating'] .= '<b>'. $ciratingtype_name .'</b>: '. $cirating .' . <br/>' ;
					}
					
				}
			}
			
			if($ratings) {
				$rating = $ratings / count($data['cirating']);
				$review['rating'] =  $rating;
			}

			$this->db->query("UPDATE " . DB_PREFIX . "review SET rating = '" . (int)$rating . "' WHERE review_id = '" . (int)$review_id . "'");
		}

		$review['attachment'] = '';
		$attachments = array();
		$attachment_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_image WHERE cireview_id = '" . (int)$cireview_id . "' AND status=1 ORDER BY sort_order ASC");
		if($attachment_query->num_rows) {
			$review['attachment'] .= '<ul style="list-style: none;">';
			foreach($attachment_query->rows as $row) {

				$image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_image_description WHERE cireview_id = '" . (int)$cireview_id . "' AND language_id='". (int) $this->config->get('config_language_id') ."' AND cireview_image_id='". (int)$row['cireview_image_id']  ."'");

				$title = '';
				$alt = '';

				if($image_description_query->row) {
					$title = $image_description_query->row['title'];
					$alt = $image_description_query->row['alt'];
				}

				if(!empty($row['image']) && file_exists(DIR_IMAGE . $row['image'])) {
					$attach_image = $this->model_tool_image->resize($row['image'], 100, 100);
					$review['attachment'] .= '<li tyle="float: left; margin-right: 15px; margin-bottom: 20px; width: 100px; border: 1px solid #ddd; padding: 5px; overflow: auto;"><img style="max-width: 100%;" title="'. $title .'" alt="'. $alt .'" src="'. $attach_image .'" ><li>';
					$attachments[] = $attach_image;
				}
			}
			$review['attachment'] .= '</ul>';
		}


		// check if customer is invited and update their status as customer give review
		if($this->customer->isLogged()) {
			
			// get pending review request against customer
			$invite_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."cireview_invite WHERE customer_id='". (int)$this->customer->getId() ."' AND review=0 AND product_id='". (int)$product_id ."'");


			if($invite_query->row) {
				// now get order product and check if current product is buy by customer recently
				$order_product_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."order_product WHERE order_id='". (int)$invite_query->row['order_id'] ."' AND product_id='". (int)$product_id ."'");

				if($order_product_query->num_rows) {
					$this->db->query("UPDATE ". DB_PREFIX ."cireview_invite SET review=1, review_id='". $review_id ."', cireview_id='". $cireview_id ."', date_modified=NOW() WHERE customer_id='". $this->customer->getId() ."' AND review=0 AND order_id='". $invite_query->row['order_id'] ."' AND product_id='". (int)$product_id ."'");
				}
			}
			/*31-10-2018 verify purchase info start*/
			/*check if customer give review to product already or not. if not update accordingly. If customer order same product in different orders, then they are able to give review same times they buy same product.*/
			$verify_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."cireview_verify WHERE customer_id='". (int)$this->customer->getId() ."' AND review=0 AND product_id='". (int)$product_id ."' AND review_id=0 AND cireview_id=0 AND status=1");
			if($verify_query->num_rows) {
				$this->db->query("UPDATE ". DB_PREFIX ."cireview_verify SET review=1, review_id='". $review_id ."', cireview_id='". $cireview_id ."', date_modified=NOW() WHERE cireview_verify_id='". $verify_query->row['cireview_verify_id'] ."'");
			}
			/*31-10-2018 verify purchase info start*/
		}
		
		$product_info = $this->model_catalog_product->getProduct($product_id);

		// Send Email System

		if($product_info) {

			$products = array();
			$categories = array();
			$manufacturers = array();

			if($this->config->get('cireviewpro_mailproduct')) {
				foreach((array)$this->config->get('cireviewpro_mailproduct') as $productid ) {
					$productinfo = $this->model_catalog_product->getProduct($productid);
					if($productinfo) {
						
						if (!empty($productinfo['image']) && file_exists(DIR_IMAGE . $productinfo['image'])) {
							$image = $this->model_tool_image->resize($productinfo['image'], 200, 200);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', 200, 200);
						}	

						$price = $this->currency->format($this->tax->calculate($productinfo['price'], $productinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						

						if ((float)$productinfo['special']) {
							$special = $this->currency->format($this->tax->calculate($productinfo['special'], $productinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
							$special = false;
						}

						if ($this->config->get('config_tax')) {
							$tax = $this->currency->format((float)$productinfo['special'] ? $productinfo['special'] : $productinfo['price'], $this->session->data['currency']);
						} else {
							$tax = false;
						}

						if ($this->config->get('config_review_status')) {
							$rating = $productinfo['rating'];
						} else {
							$rating = false;
						}
						$products[] = array(
							'product_id' => $productinfo['product_id'],
							'thumb'       => $image,
							'name' => $productinfo['name'],
							'description' => utf8_substr(strip_tags(html_entity_decode($productinfo['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
							'price'       => $price,
							'special'     => $special,
							'tax'         => $tax,
							'rating'      => $rating,
							'href'        => $this->url->link('product/product', 'product_id=' . $productinfo['product_id'])
						);
					}
				}	
			}

			if($this->config->get('cireviewpro_mailcategory')) {

				foreach((array)$this->config->get('cireviewpro_mailcategory') as $category_id ) {
					$categoryinfo = $this->model_catalog_category->getCategory($category_id);

					if($categoryinfo) {

						$path = array();

						// get parent category_ids if we have. So we can get correct path.
						$path_query = $this->getCategoryPath($categoryinfo['category_id']);

						if($path_query->num_rows) {
							foreach($path_query->rows as $row) {
								$path[] = $row['path_id'];
							}
						}

						$path[] = $categoryinfo['category_id'];
						
						
						if (!empty($categoryinfo['image']) && file_exists(DIR_IMAGE . $categoryinfo['image'])) {
							$image = $this->model_tool_image->resize($categoryinfo['image'], 200, 200);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', 200, 200);
						}

						$categories[] = array(
							'category_id' => $categoryinfo['category_id'],
							'thumb'       => $image,
							'name' => $categoryinfo['name'],
							'href'        => $this->url->link('product/category', 'path=' . implode('_', $path)),
							'description' => utf8_substr(strip_tags(html_entity_decode($categoryinfo['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						);

					}
				}
			}

			if($this->config->get('cireviewpro_mailmanufacturer')) {

				foreach((array)$this->config->get('cireviewpro_mailmanufacturer') as $manufacturer_id ) {
					$manufacturerinfo = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);


					if($manufacturerinfo) {
						
						if (!empty($manufacturerinfo['image']) && file_exists(DIR_IMAGE . $manufacturerinfo['image'])) {
							$image = $this->model_tool_image->resize($manufacturerinfo['image'], 200, 200);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', 200, 200);
						}

						$manufacturers[] = array(
							'manufacturer_id' => $manufacturerinfo['manufacturer_id'],
							'thumb'       => $image,
							'name' => $manufacturerinfo['name'],
							'href'        => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturerinfo['manufacturer_id']),
						);

					}
				}
			}

			$customer_email = empty($data['ciemail']) ? $this->customer->getEmail() : $data['ciemail'];

			if($this->config->get('cireviewpro_customersend') && $customer_email) {

				$customer_mailinfo = $this->config->get('cireviewpro_customer');

				if(isset($customer_mailinfo[(int)$this->config->get('config_language_id')])) {
					$customer_mail = $customer_mailinfo[(int)$this->config->get('config_language_id')];
				} else {
					reset($customer_mailinfo);
					$first_key = key($customer_mailinfo);
					$customer_mail = $customer_mailinfo[$first_key];
				}

					

				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}

				
				$logo = '';

				$maillogoimagethumb_width = $this->config->get('cireviewpro_maillogoimagethumb_width');
				if(empty($maillogoimagethumb_width)) {
					$maillogoimagethumb_width = 100;
				}
				$maillogoimagethumb_height = $this->config->get('cireviewpro_maillogoimagethumb_height');
				if(empty($maillogoimagethumb_height)) {
					$maillogoimagethumb_height = 100;
				}

				if ($this->config->get('config_logo') && is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
					$logo = $this->model_tool_image->resize($this->config->get('config_logo'), $maillogoimagethumb_width,$maillogoimagethumb_height);
				}

				$product_image = '';

				$mailproductimagethumb_width = $this->config->get('cireviewpro_mailproductimagethumb_width');
				if(empty($mailproductimagethumb_width)) {
					$mailproductimagethumb_width = 200;
				}
				$mailproductimagethumb_height = $this->config->get('cireviewpro_mailproductimagethumb_height');
				if(empty($mailproductimagethumb_height)) {
					$mailproductimagethumb_height = 200;
				}



				if(!empty($product_info['image']) && file_exists(DIR_IMAGE . $product_info['image']) && !in_array($product_info['image'], array('no_image.png','placeholder.png'))) {
					$product_image = $this->model_tool_image->resize($product_info['image'], $mailproductimagethumb_width,$mailproductimagethumb_height);
				}
					
						
			
				$find = array(
					'{PRODUCT_NAME}',
					'{PRODUCT_IMAGE}',
					'{PRODUCT_LINK}',
					'{PRODUCT_DESCRIPTION}',
					'{LOGO}',
					'{STORE_NAME}',
					'{STORE_LINK}',
					'{REVIEW_AUTHOR}',
					'{REVIEW_EMAIL}',
					'{REVIEW_TITLE}',
					'{REVIEW_TEXT}',
					'{REVIEW_RATING}',
					'{REVIEW_ALL_RATING}',
					'{REVIEW_ATTACHMENT}',
					'{REVIEW_LINK}',
					'{PROMO_PRODUCT}',
					'{PROMO_CATEGORY}',
					'{PROMO_MANUFACTURER}',
					'{COUPON_CODE}',
					'{REWARD_POINTS}',
					

				);
			
				$replace = array(
					'PRODUCT_NAME' => $product_info['name'],
					'PRODUCT_IMAGE' => $product_image ? '<img src="'. $product_image .'" alt="'. $product_info['name'] .'">' : '',
					'PRODUCT_LINK' => $this->url->link('product/product','product_id=' . $product_info['product_id']),
					'PRODUCT_DESCRIPTION' => html_entity_decode( $product_info['description'], ENT_QUOTES, 'UTF-8'),
					'LOGO'							=> $logo ? '<img src="'. $logo .'" alt="'. $this->config->get('config_name') .'" title="'. $this->config->get('config_name') .'" />' : '',
					'STORE_NAME'					=> $this->config->get('config_name'),
					'STORE_LINK'					=> $this->url->link('common/home', '', true),
					'REVIEW_AUTHOR'					=> $review['author'],
					'REVIEW_EMAIL'					=> $review['email'],
					'REVIEW_TITLE'					=> $review['title'],
					'REVIEW_TEXT'					=> $review['text'],
					'REVIEW_RATING'					=> $review['rating'],
					'REVIEW_ALL_RATING'				=> $review['all_rating'],
					'REVIEW_ATTACHMENT'				=> $review['attachment'],
					'REVIEW_LINK'					=> $this->url->link('cireviewpro/cireview','product_id=' . $product_info['product_id'].'&review_id='. $review_id),
					'PROMO_PRODUCT'					=> $this->promoProduct($products),
					'PROMO_CATEGORY'					=> $this->promoCategory($categories),
					'PROMO_MANUFACTURER'					=> $this->promoManufacturer($manufacturers),
					'COUPON_CODE'					=> $data['coupon_code'],
					'REWARD_POINTS'					=> $data['reward_points'],
					
				);
				
				$subject = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $customer_mail['customertitle']))));

				$body = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $customer_mail['customermessage']))));

				$message = $this->mailHeader($subject);
				$message .= $body;
				$message .= $this->mailFooter();

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

				foreach($attachments as $attachment) {
					$mail->addAttachment($attachment);
				}

				$mail->setTo($customer_email);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();

					
				
			}

			if($this->config->get('cireviewpro_adminsend')) {

				$admin_mailinfo = $this->config->get('cireviewpro_admin');

				if(isset($admin_mailinfo[(int)$this->config->get('config_language_id')])) {
					$admin_mail = $admin_mailinfo[(int)$this->config->get('config_language_id')];
				} else {
					reset($admin_mailinfo);
					$first_key = key($admin_mailinfo);
					$admin_mail = $admin_mailinfo[$first_key];
				}

				
				$adminemail = $this->config->get('cireviewpro_adminmail');
				$admin_email = $this->config->get('config_email');
				if (utf8_strlen($adminemail) > 0 && filter_var($adminemail, FILTER_VALIDATE_EMAIL)) {
					$admin_email = $adminemail;
				}
				

				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}

				if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
					$logo = $server . 'image/' . $this->config->get('config_logo');
				} else {
					$logo = '';
				}

				$product_image = '';
				if(!empty($product_info['image']) && file_exists(DIR_IMAGE . $product_info['image']) && !in_array($product_info['image'], array('no_image.png','placeholder.png'))) {
				$product_image = $this->model_tool_image->resize($product_info['image'], 200,200);
				}

				
				$admindir = 'admin/';
				if($this->config->get('cireviewpro_reviewadmindir')) {

					// remove trailing slah from path.
					do {
						if(substr($this->config->get('cireviewpro_reviewadmindir'), -1) == '/') {
						    $this->config->set('cireviewpro_reviewadmindir', substr($this->config->get('cireviewpro_reviewadmindir'), 0, -1));
						}
					}while(substr($this->config->get('cireviewpro_reviewadmindir'), -1) == '/');
					

					$admindir = $this->config->get('cireviewpro_reviewadmindir').'/';
				}

				$adminURL = new Url(HTTP_SERVER.$admindir, HTTPS_SERVER.$admindir);
				
				
				$find = array(
					'{PRODUCT_NAME}',
					'{PRODUCT_IMAGE}',
					'{PRODUCT_LINK}',
					'{PRODUCT_DESCRIPTION}',
					'{LOGO}',
					'{STORE_NAME}',
					'{STORE_LINK}',
					'{REVIEW_AUTHOR}',
					'{REVIEW_EMAIL}',
					'{REVIEW_TITLE}',
					'{REVIEW_TEXT}',
					'{REVIEW_RATING}',
					'{REVIEW_ALL_RATING}',
					'{REVIEW_ATTACHMENT}',
					'{REVIEW_LINK}',
					'{PROMO_PRODUCT}',
					'{PROMO_CATEGORY}',
					'{PROMO_MANUFACTURER}',
					'{COUPON_CODE}',
					'{REWARD_POINTS}',
					
				);
			
				$replace = array(
					'PRODUCT_NAME' => $product_info['name'],
					'PRODUCT_IMAGE' => $product_image ? '<img src="'. $product_image .'" alt="'. $product_info['name'] .'">' : '',
					'PRODUCT_LINK' => $adminURL->link('catalog/product/edit','product_id=' . $product_info['product_id'], true), 
					'PRODUCT_DESCRIPTION' => html_entity_decode( $product_info['description'], ENT_QUOTES, 'UTF-8'),
					'LOGO'							=> '<img src="'. $logo .'" alt="'. $this->config->get('config_name') .'" title="'. $this->config->get('config_name') .'" />',
					'STORE_NAME'					=> $this->config->get('config_name'),
					'STORE_LINK'					=> $this->url->link('common/home', '', true),
					
					'REVIEW_AUTHOR'					=> $review['author'],
					'REVIEW_EMAIL'					=> $review['email'],
					'REVIEW_TITLE'					=> $review['title'],
					'REVIEW_TEXT'					=> $review['text'],
					'REVIEW_RATING'					=> $review['rating'],
					'REVIEW_ALL_RATING'				=> $review['all_rating'],
					'REVIEW_ATTACHMENT'				=> $review['attachment'],
					'REVIEW_LINK'					=> $adminURL->link('cireviewpro/cireviews/edit', 'review_id='.$review_id, true),
					'PROMO_PRODUCT'					=> $this->promoProduct($products),
					'PROMO_CATEGORY'					=> $this->promoCategory($categories),
					'PROMO_MANUFACTURER'					=> $this->promoManufacturer($manufacturers),
					'COUPON_CODE'					=> $data['coupon_code'],
					'REWARD_POINTS'					=> $data['reward_points'],
						
				);

				$subject = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $admin_mail['admintitle']))));
				
				$body = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $admin_mail['adminmessage']))));

				$message = $this->mailHeader($subject);
				$message .= $body;
				$message .= $this->mailFooter();

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

				foreach($attachments as $attachment) {
					$mail->addAttachment($attachment);
				}

				$mail->setTo($admin_email);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));

				$mail->send();

				// Send to additional alert emails if new account email is enabled
				$emails = explode(',', $this->config->get('config_alert_email'));

				foreach ($emails as $email) {
					if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$mail->setTo($email);
						$mail->send();
					}
				}
			}
		}
	}

	private function mailHeader($title) {
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">';
		$html .= '<html>';
		$html .= '<head>';
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		$html .= '<title>'.$title .'</title>';
		$html .= '</head>';
		$html .= '<body style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #000000;">';
		$html .= '<div style="width: 680px;">';
		return $html;
  
	}

	private function mailFooter() {
		$html = '</div>';
		$html .= '</body>';
		$html .= '</html>';
		return $html;
	}

	private function promoProduct($products) {
		$text_tax = $this->language->get('text_tax');
		$html = '';
		if($products) {
		$html .= '<ul style="list-style: none;">';
			foreach($products as $product) {
		$html .= '	<li style="float: left; margin-right: 15px; margin-bottom: 20px; width: 100px; border: 1px solid #ddd; padding: 5px; overflow: auto;">';
		$html .= '	  <img style="max-width: 100%;" src="'.$product['thumb'].'" alt="'.$product['name'].'" />';
		$html .= '	    <h3 style="font-size: 18px; color: #444; font-weight: 600; margin-bottom: 10px; margin-top: 10px;">'.$product['name'].'</h3>';
			    if ($product['price']) {
		$html .= '	    <p style="margin-bottom: 10px; color: #444;">';
			      if (!$product['special']) {
		$html .=	      $product['price'];
			      } else {
		$html .= '	      <span style="font-weight: 600;">'.$product['special'].'</span> <span style="color: #999; text-decoration: line-through; margin-left: 10px;">'.$product['price'].'</span>';
			      }
			      if ($product['tax']) {
		$html .= '	      <span style="color: #999; font-size: 12px; display: block;">'.$text_tax.' '.$product['tax'].'</span>';
			      }
		$html .= '	    </p>';
			    }
		$html .= '	</li>';
			}
		$html .= '	</ul> <br style="clear: both;">  ';
			}

		return $html;
	}

	private function promoCategory($categories) {
		$html = '';
		if($categories) {

		$html .= '<ul style="list-style: none;">';
		foreach($categories as $category) {
		$html .= '<li style="float: left; margin-right: 15px; margin-bottom: 20px; width: 100px; border: 1px solid #ddd; padding: 5px; overflow: auto;">';
		$html .= '  <img style="max-width: 100%;" src="'. $category['thumb'].'" alt="'. $category['name'].'" />';
		$html .= '    <h3 style="font-size: 18px; color: #444; font-weight: 600; margin-bottom: 10px; margin-top: 10px;">'. $category['name'].'</h3>';
		$html .= '</li>';
		}
		$html .= '</ul> <br style="clear: both;"> ';
		}
		return $html;
	}

	private function promoManufacturer($manufacturers) {
		$html = '';
		if($manufacturers) {

		$html .= '<ul style="list-style: none;">';
		foreach($manufacturers as $manufacturer) {
		$html .= '<li style="float: left; margin-right: 15px; margin-bottom: 20px; width: 100px; border: 1px solid #ddd; padding: 5px; overflow: auto;">';
		$html .= '  <img style="max-width: 100%;" src="'. $manufacturer['thumb'].'" alt="'. $manufacturer['name'].'" />';
		$html .= '    <h3 style="font-size: 18px; color: #444; font-weight: 600; margin-bottom: 10px; margin-top: 10px;">'. $manufacturer['name'].'</h3>';
		$html .= '</li>';
		}
		$html .= '</ul> <br style="clear: both;"> ';
		}
		return $html;
	}

	public function getCategoryPath($category_id) {
		$query = $this->db->query("SELECT * FROM `". DB_PREFIX ."category_path` WHERE category_id='". (int)$category_id ."' AND path_id <> '". (int)$category_id ."' ORDER BY level ASC ");
		return $query;
	}

	public function getCiReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT r.*, cr.* FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "cireview cr ON(r.review_id=cr.review_id) WHERE r.review_id='". (int)$review_id ."' AND r.status=1 ORDER BY r.date_added DESC");
		return $query->row;
	}
	
	public function getCiReviews($data=array()) {
		
		$sql = "SELECT r.review_id FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "cireview cr ON(cr.review_id=r.review_id) WHERE r.status=1";

		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr.language_id='". (int)$this->config->get('config_language_id') ."'";
		}
		if (isset($data['filter_imp']) && !is_null($data['filter_imp'])) {
			$sql .= " AND cr.imp='". (int)$data['filter_imp'] ."'";
		}
		
		if (!empty($data['filter_review_id'])) {
			$sql .= " AND r.review_id='". $data['filter_review_id'] ."'";
		}

		if (!empty($data['filter_cireview_product_id'])) {
			$sql .= " AND r.product_id='". $data['filter_cireview_product_id'] ."'";
		}

		
		if (!empty($data['filter_cireviewsearch'])) {
			$sql .= " AND (";
			$implode = array();
			$implode1 = array();

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_cireviewsearch'])));

			foreach ($words as $word) {
				$implode[] = "r.author LIKE '%" . $this->db->escape($word) . "%'";
				if((int)$this->config->get('cireviewpro_reviewpagetitleshow')) {
					$implode1[] = "cr.title LIKE '%" . $this->db->escape($word) . "%'";
				}
			}

			if ($implode) {
				$sql .= " " . implode(" AND ", $implode) . "";
			}

			if ($implode1) {
				$sql .= " OR " . implode(" AND ", $implode1) . "";
			}
			
			$sql .= " OR r.text LIKE '%" . $this->db->escape($data['filter_cireviewsearch']) . "%'";

			$sql .= " OR r.product_id IN( SELECT sp.product_id FROM ". DB_PREFIX ."product sp LEFT JOIN ". DB_PREFIX ."product_description spd ON(sp.product_id=spd.product_id) LEFT JOIN ". DB_PREFIX ."product_to_store sp2s ON(sp.product_id=sp2s.product_id) WHERE sp.status=1 AND spd.language_id='". (int)$this->config->get('config_language_id') ."' AND sp2s.store_id='". (int)$this->config->get('config_store_id') ."' AND spd.name LIKE '%" . $this->db->escape($data['filter_cireviewsearch']) . "%' ) ";

			$sql .= ")";
		}
		
		

		if (!empty($data['filter_author'])) {
			$sql .= " AND (";

			if (!empty($data['filter_author'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_author'])));

				foreach ($words as $word) {
					$implode[] = "r.author LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_text'])) {
					$sql .= " OR r.text LIKE '%" . $this->db->escape($data['filter_author']) . "%'";
				}
			}

			$sql .= ")";
		}

		$sql .= " GROUP BY r.review_id";


		$sort_data = array(
			'r.review_id',
			'r.product_id',
			'r.customer_id',
			'r.author',
			'r.rating',
			'r.date_added',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$review_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$review_data[$result['review_id']] = $this->getCiReview($result['review_id']);
		}

		return $review_data;

	}


	public function getTotalCiReviews($data = array()) {
		
		$sql = "SELECT COUNT(DISTINCT r.review_id) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "cireview cr ON(cr.review_id=r.review_id) WHERE r.status=1";

		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr.language_id='". (int)$this->config->get('config_language_id') ."'";
		}
		
		if (!empty($data['filter_review_id'])) {
			$sql .= " AND r.review_id='". $data['filter_review_id'] ."'";
		}
		
		if (!empty($data['filter_cireview_product_id'])) {
			$sql .= " AND r.product_id='". $data['filter_cireview_product_id'] ."'";
		}

		
		if (!empty($data['filter_cireviewsearch'])) {
			$sql .= " AND (";
			$implode = array();
			$implode1 = array();

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_cireviewsearch'])));

			foreach ($words as $word) {
				$implode[] = "r.author LIKE '%" . $this->db->escape($word) . "%'";
				if((int)$this->config->get('cireviewpro_reviewpagetitleshow')) {
					$implode1[] = "cr.title LIKE '%" . $this->db->escape($word) . "%'";
				}
			}

			if ($implode) {
				$sql .= " " . implode(" AND ", $implode) . "";
			}

			if ($implode1) {
				$sql .= " OR " . implode(" AND ", $implode1) . "";
			}
			
			$sql .= " OR r.text LIKE '%" . $this->db->escape($data['filter_cireviewsearch']) . "%'";

			$sql .= " OR r.product_id IN( SELECT sp.product_id FROM ". DB_PREFIX ."product sp LEFT JOIN ". DB_PREFIX ."product_description spd ON(sp.product_id=spd.product_id) LEFT JOIN ". DB_PREFIX ."product_to_store sp2s ON(sp.product_id=sp2s.product_id) WHERE sp.status=1 AND spd.language_id='". (int)$this->config->get('config_language_id') ."' AND sp2s.store_id='". (int)$this->config->get('config_store_id') ."' AND spd.name LIKE '%" . $this->db->escape($data['filter_cireviewsearch']) . "%' ) ";

			$sql .= ")";
		}
		

		if (!empty($data['filter_author'])) {
			$sql .= " AND (";

			if (!empty($data['filter_author'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_author'])));

				foreach ($words as $word) {
					$implode[] = "r.author LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_text'])) {
					$sql .= " OR r.text LIKE '%" . $this->db->escape($data['filter_author']) . "%'";
				}
			}

			$sql .= ")";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	
	public function getCustomerTotalReviews($customer_id, $product_id) {
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "cireview cr ON(cr.review_id=r.review_id) WHERE r.customer_id='". (int)$customer_id ."' AND r.product_id='". (int)$product_id ."'";

		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr.language_id='". (int)$this->config->get('config_language_id') ."'";
		}

		$query = $this->db->query($sql);
		/*remove active review because disabled review also be counted*/
		/*r.status=1 AND*/
		return $query;
	}
	
	
	public function getCouponByCode($code) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "coupon WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}

	public function addCoupon($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', discount = '" . (float)$data['discount'] . "', type = '" . $this->db->escape($data['type']) . "', total = '" . (float)$data['total'] . "', logged = '" . (int)$data['logged'] . "', shipping = '" . (int)$data['shipping'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', uses_total = '" . (int)$data['uses_total'] . "', uses_customer = '" . (int)$data['uses_customer'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$coupon_id = $this->db->getLastId();

		if (isset($data['coupon_product'])) {
			foreach ($data['coupon_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_product SET coupon_id = '" . (int)$coupon_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['coupon_category'])) {
			foreach ($data['coupon_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_category SET coupon_id = '" . (int)$coupon_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		return $coupon_id;
	}
	
	public function getAvgRatingOfProducts($product_id) {
		$sql = "SELECT AVG(r1.rating) AS total FROM " . DB_PREFIX . "review r1 LEFT JOIN " . DB_PREFIX . "cireview cr1 ON(cr1.review_id=r1.review_id) WHERE r1.status = '1' AND r1.product_id='". (int)$product_id ."'";
		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr1.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr1.language_id='". (int)$this->config->get('config_language_id') ."'";
		}		

		return $this->db->query($sql)->row['total'];
	}
	
	
	public function getCiReviewRatingAvg($ciratingtype_id, $product_id) {
		$sql = "SELECT AVG(r1.rating) AS total FROM " . DB_PREFIX . "cireview_rating r1 LEFT JOIN " . DB_PREFIX . "cireview cr ON(cr.cireview_id=r1.cireview_id) WHERE r1.status = '1' AND r1.ciratingtype_id='". (int)$ciratingtype_id ."' AND r1.product_id='". (int)$product_id ."'";

		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr.language_id='". (int)$this->config->get('config_language_id') ."'";
		}
		return $this->db->query($sql)->row['total'];
	}
	
	
	public function getProductReviewsByRating($product_id) {
		$sql = "SELECT COUNT(*) AS total, r.rating FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "cireview cr ON(cr.review_id=r.review_id) WHERE r.status=1 AND r.product_id='". (int)$product_id ."'";
		if($this->config->get('cireviewpro_is_multistore')) {
			$sql .= " AND cr.store_id='". (int)$this->config->get('config_store_id') ."'";
		}
		if($this->config->get('cireviewpro_is_multilanguage')) {
			$sql .= " AND cr.language_id='". (int)$this->config->get('config_language_id') ."'";
		}
		
		$sql .= " GROUP BY r.rating";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function addRewardPoints($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$this->customer->getId() . "', points = '" . (int)$data['reward_points'] . "', description = '" . $this->db->escape($data['description']) . "', date_added = NOW()");

		return $this->db->getLastId();
	}
	

	/*Cron function starts*/
	
	/*Cron function ends*/
	/*31-10-2018 verify purchase info start*/
	public function isRequirePurchaseFirst($product_id, array $order_statuses) {
		$query = $this->db->query("SELECT crv.cireview_verify_id FROM ". DB_PREFIX ."cireview_verify crv RIGHT JOIN `". DB_PREFIX ."order` o ON (o.order_id=crv.order_id) WHERE crv.customer_id='". (int)$this->customer->getId() ."' AND crv.review=0 AND crv.status=1 AND crv.product_id='". (int)$product_id ."' AND o.order_status_id IN ('". implode("','", $order_statuses) ."')");
		return ($query->num_rows > 0);
	}

	public function isProductRequirePurchase($product_id) {
		$query = $this->db->query("SELECT crv.cireview_verify_id FROM ". DB_PREFIX ."cireview_verify crv RIGHT JOIN `". DB_PREFIX ."order` o ON (o.order_id=crv.order_id) WHERE crv.customer_id='". (int)$this->customer->getId() ."' AND crv.review=0 AND crv.status=1 AND crv.product_id='". (int)$product_id ."'");
		return !($query->num_rows > 0);
	}
	public function isProductOrderCompleted($product_id, array $order_statuses) {
		$query = $this->db->query("SELECT crv.cireview_verify_id FROM ". DB_PREFIX ."cireview_verify crv RIGHT JOIN `". DB_PREFIX ."order` o ON (o.order_id=crv.order_id) WHERE crv.customer_id='". (int)$this->customer->getId() ."' AND crv.review=0 AND crv.status=1 AND crv.product_id='". (int)$product_id ."' AND o.order_status_id IN ('". implode("','", $order_statuses) ."')");
		return !($query->num_rows > 0);
	}
	public function getCiReviewVerify($review_id) {
		$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."cireview_verify crv WHERE crv.review_id = '". (int)$review_id ."' AND crv.status=1");
		return $query->row;
	}
	public function disableCiReviewVerify($order_id) {
		$query = $this->db->query("UPDATE ". DB_PREFIX ."cireview_verify SET status=0, date_modified=NOW() WHERE order_id = '". (int)$order_id ."'");
		return $query->row;
	}

	/*31-10-2018 verify purchase info end*/
	
	public function findSyncCustomerOldReviews($customer_id) {
		$this->load->model('account/customer');
		$customer_info = $this->model_account_customer->getCustomer($customer_id);
		if($customer_info) {
			$customer_reviews = $this->getReviewsByEmail($customer_info['email']);
			foreach ($customer_reviews as $review) {
				$this->db->query("UPDATE ". DB_PREFIX ."review SET customer_id='". (int)$customer_info['customer_id'] ."' WHERE review_id='". $review['review_id'] ."'");
			}
		}
	}

	public function getReviewsByEmail($email) {
		$query = $this->db->query("SELECT r.*, cr.cireview_id FROM ". DB_PREFIX ."review r LEFT JOIN ". DB_PREFIX ."cireview cr ON (cr.review_id=r.review_id) WHERE cr.email='". $this->db->escape($email) ."' AND r.customer_id=1 AND cr.review_id=r.review_id");
		return $query->rows;
	}

	public function timeElapsedString($datestring) {

		$datestring = strtotime($datestring);
		$elapestime = time() - $datestring;

		if ($elapestime < 1) {
			return $this->language->get('text_0second');
		}
		$a = array( 365 * 24 * 60 * 60  =>  'year',
					 30 * 24 * 60 * 60  =>  'month',
						  24 * 60 * 60  =>  'day',
							   60 * 60  =>  'hour',
									60  =>  'minute',
									 1  =>  'second'
					);
		$a_plural = array( 'year'   => $this->language->get('text_year'),
						   'month'  => $this->language->get('text_month'),
						   'day'    => $this->language->get('text_day'),
						   'hour'   => $this->language->get('text_hour'),
						   'minute' => $this->language->get('text_minute'),
						   'second' => $this->language->get('text_second')
					);

		foreach ($a as $secs => $str) {
			$d = $elapestime / $secs;
			if ($d >= 1) {
				$r = round($d);
				//return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
				return $r . ' ' . ( $a_plural[$str] ) .' ' . $this->language->get('text_ago');
			}
		}
	}
	
	
}