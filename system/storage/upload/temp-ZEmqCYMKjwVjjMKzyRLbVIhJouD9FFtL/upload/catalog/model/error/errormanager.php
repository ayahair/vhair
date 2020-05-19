<?php
class ModelErrorErrorManager extends Model {
	
	public function insertErrorLog($current_url,$referrer_url, $user_agent, $ip) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "error_logs` (error,referrer,user_agent,ip) VALUES ('".$this->db->escape($current_url)."','".$this->db->escape($referrer_url)."','".$this->db->escape($user_agent)."','".$this->db->escape($ip)."')");
		$redirect_default = $this->config->get('hb_404_defaulturl');
		
		$smart_url = $this->config->get('hb_404_smarturl');
		if ($smart_url == 1){

			 $keywords = strtok($_SERVER['REQUEST_URI'], '?');
			 //$keywords = 'mak';
			 $keywords = explode('/',$keywords);
			 $keywords = array_reverse($keywords);
			 foreach ($keywords as $keyword){
			 	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword sounds like '" . $this->db->escape($keyword) . "'");
				if (($query->num_rows)) {
					$auto_redirect = urlencode($query->row['keyword']);
					break;
				}
			 }
			// $construct_host = $http_protocol.$_SERVER['HTTP_HOST'].'/';
			 $redirect_default = (isset($auto_redirect))? HTTPS_SERVER.$auto_redirect : $redirect_default;
			// $keyword = str_replace('/','',$keyword);
			
			/*$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword sounds like '" . $this->db->escape($keyword) . "'");
			if (($query->num_rows)) {
				$auto_redirect = $query->row['keyword'];
				$redirect_default = urlencode($auto_redirect);
			}else{
				$redirect_default = $redirect_default;
			}*/
		}else{
			$redirect_default = $redirect_default;
		}
		
		if (strlen($redirect_default) < 1){
			$type = 404;
		}else{
			$type = $this->config->get('hb_404_type');
		}
		$query = $this->db->query("SELECT id FROM `" . DB_PREFIX . "error` WHERE error = '".$this->db->escape($current_url)."'");
		if ($query->num_rows > 0){
			$id = $query->row['id'];
			$redirect_url = $this->getRedirect($current_url);
			if (trim($redirect_url) == ''){
				$this->db->query("UPDATE `" . DB_PREFIX . "error` SET hits = hits+1, `redirect` = '".$this->db->escape($redirect_default)."', `type` = '".$type."' WHERE id = '" . (int)$id . "'");
			}else{
				$this->db->query("UPDATE `" . DB_PREFIX . "error` SET hits = hits+1 WHERE id = '" . (int)$id . "'");
			}
		}else{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "error` (error, redirect, type, author, date_modified) VALUES ('".$this->db->escape($current_url)."','".$this->db->escape($redirect_default)."','".$type."', 3, now())");
		}
	}
	
	public function getcommonRedirect($current_url){
		$query = $this->db->query("SELECT redirect FROM `" . DB_PREFIX . "error` WHERE error = '".$this->db->escape($current_url)."' and author = 1 LIMIT 1");
		if ($query->num_rows > 0){
			return $query->row['redirect'];
		}else{
			return false;
		}
	}
	
	public function getRedirect($current_url){
		$query = $this->db->query("SELECT redirect FROM `" . DB_PREFIX . "error` WHERE error = '".$this->db->escape($current_url)."' LIMIT 1");
		if ($query->num_rows > 0){
			return $query->row['redirect'];
		}else{
			return false;
		}
	}
	
	public function getResponse($current_url){
		$query = $this->db->query("SELECT type FROM `" . DB_PREFIX . "error` WHERE error = '".$this->db->escape($current_url)."' LIMIT 1");
		return $query->row['type'];
	}
	
	public function updateRedirecthits($current_url) {
		$this->db->query("UPDATE `" . DB_PREFIX . "error` SET redirect_hits = redirect_hits+1 WHERE error = '".$this->db->escape($current_url)."'");
	}
	
	public function removeQueryStringParameter($url, $varname)
	{
		$parsedUrl = parse_url($url);
		$query = array();
	
		if (isset($parsedUrl['query'])) {
			parse_str($parsedUrl['query'], $query);
			unset($query[$varname]);
		}
	
		$path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
		$query = !empty($query) ? '?'. http_build_query($query) : '';
	
		$outputurl = $parsedUrl['scheme']. '://'. $parsedUrl['host']. $path. $query;
		return urldecode($outputurl);
	}
	
	public function checkandredirect(){
		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			$http_protocol = "https://";
		}else{
			$http_protocol = "http://";
		}
		$current_url= $http_protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(isset($_SERVER['HTTP_REFERER'])) {
			$referrer_url = $_SERVER['HTTP_REFERER'];
		} else{
			$referrer_url = NULL;
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		
		$queryparameters = $this->config->get('hb_404_excludequery');
		
		if (isset($queryparameters) and strlen(trim($queryparameters))>3){
			$queryparameters = explode(',',$queryparameters);
			foreach ($queryparameters as $queryparameter){
				$current_url = $this->removeQueryStringParameter($current_url, $queryparameter);
			}
		}
		
		$current_url = urlencode($current_url);
		$referrer_url = urlencode($referrer_url);
		
		$ignore = 0;
		$exclude_ip = $this->config->get('hb_404_ignoreip');
		if (strpos($exclude_ip,$ip) !== false){
			$ignore = $ignore + 1;
		}
		if ($ignore == 0){ //ip ignore
				//check bot - second check
				$bots = $this->config->get('hb_404_ignoreagents'); 
				if (!empty($bots)){ 
					$bots = explode(',',$bots);
					foreach ($bots as $bot){
						$excludebot = trim($bot);
						if (strpos($user_agent,$excludebot) !== false){$ignore = $ignore + 1;}
					} 
				}
				
				if ($ignore == 0){ //bot ignore
					$excludes = $this->config->get('hb_404_excludeterms'); 
						if (!empty($excludes)){ 
						$excludes = explode(',',$excludes);
						foreach ($excludes as $exclude){
							$term = urlencode(trim($exclude));
							if (strpos($current_url,$term) !== false){$ignore = $ignore + 1;}
						} 
					}
					if ($ignore == 0){ 
						$this->insertErrorLog($current_url,$referrer_url, $user_agent, $ip);
						$redirect_url = $this->getRedirect($current_url);
						if ($redirect_url != false){
							$redirect_url = urldecode($redirect_url);
							$this->updateRedirecthits($current_url);
							$response_code = $this->getResponse($current_url);
							$this->response->redirect($redirect_url, $response_code);
						}
						//$this->insertErrorLog($current_url,$referrer_url, $user_agent, $ip);
				   }
				}//bot ignore
		}//ip ignore
		
		
	}

}
?>