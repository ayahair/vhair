<?php
class ModelSeoHbSeo extends Model {
    
	public function getLanguages($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "language";

			$sort_data = array(
				'name',
				'code',
				'sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY sort_order, name";
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
		} else {
			$language_data = $this->cache->get('language');

			if (!$language_data) {
				$language_data = array();

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY sort_order, name");

				foreach ($query->rows as $result) {
					$language_data[$result['code']] = array(
						'language_id' => $result['language_id'],
						'name'        => $result['name'],
						'code'        => $result['code'],
						'locale'      => $result['locale'],
						'image'       => $result['image'],
						'directory'   => $result['directory'],
						'sort_order'  => $result['sort_order'],
						'status'      => $result['status']
					);
				}

				$this->cache->set('language', $language_data);
			}

			return $language_data;
		}
	}
	//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^6
	//getting data view
	//getting all the product view w.r.t. language
	public function productDataView($language_id,$min,$max){
		if ($min == 0 and $max == 0){
			$sql = "select `a`.`product_id` AS `product_id`,`b`.`name` AS `name`, `b`.`meta_title` AS `meta_title`,`b`.`meta_description` AS `meta_description`,`b`.`meta_keyword` AS `meta_keyword`,`b`.`tag` AS `tag`,`b`.`language_id` AS `language_id`,`a`.`model` AS `model`,`a`.`image` AS `image`,(select `" . DB_PREFIX . "manufacturer`.`name` from `" . DB_PREFIX . "manufacturer` where (`" . DB_PREFIX . "manufacturer`.`manufacturer_id` = `a`.`manufacturer_id`)) AS `brand`,`a`.`upc` AS `upc` from (`" . DB_PREFIX . "product` `a` join `" . DB_PREFIX . "product_description` `b`) where (`a`.`product_id` = `b`.`product_id`) and b.language_id = $language_id";
		}else{
			$sql = "select `a`.`product_id` AS `product_id`,`b`.`name` AS `name`, `b`.`meta_title` AS `meta_title`,`b`.`meta_description` AS `meta_description`,`b`.`meta_keyword` AS `meta_keyword`,`b`.`tag` AS `tag`,`b`.`language_id` AS `language_id`,`a`.`model` AS `model`,`a`.`image` AS `image`,(select `" . DB_PREFIX . "manufacturer`.`name` from `" . DB_PREFIX . "manufacturer` where (`" . DB_PREFIX . "manufacturer`.`manufacturer_id` = `a`.`manufacturer_id`)) AS `brand`,`a`.`upc` AS `upc` from (`" . DB_PREFIX . "product` `a` join `" . DB_PREFIX . "product_description` `b`) where (`a`.`product_id` = `b`.`product_id`) and b.language_id = $language_id and a.product_id >= $min and a.product_id <= $max ORDER BY a.product_id ASC ";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	//getting all the category view w.r.t. language
	public function categoryDataView($language_id){
		$sql = "SELECT a.category_id, b.name, b.language_id, b.meta_title, b.meta_description, b.meta_keyword  FROM `" . DB_PREFIX . "category` a, " . DB_PREFIX . "category_description b WHERE a.category_id = b.category_id and  b.language_id = $language_id";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getCategoriesName($product_id,$language_id){
		$results = $this->db->query("SELECT group_concat((select name from " . DB_PREFIX . "category_description where category_id = a.category_id and language_id = ".$language_id.") separator ' | ')as category FROM `" . DB_PREFIX . "product_to_category` a where product_id = '".$product_id."' group by product_id");
		if (isset($results->row['category'])){
			return $results->row['category'];
		}else{
			return false;
		}
	}
	
	//getting all the information view w.r.t. language
	public function getIViewBasic($language_id){
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "information_description` WHERE language_id = '".$language_id."'");
		return $results->rows;
	}
	
	//getting all the brand view . Note that default opencart structure doesn't have langauge for brands
	public function getMViewBasic(){
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "manufacturer`");
		return $results->rows;
	}
	
	
	//checking if value already exists
	public function getCheckSeo($tablename, $columnname, $id_column_name, $id, $language_id){
		$results = $this->db->query("SELECT `".$columnname."` FROM `" . DB_PREFIX . $tablename."` WHERE `".$id_column_name."` = '".$id."' and language_id = '".$language_id."' LIMIT 1");
		if (($results->row[$columnname] === NULL) or ($results->row[$columnname] == '')){
			return 0;
		}else { return 1 ;}
	}
	
	//update row to insert seo into the column
	public function insertSeo($tablename, $columnname, $id_column_name, $id, $value, $language_id){
		$this->db->query("UPDATE `" . DB_PREFIX . $tablename."` SET `".$columnname."` = '".$this->db->escape($value)."' WHERE `".$id_column_name."` = '".$id."' and language_id = '".$language_id."'");
	}

	//clear seo
	public function clearSeo($tablename, $columnname, $language_id){
		$this->db->query("UPDATE `" . DB_PREFIX . $tablename."` SET `".$columnname."` = '' WHERE language_id = '".$language_id."'");
	}
	
	
	///////////////////////////////////////////////////////////////////
	public function defaultLanguage(){
		$query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` WHERE `code` = '".$this->config->get('config_language')."'");
		return $query->row['language_id'];
	}

}
?>