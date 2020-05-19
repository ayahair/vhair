<?php
class ControllerExtensionHbTags extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$data['extension_version'] =  '7.2';

		$this->load->language('extension/hb_tags');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('setting/hb_tags');
		
		//check if seo is installed? If not install the extension
		if ($this->config->get('hb_tags_installer') <> 1){
			$this->response->redirect($this->url->link('extension/hb_tags/install', 'token=' . $this->session->data['token'],true));
		}
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_tags', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/hb_tags', 'token=' . $this->session->data['token'],true));
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		
		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'entry_parameters',
				'help_parameters',
				'entry_stop_words','help_stop_words','entry_automatic','help_automatic','text_report',
				'btn_generate',
				'btn_clear'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'],true),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/hb_tags', 'token=' . $this->session->data['token'],true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_tags', 'token=' . $this->session->data['token'],true);
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'],true);
		$data['uninstall'] = $this->url->link('extension/hb_tags/uninstall', 'token=' . $this->session->data['token'],true);
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		$data['languages'] = $languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language){
			$language_id = $language['language_id'];
			
			$data['all_product_count'.$language_id] =  $this->model_setting_hb_tags->getCountRecords($language_id);
			$data['tag_count'.$language_id] = $this->model_setting_hb_tags->getCountTags($language_id);
			
			//configs
			$data['hb_tags_parameter_'.$language_id] = $this->config->get('hb_tags_parameter_'.$language['language_id']);
			$data['hb_tags_stopwords_'.$language_id] = $this->config->get('hb_tags_stopwords_'.$language['language_id']);
		}		
		$data['hb_tags_auto'] = $this->config->get('hb_tags_auto');
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_tags', $data));

	}
	
	public function graph(){
		$data['language_id'] = $language_id = $this->request->get['language_id'];
		$this->load->model('setting/hb_tags');
		$this->load->model('localisation/language');
		$data['languages'] = $languages = $this->model_localisation_language->getLanguages();
		
		$data['all_product_count'] =  $this->model_setting_hb_tags->getCountRecords($language_id);
		$data['tag_count'] = $this->model_setting_hb_tags->getCountTags($language_id);

		$this->response->setOutput($this->load->view('extension/hb_tags_graph', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_tags')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function autogenerateTags(){
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language){
			$language_id = $language['language_id'];
			$this->generate($language_id);
		}		
	}
	
	public function generate($auto = 0){
			if (empty($auto) or ($auto == 0)){
				$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
			}else{
				$language_id = $auto;
			}
			$this->load->model('setting/hb_tags');			
			$this->language->load('extension/hb_tags');

		    $parameters = $this->config->get('hb_tags_parameter_'.$language_id);
			$j = 0;
			$infos = $this->model_setting_hb_tags->getProductInfo($language_id);
			foreach ($infos as $info){
				if (($info['tag'] === NULL) or ($info['tag'] == '')){
				$product_id = $info['product_id'];
				$name = trim($info['name']);
				$brand = trim($info['brand']);
				$model = trim($info['model']);
				$upc = trim($info['upc']);
				$category = $this->model_setting_hb_tags->getCategoriesName($product_id,$language_id);
				
				$replaced = str_replace("{p}",$name,$parameters);
				$replaced = str_replace("{b}",$brand,$replaced);
				$replaced = str_replace("{c}",$category,$replaced);
				$replaced = str_replace("{m}",$model,$replaced);
				$replaced = str_replace("{u}",$upc,$replaced);
				$replaced = htmlspecialchars_decode($replaced);
				
				$replaced = $this->cleanwords($replaced);
				$replaced = $this->extractKeyWords($replaced,$language_id);
				$replaced = implode(',', array_keys($replaced));
				
				//$alltags = $replaced;
				//simple extract
				$pos = strpos($parameters, '{c*}');
				if ($pos !== false) {
					$c = htmlspecialchars_decode($category);
					$c_set = 1;
				}else  {
					$c_set = 0;
				}
				
				$pos = strpos($parameters, '{p*}');
				if ($pos !== false) {
					$p = $this->simpleExtract($name,$language_id);
					$p_set = 1;
				}else {
					$p_set = 0;
				}
				
				if ($p_set == 1 and $c_set == 1){
					$alltags = $p.','.$c.','.$replaced;
				}elseif ($p_set == 1 and $c_set == 0){
					$alltags = $p.','.$replaced;
				}elseif ($p_set== 0 and $c_set == 1){
					$alltags = $c.','.$replaced;
				}else{
					$alltags = $replaced;
				}
				
				if (isset($alltags)){
					$alltags = preg_replace('/(' . preg_quote(',', '/') . '){2,}/', '$1', $alltags);
					$alltags = trim($alltags);
					$alltags = trim($alltags,',');
				}
				
				$this->model_setting_hb_tags->generateTags($product_id, $alltags , $language_id);
				$j = $j +1;
				}
			}	
			
			$json['success'] = sprintf($this->language->get('text_success_generate'),$j);
			$this->response->setOutput(json_encode($json));		
	}
	
	public function cleartags(){
			$language_id = (isset($_POST['language_id']))? $_POST['language_id'] :$this->defaultLanguageid();
			$this->load->model('setting/hb_tags');			
			$this->language->load('extension/hb_tags');
			
			$this->model_setting_hb_tags->clearTags($language_id);
			
			$json['success'] = $this->language->get('text_success_clear');
			$this->response->setOutput(json_encode($json));	
	}
	
	public function extractKeyWords($string,$language_id){
		
		  $string = htmlspecialchars_decode($string);
		  $stopWords = explode(',', $this->config->get('hb_tag_stop_words'.$language_id));
	   
		  $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
		  $string = trim($string); // trim the string
		  $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
		  $string = strtolower($string); // make it lowercase
	   
		  preg_match_all('/\b.*?\b/i', $string, $matchWords);
		  $matchWords = $matchWords[0];
		  
		  foreach ( $matchWords as $key=>$item ) {
			  if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 || is_numeric($item)) {
				  unset($matchWords[$key]);
			  }
		  }   
		  $wordCountArr = array();
		  if ( is_array($matchWords) ) {
			  foreach ( $matchWords as $key => $val ) {
				  $val = strtolower($val);
				  if ( isset($wordCountArr[$val]) ) {
					  $wordCountArr[$val]++;
				  } else {
					  $wordCountArr[$val] = 1;
				  }
			  }
		  }
		  arsort($wordCountArr);
		  $wordCountArr = array_slice($wordCountArr, 0, 20);
		  return $wordCountArr;
	}	
	
	public function simpleExtract($string,$language_id){
		$string = htmlspecialchars_decode($string);
		$string = preg_replace('/[!;:]/', '', $string); 
		$tags = '';
		$tags = (explode(" ",$string));
		$btag = '';
		$stopwords = explode(',', $this->config->get('hb_tag_stop_words'.$language_id));
		foreach($tags as $tag){
			if (strlen($tag) > 4 and !in_array($tag,$stopwords)){
				$btag = $btag.','.$tag;
			}
		}
	
		$btag = preg_replace('/(' . preg_quote(',', '/') . '){2,}/', '$1', $btag);
		return $btag = trim($btag, ',');
	}	
	
	////////////////////////
	public function defaultLanguageid(){
		$this->load->model('setting/hb_tags');
		return $this->model_setting_hb_tags->defaultLanguage();
	}
	
	public function cleanwords($str, $options = array()) {
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = htmlspecialchars_decode($str);
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		$defaults = array(
		'delimiter' => ' ',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => true,
		);
		// Merge options
		$options = array_merge($defaults, $options);
		$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
		'ß' => 'ss',
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
		'ÿ' => 'y',
		 
		// Latin symbols
		'©' => '(c)',
		 
		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
		 
		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
		 
		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',
		 
		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
		 
		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
		'Ž' => 'Z',
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z',
		 
		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
		'Ż' => 'Z',
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',
		
		//Arabic
		"ا"=>"a", "أ"=>"a", "آ"=>"a", "إ"=>"e", "ب"=>"b", "ت"=>"t", "ث"=>"th", "ج"=>"j",
		"ح"=>"h", "خ"=>"kh", "د"=>"d", "ذ"=>"d", "ر"=>"r", "ز"=>"z", "س"=>"s", "ش"=>"sh",
		"ص"=>"s", "ض"=>"d", "ط"=>"t", "ظ"=>"z", "ع"=>"'e", "غ"=>"gh", "ف"=>"f", "ق"=>"q",
		"ك"=>"k", "ل"=>"l", "م"=>"m", "ن"=>"n", "ه"=>"h", "و"=>"w", "ي"=>"y", "ى"=>"a",
		"ئ"=>"'e", "ء"=>"'",   
		"ؤ"=>"'e", "لا"=>"la", "ة"=>"h", "؟"=>"?", "!"=>"!", 
		"ـ"=>"", 
		"،"=>",", 
		"َ‎"=>"a", "ُ"=>"u", "ِ‎"=>"e", "ٌ"=>"un", "ً"=>"an", "ٍ"=>"en", "ّ"=>"",
		
		//persian
		"ا" => "a", "أ" => "a", "آ" => "a", "إ" => "e", "ب" => "b", "ت" => "t", "ث" => "th",
		"ج" => "j", "ح" => "h", "خ" => "kh", "د" => "d", "ذ" => "d", "ر" => "r", "ز" => "z",
		"س" => "s", "ش" => "sh", "ص" => "s", "ض" => "d", "ط" => "t", "ظ" => "z", "ع" => "'e",
		"غ" => "gh", "ف" => "f", "ق" => "q", "ك" => "k", "ل" => "l", "م" => "m", "ن" => "n",
		"ه" => "h", "و" => "w", "ي" => "y", "ى" => "a", "ئ" => "'e", "ء" => "'", 
		"ؤ" => "'e", "لا" => "la", "ک" => "ke", "پ" => "pe", "چ" => "che", "ژ" => "je", "گ" => "gu",
		"ی" => "a", "ٔ" => "", "ة" => "h", "؟" => "?", "!" => "!", 
		"ـ" => "", 
		"،" => ",", 
		"َ‎" => "a", "ُ" => "u", "ِ‎" => "e", "ٌ" => "un", "ً" => "an", "ٍ" => "en", "ّ" => "",
		 
		// Latvian
		'Ā'  =>  'A', 'Č'  =>  'C', 'Ē'  =>  'E', 'Ģ'  =>  'G', 'Ī'  =>  'i', 'Ķ'  =>  'k', 'Ļ'  =>  'L', 'Ņ'  =>  'N',
		'Š'  =>  'S', 'Ū'  =>  'u', 'Ž'  =>  'Z',
		'ā'  =>  'a', 'č'  =>  'c', 'ē'  =>  'e', 'ģ'  =>  'g', 'ī'  =>  'i', 'ķ'  =>  'k', 'ļ'  =>  'l', 'ņ'  =>  'n',
		'š'  =>  's', 'ū'  =>  'u', 'ž'  =>  'z'
		);
		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		// Transliterate characters to ASCII
		if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
		}
		
		public function install(){
			$this->load->model('setting/hb_tags');
			$this->model_setting_hb_tags->install();
			$data['success'] = 'This extension has been installed successfully';
			$this->response->redirect($this->url->link('extension/hb_tags', 'token=' . $this->session->data['token'],true));
		}
		
		public function uninstall(){
				$this->load->model('setting/hb_tags');
				$this->model_setting_hb_tags->uninstall();
				$data['success'] = 'This extension is uninstalled successfully. Do not click on the Menu link again as it will auto install again.';
				$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'],true));
		}
		
		//*******************************************************   AUTOMATION

	//*******************************************************

}
?>