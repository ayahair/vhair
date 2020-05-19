<?php
class ModelSettingHbTags extends Model {
    
	//getting data view
	public function getProductInfo($language_id){
		$results = $this->db->query("select `a`.`product_id` AS `product_id`,`b`.`name` AS `name`,`b`.`tag` AS `tag`,`a`.`model` AS `model`,(select `" . DB_PREFIX . "manufacturer`.`name` from `" . DB_PREFIX . "manufacturer` where (`" . DB_PREFIX . "manufacturer`.`manufacturer_id` = `a`.`manufacturer_id`)) AS `brand`,`a`.`upc` AS `upc` from (`" . DB_PREFIX . "product` `a` join `" . DB_PREFIX . "product_description` `b`) where (`a`.`product_id` = `b`.`product_id`) and b.language_id = ".$language_id);
		if (isset($results->rows)){
			return $results->rows;	
		}else {
			return false;
		}

	}
	
	//getting all the category view w.r.t. language	
	public function getCategoriesName($product_id,$language_id){
		$results = $this->db->query("SELECT group_concat((select name from " . DB_PREFIX . "category_description where category_id = a.category_id and language_id = ".$language_id.") separator ', ')as category FROM `" . DB_PREFIX . "product_to_category` a where product_id = '".$product_id."' group by product_id");
		if (isset($results->row['category'])){
			return $results->row['category'];
		}else{
			return false;
		}
	}
	
	
	//update row to insert tags into the column
	
	public function generateTags($product_id, $tags, $language_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET tag = '".$this->db->escape($tags)."' WHERE product_id = '".$product_id."' and language_id = '".$language_id."'");
	}

	//clear tags
	public function clearTags($language_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET tag = '' WHERE language_id = '".$language_id."'");
	}
	
	//count records
	public function getCountRecords($language_id){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "product_description` WHERE language_id = '".$language_id."'");
		return $results->row['count'];
	}
	
	public function getCountTags($language_id){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX ."product_description` WHERE language_id = '".$language_id."' and `tag` IS NOT NULL AND `tag` <> '' ");
		return $results->row['count'];
	}
	
	
	///////////////////////////////////////////////////////////////////
	public function defaultLanguage(){
		$query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` WHERE `code` = '".$this->config->get('config_language')."'");
		return $query->row['language_id'];
	}
	
	/////////////////////////////////////////
	
	//initial install
	public function install(){
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		//$code_column = 'group';// uncomment if opencart 1.5.x
		
		//initial values
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language){	
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES ('0', 'hb_tags', 'hb_tags_parameter_".$language['language_id']."', '{p*} , {c*},{p}, {c}, {b}', '0');");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES ('0', 'hb_tags', 'hb_tags_stopwords_".$language['language_id']."', 'i,is,was,there,where,for,from,to,become,www,the,of', '0');");
		}
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'hb_tags', 'hb_tags_auto', '0', '0')"); 

		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'hb_tags_install', 'hb_tags_installer', '1', '0')"); 
	}
	
	public function uninstall() {
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		//$code_column = 'group';// uncomment if opencart 1.5.x
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_tags'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_tags_install'");
	}

}
?>