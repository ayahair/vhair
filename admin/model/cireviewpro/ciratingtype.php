<?php
class ModelCiReviewProCiRatingType extends Model {

	public function addCiRatingType($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype SET status = '" . (int)$data['status'] . "'	, sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$ciratingtype_id = $this->db->getLastId();

		foreach ($data['ciratingtype_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_description SET ciratingtype_id = '" . (int)$ciratingtype_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['ciratingtype_store'])) {
			foreach ($data['ciratingtype_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_to_store SET ciratingtype_id = '" . (int)$ciratingtype_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['ciratingtype_product'])) {
			foreach ($data['ciratingtype_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_product SET ciratingtype_id = '" . (int)$ciratingtype_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['ciratingtype_manufacturer'])) {
			foreach ($data['ciratingtype_manufacturer'] as $manufacturer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_manufacturer SET ciratingtype_id = '" . (int)$ciratingtype_id . "', manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
		}

		if (isset($data['ciratingtype_category'])) {
			foreach ($data['ciratingtype_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_category SET ciratingtype_id = '" . (int)$ciratingtype_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		return $ciratingtype_id;
	}

	public function editCiRatingType($ciratingtype_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "ciratingtype SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_description WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		foreach ($data['ciratingtype_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_description SET ciratingtype_id = '" . (int)$ciratingtype_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_to_store WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		if (isset($data['ciratingtype_store'])) {
			foreach ($data['ciratingtype_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_to_store SET ciratingtype_id = '" . (int)$ciratingtype_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_product WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		if (isset($data['ciratingtype_product'])) {
			foreach ($data['ciratingtype_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_product SET ciratingtype_id = '" . (int)$ciratingtype_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_manufacturer WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		if (isset($data['ciratingtype_manufacturer'])) {
			foreach ($data['ciratingtype_manufacturer'] as $manufacturer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_manufacturer SET ciratingtype_id = '" . (int)$ciratingtype_id . "', manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_category WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		if (isset($data['ciratingtype_category'])) {
			foreach ($data['ciratingtype_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciratingtype_category SET ciratingtype_id = '" . (int)$ciratingtype_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->cache->delete('ciratingtype');

	}

	public function getCiRatingType($ciratingtype_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciratingtype p LEFT JOIN " . DB_PREFIX . "ciratingtype_description pd ON (p.ciratingtype_id = pd.ciratingtype_id) WHERE p.ciratingtype_id = '" . (int)$ciratingtype_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getCiRatingTypeDescriptions($ciratingtype_id) {
		$ciratingtype_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciratingtype_description WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		foreach ($query->rows as $result) {
			$ciratingtype_description_data[$result['language_id']] = $result;
		}

		return $ciratingtype_description_data;
	}
	public function getCiRatingTypes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ciratingtype p LEFT JOIN " . DB_PREFIX . "ciratingtype_description pd ON (p.ciratingtype_id = pd.ciratingtype_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$sql .= " AND p.date_added = '" . $this->db->escape($data['filter_date_added']) . "'";
		}

		$sql .= " GROUP BY p.ciratingtype_id";

		$sort_data = array(
			'pd.name',
			'p.status',
			'p.sort_order',
			'p.date_added',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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

	public function getTotalCiRatingTypes($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.ciratingtype_id) AS total FROM " . DB_PREFIX . "ciratingtype p LEFT JOIN " . DB_PREFIX . "ciratingtype_description pd ON (p.ciratingtype_id = pd.ciratingtype_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$sql .= " AND p.date_added = '" . $this->db->escape($data['filter_date_added']) . "'";
		}


		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getCiRatingTypeStores($ciratingtype_id) {
		$ciratingtype_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciratingtype_to_store WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		foreach ($query->rows as $result) {
			$ciratingtype_store_data[] = $result['store_id'];
		}

		return $ciratingtype_store_data;
	}

	public function getCiRatingTypeProducts($ciratingtype_id) {
		$ciratingtype_product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciratingtype_product WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		foreach ($query->rows as $result) {
			$ciratingtype_product_data[] = $result['product_id'];
		}

		return $ciratingtype_product_data;
	}

	public function getCiRatingTypeCategories($ciratingtype_id) {
		$ciratingtype_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciratingtype_category WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		foreach ($query->rows as $result) {
			$ciratingtype_category_data[] = $result['category_id'];
		}

		return $ciratingtype_category_data;
	}

	public function getCiRatingTypeManufacturers($ciratingtype_id) {
		$ciratingtype_manufacturer_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciratingtype_manufacturer WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");

		foreach ($query->rows as $result) {
			$ciratingtype_manufacturer_data[] = $result['manufacturer_id'];
		}

		return $ciratingtype_manufacturer_data;
	}

	public function deleteCiRatingType($ciratingtype_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_description WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_category WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_manufacturer WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_product WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciratingtype_to_store WHERE ciratingtype_id = '" . (int)$ciratingtype_id . "'");
	}

	public function Buildtable() {
		$inser_ciratingtype = false;

		if(!$this->config->has('cireviewpro_status')) {
			
			$query = $this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."ciratingtype'");
			if(!$query->num_rows) {
				$inser_ciratingtype = true;
			}

			
			/*--
			-- Table structure for table `" . DB_PREFIX . "ciabreason`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciabreason` (
			  `ciabreason_id` int(11) NOT NULL AUTO_INCREMENT,
			  `status` int(1) NOT NULL,
			  `details` int(11) NOT NULL,
			  `sort_order` int(11) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`ciabreason_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciabreason_category`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciabreason_category` (
			  `ciabreason_id` int(11) NOT NULL,
			  `category_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciabreason_id`,`category_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciabreason_description`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciabreason_description` (
			  `ciabreason_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  PRIMARY KEY (`ciabreason_id`,`language_id`),
			  KEY `name` (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciabreason_manufacturer`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciabreason_manufacturer` (
			  `ciabreason_id` int(11) NOT NULL,
			  `manufacturer_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciabreason_id`,`manufacturer_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciabreason_product`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciabreason_product` (
			  `ciabreason_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciabreason_id`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciabreason_to_store`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciabreason_to_store` (
			  `ciabreason_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciabreason_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciratingtype`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciratingtype` (
			  `ciratingtype_id` int(11) NOT NULL AUTO_INCREMENT,
			  `status` int(1) NOT NULL,
			  `sort_order` int(11) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`ciratingtype_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciratingtype_category`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciratingtype_category` (
			  `ciratingtype_id` int(11) NOT NULL,
			  `category_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciratingtype_id`,`category_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciratingtype_description`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciratingtype_description` (
			  `ciratingtype_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  PRIMARY KEY (`ciratingtype_id`,`language_id`),
			  KEY `name` (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciratingtype_manufacturer`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciratingtype_manufacturer` (
			  `ciratingtype_id` int(11) NOT NULL,
			  `manufacturer_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciratingtype_id`,`manufacturer_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciratingtype_product`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciratingtype_product` (
			  `ciratingtype_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciratingtype_id`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "ciratingtype_to_store`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ciratingtype_to_store` (
			  `ciratingtype_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`ciratingtype_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview`
			--*/
			
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview` (
			  `cireview_id` int(11) NOT NULL AUTO_INCREMENT,
			  `review_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `email` varchar(255) NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `comment` text NOT NULL,
			  `coupon_code` varchar(20) NOT NULL,
			  `coupon_id` int(11) NOT NULL,
			  `reward_points` int(11) NOT NULL,
			  `customer_reward_id` int(11) NOT NULL,
			  PRIMARY KEY (`cireview_id`,`review_id`,`product_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview_abuse`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_abuse` (
			  `cireview_abuse_id` int(11) NOT NULL AUTO_INCREMENT,
			  `cireview_id` int(11) NOT NULL,
			  `review_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `ciabreason_id` varchar(11) NOT NULL,
			  `ciabreason_name` varchar(255) NOT NULL,
			  `text` text NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `author` varchar(255) NOT NULL,
			  `status` int(11) NOT NULL,
			  `session_id` varchar(255) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`cireview_abuse_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview_image`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_image` (
			  `cireview_image_id` int(11) NOT NULL AUTO_INCREMENT,
			  `cireview_id` int(11) NOT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  `mask` varchar(255) DEFAULT NULL,
			  `ext` varchar(10) DEFAULT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `session_id` varchar(255) NOT NULL,
			  `status` int(11) NOT NULL,
			  PRIMARY KEY (`cireview_image_id`),
			  KEY `product_id` (`cireview_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview_invite`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_invite` (
			  `cireview_invite_id` int(11) NOT NULL AUTO_INCREMENT,
			  `last_reminder_id` int(11) NOT NULL,
			  `order_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `invite` tinyint(4) NOT NULL,
			  `review` tinyint(4) NOT NULL,
			  `review_id` int(11) NOT NULL,
			  `cireview_id` int(11) NOT NULL,
			  `status` int(11) NOT NULL,
			  `last_reminder_date_added` datetime NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`cireview_invite_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview_invitereminder`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_invitereminder` (
			  `cireview_invitereminder_id` int(11) NOT NULL AUTO_INCREMENT,
			  `cireview_invite_id` int(11) NOT NULL,
			  `reminder` tinyint(4) NOT NULL,
			  `date_added` datetime NOT NULL,
			  PRIMARY KEY (`cireview_invitereminder_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview_rating`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_rating` (
			  `cireview_rating_id` int(11) NOT NULL AUTO_INCREMENT,
			  `cireview_id` int(11) NOT NULL,
			  `review_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `ciratingtype_id` int(11) NOT NULL,
			  `ciratingtype_name` TEXT NOT NULL,
			  `rating` int(11) NOT NULL,
			  `status` int(11) NOT NULL,
			  PRIMARY KEY (`cireview_rating_id`,`cireview_id`,`review_id`,`product_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");
			

			/*--
			-- Table structure for table `" . DB_PREFIX . "cireview_vote`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_vote` (
			  `cireview_vote_id` int(11) NOT NULL AUTO_INCREMENT,
			  `cireview_id` int(11) NOT NULL,
			  `review_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `author` varchar(255) NOT NULL,
			  `vote` varchar(10) NOT NULL COMMENT 'UP,DOWN',
			  `status` int(11) NOT NULL,
			  `session_id` varchar(255) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`cireview_vote_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
			");


			/*--
			-- Table structure for table `oc_cireview_image_description`
			--*/

			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_image_description` (
			  `cireview_image_id` int(11) NOT NULL,
			  `cireview_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `alt` varchar(255) NOT NULL,
			  `session_id` varchar(255) NOT NULL,
			  PRIMARY KEY (`cireview_image_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");

			
			if($inser_ciratingtype) {


				$this->load->model('setting/store');
				$stores = $this->model_setting_store->getStores();
				$stores[] = array(
					'store_id' => '0',
					'name' => $this->language->get('text_default')
				);
				$ciratingtype_store = array();
				foreach($stores as $store) {
					$ciratingtype_store[] = $store['store_id'];
				}

				$this->load->model('localisation/language');
				$languages = $this->model_localisation_language->getLanguages();
				$ciratingtype_description = array();
				foreach ($languages as $language) {
					$ciratingtype_description[$language['language_id']] = array(
						'name' => 'Rating',
					);
				}

				$data = array(
					'status' => 1,
					'sort_order' => 1,
					'ciratingtype_store' => $ciratingtype_store,
					'ciratingtype_description' => $ciratingtype_description,
				);
				$this->addCiRatingType($data);
				
			}
			
		}

		$updateverified = false;
		$query = $this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."cireview_verify'");
		if(!$query->num_rows) {
			/*--
			-- Table structure for table `oc_cireview_verify`
			--*/
			
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cireview_verify` (
			  `cireview_verify_id` int(11) NOT NULL AUTO_INCREMENT,
			  `order_id` int(11) NOT NULL,
			  `order_product_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `review` tinyint(4) NOT NULL,
			  `review_id` int(11) NOT NULL,
			  `cireview_id` int(11) NOT NULL,
			  `status` int(11) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`cireview_verify_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			

			$updateverified = true;
		}

		/*01-11-2018 We may remove below show columns code in near future, as of we assume most clients have update to new version and will not face issue, if update again after removing the code*/
		
		/*here we check if table is exists but columns are not present, then create new columns*/
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='customer_reward_id'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `customer_reward_id` INT NOT NULL AFTER `coupon_code`");
		}


		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='reward_points'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `reward_points` INT NOT NULL AFTER `coupon_code`");
		}

		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='coupon_id'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `coupon_id` INT NOT NULL AFTER `coupon_code`");
		}
		
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='store_id'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `store_id` INT NOT NULL AFTER `product_id`");
		}
		
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview_image` WHERE Field='mask'");		
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview_image` ADD `mask` VARCHAR(255) NOT NULL AFTER `image`");
		}

		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview_image` WHERE Field='ext'");		
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview_image` ADD `ext` VARCHAR(10) NOT NULL AFTER `mask`");
		}
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='language_id'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `language_id` INT NOT NULL AFTER `product_id`");


			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language`");

			$languages = array();
			foreach ($query->rows as $result) {
				$languages[$result['code']] = $result;
			}

			$languge_code = $this->config->get('config_language');
			if($languge_code == null || empty($languge_code)) {
				$languge_code = $this->config->get('config_admin_language');
			}

			if(isset($languages[$languge_code])) {				
				$this->db->query("UPDATE `" . DB_PREFIX . "cireview` SET `language_id`='". (int)$languages[$languge_code]['language_id'] ."' WHERE language_id=0");
			}

		}

		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='imp'");		
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `imp` INT(1) NOT NULL AFTER `product_id`");
		}

		/*29-08-2018*/
		/*add reminder id column in invite table. So we can track count of reminders send*/
		$verified_status_updates = false;
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview_invite` WHERE Field='last_reminder_id'");		
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview_invite` ADD `last_reminder_id` INT NOT NULL AFTER `cireview_invite_id`");
			$verified_status_updates = true;
		}

		/*add last reminder date added. so that we can track last date of invite send and do not send more invites if resend invite emails option enable.*/
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview_invite` WHERE Field='last_reminder_date_added'");		
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview_invite` ADD `last_reminder_date_added` datetime NOT NULL AFTER `status`");
			$verified_status_updates = true;
		}

		/*add verified and verified_order_id. so that verified purchase does not get affedted when admin delete invite log from admin.*/
		/* 31-10-2018 verify purchase below method was incorrect. So we rolling out these columns and delete this code in 31-01-2019*/
		/*$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='verified'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `verified` tinyint(1) NOT NULL AFTER `review_id`");
			$verified_status_updates = true;
		}
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cireview` WHERE Field='verified_order_id'");
		if(!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "cireview` ADD `verified_order_id` int NOT NULL AFTER `review_id`");
			$verified_status_updates = true;
		}*/
		

		if($verified_status_updates) {
			$this->updateInvitesReminderDate();
		}

		if($updateverified) {
			$this->updateVerified();
		}
		/*29-08-2018*/
		$this->reviewSync();

	}

	/*We need to update verified column as per previous invite log base on cireview_id */
	public function updateVerified() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_invite cri WHERE cri.review=1");
		foreach ($query->rows as $row) {
			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id='". $row['order_id'] ."' AND product_id='". $row['product_id'] ."'");
			$order_product_id = 0;
			if($order_product_query->row) {
				$order_product_id = $order_product_query->row['order_product_id'];
			}


			$cireview_verify_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_verify WHERE order_id='". $row['order_id'] ."' AND product_id='". $row['product_id'] ."'");
			if(!$cireview_verify_query->num_rows) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "cireview_verify SET order_id='". $row['order_id'] ."', product_id='". $row['product_id'] ."', order_product_id='". $order_product_id ."', store_id='". $row['store_id'] ."', customer_id='". $row['customer_id'] ."', review_id='". $row['review_id'] ."', cireview_id='". $row['cireview_id'] ."', review='". $row['review'] ."', status='". $row['status'] ."', date_added='". $row['date_added'] ."', date_modified='". $row['date_modified'] ."'");
			}
		}
	}

	public function updateInvitesReminderDate() {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "cireview_invite SET last_reminder_date_added=date_added");
	}

	public function updateInvitesLastReminderID() {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "cireview_invite ci SET last_reminder_id=(SELECT cir.cireview_invitereminder_id FROM " . DB_PREFIX . "cireview_invitereminder cir WHERE cir.cireview_invite_id=ci.cireview_invite_id ORDER BY cir.cireview_invitereminder_id DESC LIMIT 0,1 ) WHERE ci.last_reminder_id=0");
	}
	
	public function requireSync() {
		$review_query = $this->db->query("SELECT count(*) as total FROM " . DB_PREFIX . "review");	
		$cirevew_query = $this->db->query("SELECT count(*) as total FROM " . DB_PREFIX . "cireview");	

		return ($review_query->row['total'] > $cirevew_query->row['total']);
	}

	public function reviewSync() {
		/*
		SELECT r.review_id FROM oc_review r LEFT OUTER JOIN oc_cireview cr ON cr.review_id = r.review_id WHERE cr.review_id IS NULL 
		SELECT r.review_id FROM oc_review r where r.review_id NOT in (SELECT cr.review_id FROM oc_cireview cr)
		*/
		$query = $this->db->query("SELECT r.review_id FROM " . DB_PREFIX . "review r where r.review_id NOT IN (SELECT cr.review_id FROM " . DB_PREFIX . "cireview cr)");	
		foreach ($query->rows as $row) {
			
			$review_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "review WHERE review_id='". (int)$row['review_id'] ."'");

			$email = '';
			if($review_query->row['customer_id']) {
				$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id='". (int)$review_query->row['customer_id'] ."'");
				if($customer_query->num_rows) {
					$email = $customer_query->row['email'];
				}
			}

			$this->db->query("INSERT INTO " . DB_PREFIX . "cireview SET review_id='". (int)$row['review_id'] ."', product_id='". (int)$review_query->row['product_id'] ."', email='". $this->db->escape($email) ."', store_id='". (int)$this->config->get('config_store_id') ."', language_id='". (int)$this->config->get('config_language_id') ."'");
		}
	}
	

}