<?php
class ModelCiReviewProCiAbReason extends Model {

	public function addCiAbReason($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason SET status = '" . (int)$data['status'] . "', details = '" . (int)$data['details'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$ciabreason_id = $this->db->getLastId();

		foreach ($data['ciabreason_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_description SET ciabreason_id = '" . (int)$ciabreason_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['ciabreason_store'])) {
			foreach ($data['ciabreason_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_to_store SET ciabreason_id = '" . (int)$ciabreason_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['ciabreason_product'])) {
			foreach ($data['ciabreason_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_product SET ciabreason_id = '" . (int)$ciabreason_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['ciabreason_manufacturer'])) {
			foreach ($data['ciabreason_manufacturer'] as $manufacturer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_manufacturer SET ciabreason_id = '" . (int)$ciabreason_id . "', manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
		}

		if (isset($data['ciabreason_category'])) {
			foreach ($data['ciabreason_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_category SET ciabreason_id = '" . (int)$ciabreason_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->cache->delete('ciabreason');

		return $ciabreason_id;
	}

	public function editCiAbReason($ciabreason_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "ciabreason SET status = '" . (int)$data['status'] . "', details = '" . (int)$data['details'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_description WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		foreach ($data['ciabreason_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_description SET ciabreason_id = '" . (int)$ciabreason_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_to_store WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		if (isset($data['ciabreason_store'])) {
			foreach ($data['ciabreason_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_to_store SET ciabreason_id = '" . (int)$ciabreason_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_product WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		if (isset($data['ciabreason_product'])) {
			foreach ($data['ciabreason_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_product SET ciabreason_id = '" . (int)$ciabreason_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_manufacturer WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		if (isset($data['ciabreason_manufacturer'])) {
			foreach ($data['ciabreason_manufacturer'] as $manufacturer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_manufacturer SET ciabreason_id = '" . (int)$ciabreason_id . "', manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_category WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		if (isset($data['ciabreason_category'])) {
			foreach ($data['ciabreason_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ciabreason_category SET ciabreason_id = '" . (int)$ciabreason_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->cache->delete('ciabreason');

	}

	public function deleteCiAbReason($ciabreason_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_description WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ciabreason_to_store WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");
	}

	public function getCiAbReason($ciabreason_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ciabreason p LEFT JOIN " . DB_PREFIX . "ciabreason_description pd ON (p.ciabreason_id = pd.ciabreason_id) WHERE p.ciabreason_id = '" . (int)$ciabreason_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getCiAbReasonDescriptions($ciabreason_id) {
		$ciabreason_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciabreason_description WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		foreach ($query->rows as $result) {
			$ciabreason_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
			);
		}

		return $ciabreason_description_data;
	}
	public function getCiAbReasons($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ciabreason p LEFT JOIN " . DB_PREFIX . "ciabreason_description pd ON (p.ciabreason_id = pd.ciabreason_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$sql .= " AND p.date_added = '" . $this->db->escape($data['filter_date_added']) . "'";
		}

		$sql .= " GROUP BY p.ciabreason_id";

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

	public function getTotalCiAbReasons($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.ciabreason_id) AS total FROM " . DB_PREFIX . "ciabreason p LEFT JOIN " . DB_PREFIX . "ciabreason_description pd ON (p.ciabreason_id = pd.ciabreason_id)";

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

	public function getCiAbReasonStores($ciabreason_id) {
		$ciabreason_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciabreason_to_store WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		foreach ($query->rows as $result) {
			$ciabreason_store_data[] = $result['store_id'];
		}

		return $ciabreason_store_data;
	}

	public function getCiAbReasonProducts($ciabreason_id) {
		$ciabreason_product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciabreason_product WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		foreach ($query->rows as $result) {
			$ciabreason_product_data[] = $result['product_id'];
		}

		return $ciabreason_product_data;
	}

	public function getCiAbReasonCategories($ciabreason_id) {
		$ciabreason_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciabreason_category WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		foreach ($query->rows as $result) {
			$ciabreason_category_data[] = $result['category_id'];
		}

		return $ciabreason_category_data;
	}

	public function getCiAbReasonManufacturers($ciabreason_id) {
		$ciabreason_manufacturer_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ciabreason_manufacturer WHERE ciabreason_id = '" . (int)$ciabreason_id . "'");

		foreach ($query->rows as $result) {
			$ciabreason_manufacturer_data[] = $result['manufacturer_id'];
		}

		return $ciabreason_manufacturer_data;
	}

	public function Buildtable() {

	}

}