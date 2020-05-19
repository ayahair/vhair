<?php
class ModelSettingHbSitemap extends Model {
	
	public function getbatch($store_id){
			$sql = "SELECT *  FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE store_id = $store_id ORDER BY batch_id ASC";
			$query = $this->db->query($sql);
			if (isset($query->rows)){
				return $query->rows;
			}else{
				return false;
			}
	}
	
	public function getallbatch(){
			$sql = "SELECT *  FROM `" . DB_PREFIX . "hb_sitemap_batch` ORDER BY batch_id ASC";
			$query = $this->db->query($sql);
			if (isset($query->rows)){
				return $query->rows;
			}else{
				return false;
			}
	}

	
	public function getlink($store_id){
			$sql = "SELECT *  FROM `" . DB_PREFIX . "hb_sitemap_custom` WHERE store_id = $store_id ORDER BY date_added DESC";
			$query = $this->db->query($sql);
			if (isset($query->rows)){
				return $query->rows;
			}else{
				return false;
			}
	}

	
	public function checkproduct($store_id){
		$query = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "product_to_store` WHERE store_id = $store_id");
		return $query->row['count'];
	}
	
	public function checktag($store_id){
		$query = $this->db->query("SELECT count(*) as count FROM " . DB_PREFIX . "product_description a, " . DB_PREFIX . "product_to_store b WHERE a.product_id = b.product_id and b.store_id = $store_id and a.tag !=''");
		return $query->row['count'];
	}
	
	public function checkcategory($store_id){
			$query = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "category_to_store` WHERE store_id = $store_id");
		return $query->row['count'];
	}
	
	public function checkbrand($store_id){
		$query = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "manufacturer_to_store` WHERE store_id = $store_id");
		return $query->row['count'];
	}
	
	public function checkinfo($store_id){
			$query = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "information_to_store` WHERE store_id = $store_id");
		return $query->row['count'];
	}
	
	public function getsitemaps($store_id){
			$sql = "SELECT *  FROM `" . DB_PREFIX . "hb_sitemaps` WHERE store_id = $store_id";
			$query = $this->db->query($sql);
			if (isset($query->rows)){
				return $query->rows;
			}else{
				return false;
			}
	}


	/////////////////////////////////////////
	
	public function install(){
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hb_sitemaps` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `url` text NOT NULL,
		  `store_id` int(11) NOT NULL,
		  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
  		)DEFAULT CHARSET=utf8");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hb_sitemap_batch` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `batch_id` int(11) NOT NULL,
		  `min_range` varchar(20) NOT NULL,
		  `max_range` varchar(20) NOT NULL,
		  `count` int(11) NOT NULL,
		  `pstatus` int(11) NOT NULL,
		  `tstatus` int(11) NOT NULL DEFAULT '0',
		  `store_id` int(11) NOT NULL DEFAULT '0',
		  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)							
		)DEFAULT CHARSET=utf8");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hb_sitemap_custom` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `loc` text NOT NULL,
		  `freq` varchar(10) NOT NULL,
		  `priority` varchar(10) NOT NULL,
		  `store_id` int(11) NOT NULL,
		  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		)DEFAULT CHARSET=utf8");

		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_sitemap', 'hb_sitemap_max_entries', '3000', 0)");

	    $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'hb_sitemap_installer', 'hb_sitemap_installed', '1', '0')"); 
	
		//create directory
		$dir = "../hbsitemaps";
			if( is_dir($dir) === false )
			{
				mkdir($dir);
			}
	}
	
	public function uninstall() {
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "hb_sitemaps`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "hb_sitemap_batch`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "hb_sitemap_custom`");
	
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_sitemap'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_sitemap_installer'");
	}
	
	//SEO URL ALIAS
	public function defaultLanguage(){
		$query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` WHERE `code` = '".$this->config->get('config_language')."'");
		return $query->row['language_id'];
	}
	
	public function checkURLKeyword($keyword){
    	$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "url_alias` WHERE `keyword` = '".$keyword."'");
		return $results->row['count'];
	}
	
	public function generateSeoUrl($query, $seourl){
		$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` (`query`,`keyword`) VALUES ('".$this->db->escape($query)."', '".$this->db->escape($seourl)."')");
	}
	
	public function productDataView($language_id){
		$sql = "select `a`.`product_id` AS `product_id`,`b`.`name` AS `name`, `b`.`meta_title` AS `meta_title`,`b`.`meta_description` AS `meta_description`,`b`.`meta_keyword` AS `meta_keyword`,`b`.`tag` AS `tag`,`b`.`language_id` AS `language_id`,`a`.`model` AS `model`,`a`.`image` AS `image`,(select `" . DB_PREFIX . "manufacturer`.`name` from `" . DB_PREFIX . "manufacturer` where (`" . DB_PREFIX . "manufacturer`.`manufacturer_id` = `a`.`manufacturer_id`)) AS `brand`,`a`.`upc` AS `upc` from (`" . DB_PREFIX . "product` `a` join `" . DB_PREFIX . "product_description` `b`) where (`a`.`product_id` = `b`.`product_id`) and b.language_id = $language_id";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function categoryDataView($language_id){
		$sql = "SELECT a.category_id, b.name, b.language_id, b.meta_title, b.meta_description, b.meta_keyword  FROM `" . DB_PREFIX . "category` a, " . DB_PREFIX . "category_description b WHERE a.category_id = b.category_id and  b.language_id = $language_id";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getIViewBasic($language_id){
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "information_description` WHERE language_id = '".$language_id."'");
		return $results->rows;
	}
	
	public function getUrlkeyword($type, $id){
		$result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` where `query` = '".$type."=".$id."'");
		return $result->num_rows;
	}
	
	public function getMViewBasic(){
		$results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "manufacturer`");
		return $results->rows;
	}
	
	public function getCountAlias($page_type){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . "url_alias` WHERE query like ('".$page_type."=%')");
		return $results->row['count'];
	}
	
	public function getCountRecords($tablename, $language_id){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . $tablename."` WHERE language_id = '".$language_id."'");
		return $results->row['count'];
	}
	
	public function getCountRecordsNL($tablename){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . $tablename."`");
		return $results->row['count'];
	}
	
	public function clearURL($query){
		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` like('".$query."')");
	}

}
?>