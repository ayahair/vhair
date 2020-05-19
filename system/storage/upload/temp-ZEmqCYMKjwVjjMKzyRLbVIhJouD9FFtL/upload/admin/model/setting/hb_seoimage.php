<?php
class ModelSettingHbSeoimage extends Model {
	
	public function getbatch(){
			$sql = "SELECT *  FROM `" . DB_PREFIX . "hb_seoimage_batch` ORDER BY batch_id ASC";
			$query = $this->db->query($sql);
			if (isset($query->rows)){
				return $query->rows;
			}else{
				return false;
			}
	}
	
	//getting the product view w.r.t. language
	public function productDataView($language_id){
		$sql = "select `a`.`product_id` AS `product_id`,`b`.`name` AS `name`, `a`.`image` AS `image` from `" . DB_PREFIX . "product` `a` join `" . DB_PREFIX . "product_description` `b` where (`a`.`product_id` = `b`.`product_id`) and b.language_id = $language_id";
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
	
	public function checkimagename($image){
    	$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "product` WHERE `image` = '".$this->db->escape($image)."'");
		return $results->row['count'];
	}
	
	public function generatepimgrename($image, $newname){
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET image = '".$this->db->escape($newname)."' WHERE image = '".$this->db->escape($image)."'");
		$this->db->query("UPDATE `" . DB_PREFIX . "product_image` SET image = '".$this->db->escape($newname)."' WHERE image = '".$this->db->escape($image)."'");
	}


	/////////////////////////////////////////
	
	public function install(){
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hb_seoimage_batch` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `batch_id` int(11) NOT NULL,
		  `min_range` varchar(20) NOT NULL,
		  `max_range` varchar(20) NOT NULL,
		  `count` int(11) NOT NULL,
		  `status` int(11) NOT NULL,
		  `astatus` int(11) NOT NULL,
		  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)							
		)DEFAULT CHARSET=utf8");
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seoimage', 'hb_seoimage_max_entries', '3000', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seoimage', 'hb_seoimage_language', '1', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seoimage', 'hb_seoimage_target_folder', 'catalog/products/', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seoimage', 'hb_seoimage_unassigned_folder', 'others', 0)");

	    $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'hb_seoimage_installer', 'hb_seoimage_installed', '1', '0')"); 
	}
	
	public function uninstall() {
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "hb_seoimage_batch`");
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_seoimage'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_seoimage_installer'");
	}

}
?>