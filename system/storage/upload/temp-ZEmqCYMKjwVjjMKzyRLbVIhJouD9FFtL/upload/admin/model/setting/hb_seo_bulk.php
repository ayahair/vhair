<?php
class ModelSettingHbSeoBulk extends Model {
	
	///////////////////////////////////////////////////////////////////
	public function defaultLanguage(){
		$query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` WHERE `code` = '".$this->config->get('config_language')."'");
		return $query->row['language_id'];
	}
	
	public function getCountRecords($tablename, $language_id){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . $tablename."` WHERE language_id = '".$language_id."'");
		return $results->row['count'];
	}
	
	public function getCountRecordsNL($tablename){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . $tablename."`");
		return $results->row['count'];
	}
	
	public function getCountNullRecords($tablename, $columnname, $language_id){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . $tablename."` WHERE language_id = '".$language_id."' and `".$columnname."` IS NOT NULL and `".$columnname."` <> '' ");
		return $results->row['count'];
	}
	public function getCountNullRecordsNL($tablename, $columnname){
		$results = $this->db->query("SELECT count(*) as count FROM `" . DB_PREFIX . $tablename."` WHERE `".$columnname."` IS NOT NULL and `".$columnname."` <> '' ");
		return $results->row['count'];
	}
	/////////////////////////////////////////
	
	//initial install
	public function install(){
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		$store_name = $this->config->get('config_name');
		
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` 
			ADD `custom_h1` VARCHAR(500) NULL AFTER `meta_keyword`, 
			ADD `custom_h2` VARCHAR(250) NULL AFTER `custom_h1`, 
			ADD `img_alt` VARCHAR(250) NULL AFTER `custom_h2`");
			
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` 
			ADD `custom_h1` VARCHAR(500) NULL AFTER `meta_keyword`, 
			ADD `custom_h2` VARCHAR(250) NULL AFTER `custom_h1`, 
			ADD `img_alt` VARCHAR(250) NULL AFTER `custom_h2`");
			
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "manufacturer` 
		ADD `brand_description` TEXT NOT NULL AFTER `image`, 
		ADD `custom_title` VARCHAR(100) NULL AFTER `brand_description`, 
		ADD `custom_h1` VARCHAR(250) NULL AFTER `custom_title`, 
		ADD `custom_h2` VARCHAR(250) NULL AFTER `custom_h1`, 
		ADD `brand_meta_description` VARCHAR(300) NULL AFTER `custom_h2`, 
		ADD `brand_meta_keyword` VARCHAR(500) NULL AFTER `brand_meta_description`,
		ADD `language_id` INT NOT NULL DEFAULT '".$this->defaultLanguage()."' AFTER `brand_meta_keyword`");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hb_seobulk_batch` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `batch_id` int(11) NOT NULL,
		  `min_range` int(11) NOT NULL,
		  `max_range` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL DEFAULT '0',
		  `status` int(11) NOT NULL DEFAULT '0',
		  `meta_title` int(11) NOT NULL DEFAULT '0',
		  `h1` int(11) NOT NULL DEFAULT '0',
		  `h2` int(11) NOT NULL DEFAULT '0',
		  `img_alt` int(11) NOT NULL DEFAULT '0',
		  `meta_desc` int(11) NOT NULL DEFAULT '0',
		  `meta_key` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		)DEFAULT CHARSET=utf8");

		//initial values
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language){	
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_info_mkey_param_".$language['language_id']."', '{xin}, {xin} information, {xin} ".$store_name.", best products, best quality products', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_info_mdesc_param_".$language['language_id']."', '{in} | MyStore.com. Best Products, Best Price, Best Quality, Free Home Delivery', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_info_title_param_".$language['language_id']."', '{in} | ".$store_name."', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_cat_mkey_param_".$language['language_id']."', 'buy {xcn}, buy {xcn} products, best {xcn} products, low price {xcn}, high quality {xcn} products, online {xcn} products, buy {xcn} online', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_cat_mdesc_param_".$language['language_id']."', 'Buy best and quality {cn} products at less price only from ".$store_name.". Fast and free home delivery.', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_cat_alt_param_".$language['language_id']."', '{cn} image', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_cat_h1_param_".$language['language_id']."', 'Best {cn} products', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_cat_h2_param_".$language['language_id']."', 'Buy best and quality {cn} products', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_cat_title_param_".$language['language_id']."', 'Buy Best {cn} Products from ".$store_name."', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_prod_alt_param_".$language['language_id']."', '{p} image', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_prod_mdesc_param_".$language['language_id']."', 'Buy {p}, {b} from ".$store_name.". Fast & Free Home Delivery. High Quality Service', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_prod_mkey_param_".$language['language_id']."', 'buy {xp}, buy {xp} online, online shopping {xp}, {xc}, {xc} {xp}, {xb} {xp} {xm}, quality {xp} {xc}, best price {xp}, less price {xp}', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_prod_h2_param_".$language['language_id']."', 'Buy {p} | {b} | {c}', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_prod_h1_param_".$language['language_id']."', '{p} (Brand: {b})', 0)");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_prod_title_param_".$language['language_id']."', 'Buy {p} | {b} | ".$store_name."', 0)");
		}
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_brand_mdesc_param', 'Buy best and quality {bn} products at less price only from ".$store_name.". Fast and free home delivery.', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_brand_mkey_param', 'buy {xbn}, buy {xbn} products, best {xbn} products, low price {xbn}, high quality {xbn} products, online {xbn} products, buy {xbn} online', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_brand_h1_param', 'Best {bn} products', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_brand_h2_param', 'Buy best and quality {bn} products', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_brand_title_param', 'Buy Best {bn} Products from ".$store_name."', 0)");

		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_bulk_passkey', 'HUNTBEE2AMQOESD', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_bulk_ppb', '2000', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_bulk_time', '10', 0)");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES(NULL, 0, 'hb_seo', 'hb_seo_bulk_auto_lang', 'all', 0)");
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `".$code_column."`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'hb_seo_bulk_install', 'hb_seo_bulk_instalr', '1', '0')"); 
	}
	
	public function uninstall() {
		if ((VERSION == '2.0.0.0') or (VERSION == '2.0.1.0')){
			$code_column = 'group';
		}else {
			$code_column = 'code';
		}
		
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description`
			  DROP `custom_h1`,
			  DROP `custom_h2`,
			  DROP `img_alt`");
			  
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description`
			  DROP `custom_h1`,
			  DROP `custom_h2`,
			  DROP `img_alt`");

		$this->db->query("ALTER TABLE `" . DB_PREFIX . "manufacturer`
			  DROP `brand_description`,
			  DROP `custom_title`,
			  DROP `custom_h1`,
			  DROP `custom_h2`,
			  DROP `brand_meta_description`,
			  DROP `brand_meta_keyword`,
			  DROP `language_id`");		
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_seo'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_seo_bulk'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `".$code_column."` = 'hb_seo_bulk_install'");
	}

}
?>