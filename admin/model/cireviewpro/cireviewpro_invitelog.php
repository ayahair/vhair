<?php
class ModelCiReviewProCiReviewProInviteLog extends Model {
	
	public function getCiReviewsInvite($cireview_invite_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_invite cri WHERE cri.cireview_invite_id='". (int)$cireview_invite_id ."'"); /* AND cri.status=1*/
		return $query->row;
	}
	public function getCiReviewsInviteReminders($cireview_invite_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cireview_invitereminder crir WHERE crir.cireview_invite_id='". (int)$cireview_invite_id ."'");
		return $query->rows;
	}
	public function getCiReviewsInvites($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "cireview_invite cri WHERE cri.cireview_invite_id>0"; /*AND cri.status=1*/
		if (!empty($data['filter_order_id'])) {
			$sql .= " AND cri.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		if (!empty($data['filter_product'])) {
			$sql .= " AND cri.product_id IN (SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id=pd.product_id) WHERE pd.name LIKE '%". $this->db->escape($data['filter_product']) ." %' )";
		}
		if (!empty($data['filter_customer'])) {
			$sql .= " AND (cri.customer_id IN (SELECT c.customer_id FROM " . DB_PREFIX . "customer c WHERE CONCAT(c.firstname, ' ', c.lastname) LIKE '%". $this->db->escape($data['filter_customer']) ."%' ) OR (cri.customer_id=0 AND cri.order_id IN (SELECT o.order_id FROM " . DB_PREFIX . "order o WHERE CONCAT(o.firstname, ' ', O.lastname) LIKE '%". $this->db->escape($data['filter_customer']) ."%' ) ) )";
		}
		if (isset($data['filter_store_id']) && !is_null($data['filter_store_id'])) {
			$sql .= " AND cri.store_id = '" . (int)$data['filter_store_id'] . "'";
		}
		if (isset($data['filter_review_given']) && !is_null($data['filter_review_given'])) {
			$sql .= " AND cri.review = '" . (int)$data['filter_review_given'] . "'";
		}
		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(cri.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(cri.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}
		$sort_data = array(
			'cri.cireview_invite_idPrimary',			
			'cri.status',
			'cri.review',
			'cri.date_added',
			'cri.date_modified',
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cri.date_added";
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
	public function getTotalCiReviewsInvites($data = array()) {
		$sql = "SELECT COUNT(DISTINCT cri.cireview_invite_id) AS total FROM " . DB_PREFIX . "cireview_invite cri WHERE cri.cireview_invite_id>0"; /*AND cri.status=1*/
		if (!empty($data['filter_order_id'])) {
			$sql .= " AND cri.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		if (!empty($data['filter_product'])) {
			$sql .= " AND cri.product_id IN (SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id=pd.product_id) WHERE pd.name LIKE '%". $this->db->escape($data['filter_product']) ." %' )";
		}
		if (!empty($data['filter_customer'])) {
			$sql .= " AND (cri.customer_id IN (SELECT c.customer_id FROM " . DB_PREFIX . "customer c WHERE CONCAT(c.firstname, ' ', c.lastname) LIKE '%". $this->db->escape($data['filter_customer']) ."%' ) OR (cri.customer_id=0 AND cri.order_id IN (SELECT o.order_id FROM " . DB_PREFIX . "order o WHERE CONCAT(o.firstname, ' ', O.lastname) LIKE '%". $this->db->escape($data['filter_customer']) ."%' ) ) )";
		}
		if (isset($data['filter_store_id']) && !is_null($data['filter_store_id'])) {
			$sql .= " AND cri.store_id = '" . (int)$data['filter_store_id'] . "'";
		}
		if (isset($data['filter_review_given']) && !is_null($data['filter_review_given'])) {
			$sql .= " AND cri.review = '" . (int)$data['filter_review_given'] . "'";
		}
				
		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(cri.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(cri.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function updateInviteLog($cireview_invite_id, $column, $value) {
		$this->db->query("UPDATE " . DB_PREFIX . "cireview_invite SET `". $column ."`='". $this->db->escape($value) ."', date_modified=NOW() WHERE cireview_invite_id='". (int)$cireview_invite_id ."'");
	}

	public function deleteCiReviewInvite($cireview_invite_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cireview_invite WHERE cireview_invite_id='". (int)$cireview_invite_id ."'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "cireview_invitereminder WHERE cireview_invite_id='". (int)$cireview_invite_id ."'");
	}
}