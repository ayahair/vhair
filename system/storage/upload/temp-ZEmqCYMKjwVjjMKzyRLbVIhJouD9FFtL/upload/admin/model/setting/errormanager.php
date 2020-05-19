<?php
class ModelSettingErrorManager extends Model {
	public function install(){
	if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
	}
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "error`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "error_logs`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "error` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `error` text NOT NULL,
			  `redirect` text,
			  `type` int(11) NOT NULL DEFAULT '301',
			  `author` int(11) NOT NULL DEFAULT '3',
			  `hits` int(11) NOT NULL DEFAULT '1',
			  `redirect_hits` int(11) NOT NULL DEFAULT '0',
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			)");
			
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "error_logs` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `error` text NOT NULL,
			  `referrer` text,
			  `user_agent` text,
			  `ip` varchar(20) DEFAULT NULL,
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			)");
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES ('0', '404_error_manager', 'error_manager_installed', '1', '0')");
	}
	
	public function upgrade(){
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "error` ADD `type` INT NOT NULL DEFAULT '301' AFTER `redirect`, ADD `author` INT NOT NULL DEFAULT '3' AFTER `type`;");
	}
	
	public function uninstall() {
	if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "error`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "error_logs`");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = '404_error_manager'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_404'");
	}
	
	public function getRecords($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "error`";
		
		if (empty($data['type']) and empty($data['author']) and empty($data['link'])) {
			$sql = $sql ;
		}else{
			$sql .= " WHERE ";
			if ($data['type'] <> 0){
				$sql .= " `type` =  ".$data['type']." AND ";
			}
			
			if ($data['author'] <> 0){
				$sql .= " `author` =  ".$data['author']." AND ";
			}
			
			if ($data['link'] == 1){
				$sql .= " (redirect IS NULL or redirect = '') ";
			}elseif ($data['link'] == 2){
				$sql .= " redirect IS NOT NULL and redirect <> '' ";
			}elseif ($data['link'] == 0){
				$sql .= " 1 = 1 ";
			}
		}

		$sort_data = array(
			'hits',
			'date_modified'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_modified";
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

	public function getTotalRecords($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "error`";

		if (empty($data['type']) and empty($data['author']) and empty($data['link'])) {
			$sql = $sql ;
		}else{
			$sql .= " WHERE ";
			if ($data['type'] <> 0){
				$sql .= " `type` =  ".$data['type']." AND ";
			}
			
			if ($data['author'] <> 0){
				$sql .= " `author` =  ".$data['author']." AND ";
			}
			
			if ($data['link'] == 1){
				$sql .= " (redirect IS NULL or redirect = '') ";
			}elseif ($data['link'] == 2){
				$sql .= " redirect IS NOT NULL and redirect <> '' ";
			}elseif ($data['link'] == 0){
				$sql .= " 1 = 1 ";
			}
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function deleteRecord($id) {
		
		$query = $this->db->query("SELECT `error` FROM `" . DB_PREFIX . "error` WHERE id = '" . (int)$id . "'");
		$error = $query->row['error'];
		$this->db->query("DELETE FROM `" . DB_PREFIX . "error` WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "error_logs` WHERE `error` = '".$this->db->escape($error)."'");
	}
	
	public function updateRecord($id, $redirect, $type = '301') {
		$this->db->query("UPDATE `" . DB_PREFIX . "error` SET redirect = '".$this->db->escape($redirect)."',`type` = '".$type."' WHERE id = '" . (int)$id . "'");
	}
	
	
	public function checkRedirect($id, $redirect) {
		$result = $this->db->query("SELECT `error` FROM `" . DB_PREFIX . "error` WHERE id = '" . (int)$id . "' LIMIT 1");
		if ($result->row['error'] == urlencode($redirect)){
			return false;
		}else{
			return true;
		}
		
	}
	
	public function insertRecord($error, $redirect, $type = '301', $author = 3) {
		$query = $this->db->query("SELECT id FROM `" . DB_PREFIX . "error` WHERE error = '".$this->db->escape($error)."'");
		
		if ($query->num_rows > 0){
			$id = $query->row['id'];
			$this->db->query("UPDATE `" . DB_PREFIX . "error` SET redirect = '".$this->db->escape($redirect)."', hits = hits+1, `type` = '".$type."', `author` = '".$author."' WHERE id = '" . (int)$id . "'");
		}else{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "error` (error,redirect,type,author,date_modified) VALUES ('".$this->db->escape($error)."','".$this->db->escape($redirect)."','".$type."','".$author."', now())");
		}
	}
	
	public function getReferrers($id) {
		$query = $this->db->query("SELECT referrer, user_agent, date_added as `datetime` FROM `" . DB_PREFIX . "error_logs` WHERE `error` = 
		(SELECT error from `" . DB_PREFIX . "error` WHERE id = '".(int)$id."')");
		return $query->rows;
	}
}
?>