<?php
class ControllerCiReviewProCiReview extends Controller {
	public function index() {
		if($this->config->get('cireviewpro_status')) {
			$this->load->language('product/product');	
			$this->load->language('cireviewpro/cireview');
			$this->document->addStyle('catalog/view/theme/default/stylesheet/cireviewpro/cireview.css');
			$this->document->addScript('catalog/view/javascript/cireviewpro/rating/bootstrap-rating-input.js');
			$this->load->model('cireviewpro/cireview');	
			$this->load->model('catalog/product');
			$this->load->model('tool/image');	
			$data['product_id'] = $this->request->get['product_id'];
			
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
			
			
			$data['heading_title'] = $this->language->get('heading_title');
						
			$data['text_clear_filters'] = $this->language->get('text_clear_filters');
			$data['sorts'] = array();
			/*$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'r.cireview_id-ASC',
			);*/			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'r.rating-DESC',
				'class' => 'ci-rating_desc',
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'r.rating-ASC',
				'class' => 'ci-rating_asc green',
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'p.date_added-DESC',
				'class' => 'ci-date_desc orange',
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'p.date_added-ASC',
				'class' => 'ci-date_asc purple',
			);
			$data['reviewfilters'] = $this->config->get('cireviewpro_reviewfilters');
			if(!$this->config->get('cireviewpro_reviewfilters')) {
				$data['sorts'] = array();
			}
			
			
			$data['text_reviewreport'] = $this->language->get('text_reviewreport');	
			$data['text_other'] = $this->language->get('text_other');	
			$data['text_other_reason'] = $this->language->get('text_other_reason');	
			$data['text_loading'] = $this->language->get('text_loading');	
			$data['text_note'] = $this->language->get('text_note');	
			$data['text_write'] = $this->language->get('text_write') .' '. sprintf($this->language->get('text_writereview'), $product_info['name']);	
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
			$data['text_purchasefirst'] = $this->language->get('text_purchasefirst');
			$data['text_withimg'] = $this->language->get('text_withimg');
			$data['text_withoutimg'] = $this->language->get('text_withoutimg');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_reviewtitle'] = $this->language->get('entry_reviewtitle');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_attachimages'] = $this->language->get('entry_attachimages');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['button_write'] = $this->language->get('button_write');
			
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_submit'] = $this->language->get('button_submit');
			$ratingtypes = $this->model_cireviewpro_cireview->getCiRatingTypes($this->request->get['product_id']);
			$data['ratingtypes'] = array();
			foreach ($ratingtypes as $ratingtype) {
				$data['ratingtypes'][] = array(
					'ciratingtype_id' => $ratingtype['ciratingtype_id'],
					'name' => $ratingtype['name'],
				);
			}
			$data['status'] = $this->config->get('cireviewpro_status');
			$data['rating'] = $this->config->get('cireviewpro_rating');
			$data['email'] = $this->config->get('cireviewpro_reviewemail');
			$data['title'] = $this->config->get('cireviewpro_reviewtitle');
			$data['title_require'] = $this->config->get('cireviewpro_reviewtitle_require');
			$data['author'] = $this->config->get('cireviewpro_reviewauthor');
			$data['author_require'] = $this->config->get('cireviewpro_reviewauthor_require');
			$data['text'] = $this->config->get('cireviewpro_reviewtext');
			$data['text_require'] = $this->config->get('cireviewpro_reviewtext_require');
						
			$data['reviewgraph_color'] = $this->config->get('cireviewpro_reviewgraph_color');
			$data['reviewgraph'] = $this->config->get('cireviewpro_reviewgraph');
			$data['reviewimp'] = $this->config->get('cireviewpro_reviewimp');
			$data['sharetype'] = $this->config->get('cireviewpro_sharetype');
			$data['reviewgraph_option'] = $this->config->get('cireviewpro_reviewgraph_option');
			
			$data['rewardsuccessalert'] = $this->config->get('cireviewpro_rewardsuccessalert');
			$data['reviewpolicy'] = $this->config->get('cireviewpro_reviewpolicy');
			
			$data['reviewaddon'] = $this->config->get('cireviewpro_reviewaddon');
			
			$reviewpolicypage_info = (array)$this->config->get('cireviewpro_reviewpolicypage');
			if(isset($reviewpolicypage_info[(int)$this->config->get('config_language_id')])) {
				$data['reviewpolicypage'] = $reviewpolicypage_info[(int)$this->config->get('config_language_id')];
				
				/*check if array is not empty*/
			} else if($reviewpolicypage_info) {
				
				reset($reviewpolicypage_info);
				$first_key = key($reviewpolicypage_info);
				$data['reviewpolicypage'] = $reviewpolicypage_info[$first_key];
			}
			if(isset($data['reviewpolicypage']['message'])) {
				$data['reviewpolicypage']['message'] = html_entity_decode($data['reviewpolicypage']['message'], ENT_QUOTES, 'UTF-8');
			}
			
			// no. of stars
			$data['ratingstars'] = 5;
			if((int)$this->config->get('cireviewpro_ratingstars')) {
				$data['ratingstars'] = (int)$this->config->get('cireviewpro_ratingstars');
			}
			$data['cireviewgraph'] =  $this->cireviewGraph();
			$data['aggeratereview'] = $this->aggerateReview();
			
			// attach images in review
			$data['reviewimages'] = (int)$this->config->get('cireviewpro_reviewimages');
			// get uploaded images of user
			$attach_images = $this->model_cireviewpro_cireview->getUploadedImage();
			$data['attach_images'] = array();
			$cireview_image = array();
			$thumbwidth = (int)$this->config->get('cireviewpro_reviewimagesthumb_width');
			$thumbheight = (int)$this->config->get('cireviewpro_reviewimagesthumb_height');
			if(empty($thumbwidth) || is_null($thumbwidth) ) {
				$thumbwidth = 100;
			}
			if(empty($thumbheight) || is_null($thumbheight) ) {
				$thumbheight = 100;
			}
			
			$popupwidth = (int)$this->config->get('cireviewpro_reviewimagespopup_width');
			$popupheight = (int)$this->config->get('cireviewpro_reviewimagespopup_height');
			if(empty($popupwidth) || is_null($popupwidth) ) {
				$popupwidth = 500;
			}
			if(empty($popupheight) || is_null($popupheight) ) {
				$popupheight = 500;
			}
			
			foreach ($attach_images as $attach_image) {
				if(!empty($attach_image['image']) && file_exists(DIR_IMAGE .$attach_image['image'] )) {
					$thumb = $this->model_tool_image->resize($attach_image['image'], $thumbwidth, $thumbheight ) ;
					$popup = $this->model_tool_image->resize($attach_image['image'], $popupwidth, $popupheight ) ;
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', $thumbwidth, $thumbheight ) ;
					$popup = $this->model_tool_image->resize('no_image.png', $popupwidth, $popupheight ) ;
				}
				$cireview_image[] = $attach_image['cireview_image_id'];
				$image_description = $this->model_cireviewpro_cireview->getCiReviewImagesDescriptions($attach_image['cireview_image_id']);
				$data['attach_images'][] = array(
					'cireview_image_id' => $attach_image['cireview_image_id'],
					'thumb' => $thumb,
					'popup' => $popup,
					'alt' => !empty($image_description['alt']) ? htmlentities($image_description['alt'], ENT_QUOTES, 'UTF-8') : '',
					'title' => !empty($image_description['title']) ? htmlentities($image_description['title'], ENT_QUOTES, 'UTF-8') : '',
				);
			}
			$data['cireview_image'] = '';
			if($cireview_image) {
				$data['cireview_image'] = implode(",", $cireview_image);
			}
			if ($this->config->get('cireviewpro_reviewguest') || $this->customer->isLogged()) {
				$data['cireview_guest'] = true;
			} else {
				$data['cireview_guest'] = false;
			}
						
			$data['cireview_purchasefirst'] = false;
			// first we ask to login for review
			if ($this->config->get('cireviewpro_reviewpurchaseonly') && !$this->customer->isLogged()) {
				// $data['cireview_guest'] = false;
				$data['cireview_purchasefirst'] = true;
			}
			
			if ($this->config->get('cireviewpro_reviewpurchaseonly') && $this->customer->isLogged()) {
				// check if customer buy this product and not give review yet
				$purchasefirst = $this->model_cireviewpro_cireview->isRequirePurchaseFirst($this->request->get['product_id'],(array)$this->config->get('cireviewpro_verifypurchase_orderstatus'));
				//$purchasefirst = $this->model_cireviewpro_cireview->isProductRequirePurchase($this->request->get['product_id']);
				//$purchasefirst = $this->model_cireviewpro_cireview->isProductOrderCompleted($this->request->get['product_id'],(array)$this->config->get('cireviewpro_verifypurchase_orderstatus'));
				$data['cireview_purchasefirst'] = !($purchasefirst);
			}
			
			
			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
				$data['customer_email'] = $this->customer->getEmail();
			} else {
				$data['customer_name'] = '';
				$data['customer_email'] = '';
			}
			// Captcha
			if (VERSION >= '3.0.0.0' && $this->config->get('cireviewpro_captcha') && $this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
					$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else if (VERSION < '3.0.0.0' && $this->config->get('cireviewpro_captcha') && $this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				if (VERSION <= '2.2.0.0') {
					$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
				} else {
					$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
				}
			} else {
				$data['captcha'] = '';
			}
		
			// abuse reasons
			$ciabreasons = $this->model_cireviewpro_cireview->getCiAbReasons($this->request->get['product_id']);
			$data['ciabreasons'] = array();
			foreach ($ciabreasons as $ciabreason) {
				$data['ciabreasons'][] = array(
					'ciabreason_id' => $ciabreason['ciabreason_id'],
					'name' => $ciabreason['name'],
					'details' => $ciabreason['details'],
				);
			}
			if($this->config->get('theme_default_directory')) {
				$data['theme_name'] = $this->config->get('theme_default_directory');
			} else if($this->config->get('config_template')) {
				$data['theme_name'] = $this->config->get('config_template');
			} else{
				$data['theme_name'] = 'default';
			}
			if(empty($data['theme_name'])) {
				$data['theme_name'] = 'default';
			}
			if(isset($data['theme_name']) && $data['theme_name'] == 'journal2') {
				$data['journal_class'] = 'journal-wrap';
			} else{
				$data['journal_class'] = '';
			}
			/*get product all reviews to show in view source only*/
			$data['review'] = '';
			$data['reviewviewsource'] = $this->config->get('cireviewpro_reviewviewsource');
			if($this->config->get('cireviewpro_reviewviewsource')) {
				$data['review'] = $this->review();
			}
			$data['topreviews'] = $this->topReviews();
			/*rich snippets starts*/
			$data['rich'] = '';			
			$totalreviews = 0;
			$results = array();
			if($this->config->get('cireviewpro_richsnippets')) {
				$filter_data = array(
	                'product_id' => $this->request->get['product_id'],
	                'sort' => 'r.date_added',
	                'order' => 'DESC',
	            );
	            $totalreviews = $this->model_cireviewpro_cireview->getTotalCiReviewsByProductId($filter_data);
				$results = $this->model_cireviewpro_cireview->getCiReviewsByProductId($filter_data);
			}
			if($totalreviews > 0) {
				$rich_snippets = array();
				$rich_snippets["@context"] = "http://schema.org";
				$rich_snippets["@type"] = "Product";
				$rich_snippets["description"] = str_replace (array('"'), array('&#34;'), html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8'));
				$rich_snippets["name"] = $product_info['name'];
				$rich_snippets["image"] = "";
				if(file_exists(DIR_IMAGE . $product_info['image'])) {
					$rich_snippets["image"] = $this->getFrontUrl('image/') . $product_info['image'];
				}
				$rich_snippets["url"] = $this->url->link('product/product','product_id='. $product_info['product_id'], true);
				$rich_snippets["aggregateRating"] = array();
				$rich_snippets["aggregateRating"]["@type"] = "AggregateRating";
				$rich_snippets["aggregateRating"]["ratingValue"] = round($this->model_cireviewpro_cireview->getAvgRatingOfProducts($product_info['product_id']),2);
				$rich_snippets["aggregateRating"]["reviewCount"] = $totalreviews;
				if($results) {				
					$rich_snippets["review"] = array();
					
					foreach($results as $key => $result) {
						$rich_snippets["review"][$key] = array();
						$rich_snippets["review"][$key]["@type"] = "Review";
						$rich_snippets["review"][$key]["author"] = $result['author'];
						$rich_snippets["review"][$key]["datePublished"] = $result['date_added'];
						$rich_snippets["review"][$key]["reviewBody"] = $result['text'];
						$rich_snippets["review"][$key]["reviewRating"] = array();
						$rich_snippets["review"][$key]["reviewRating"]["@type"] = "Rating";
						$rich_snippets["review"][$key]["reviewRating"]["bestRating"] = "5";
						$rich_snippets["review"][$key]["reviewRating"]["ratingValue"] = $result['rating'];
						$rich_snippets["review"][$key]["reviewRating"]["worstRating"] = "1";
					}
				}
				/*
				JSON_PRETTY_PRINT
				JSON_UNESCAPED_SLASHES
				*/
				$data['rich'] = json_encode($rich_snippets, JSON_UNESCAPED_SLASHES) ;
			}
			/*rich snippets ends*/
			
			$data['text_reviewterm'] = '';
			if ($this->config->get('cireviewpro_reviewterm_id')) {
				$this->load->model('catalog/information');
				$information_info = $this->model_catalog_information->getInformation($this->config->get('cireviewpro_reviewterm_id'));
				if ($information_info) {
					$data['text_reviewterm'] = sprintf($this->language->get('text_reviewterm'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('cireviewpro_reviewterm_id'), true), $information_info['title'], $information_info['title']);
				}
			}
			
			$data['customcss'] = $this->config->get('cireviewpro_customcss');
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireview.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireview.tpl', $data);
				} else {
					return $this->load->view('default/template/cireviewpro/cireview.tpl', $data);
				}
			} else{
				return $this->load->view('cireviewpro/cireview', $data);
			}
		}
	}
	private function getFrontUrl($url='') {
		if ($this->request->server['HTTPS']) {
			return HTTP_SERVER . $url;
		} else {
			return HTTPS_SERVER . $url;
		}
	}
	private function topReviews() {
		if($this->config->get('cireviewpro_reviewimp')) {
			// no. of stars
			$data['ratingstars'] = 5;
			if((int)$this->config->get('cireviewpro_ratingstars')) {
				$data['ratingstars'] = (int)$this->config->get('cireviewpro_ratingstars');
			}
			$this->load->model('cireviewpro/cireview');
			$this->load->language('cireviewpro/cireview');
			$data['text_topreview'] = $this->language->get('text_topreview');
			
			/*$default = $this->config->get('cireviewpro_reviewsortdefault');
			$default_part = explode('-', $default);
			
			if(count($default_part)==2) {
				if(!isset($this->request->get['sort'])) {
					$this->request->get['sort'] = $default_part[0];
				}
				if(!isset($this->request->get['order'])) {
					$this->request->get['order'] = $default_part[1];
				}
			}*/
			if(isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'r.rating';
			}
			if(isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}
			$sort = 'r.rating';
			$order = 'DESC';
			$filter_data = array(
				'product_id' => $this->request->get['product_id'],	
				'filter_imp' => 1,
				'sort' => $sort,
				'order' => $order,
			);
			$results = $this->model_cireviewpro_cireview->getCiReviewsByProductId($filter_data);
			$data['reviews'] = array();
			foreach ($results as $result) {
				$cireview_info = $this->model_cireviewpro_cireview->getCiReviewByReviewId($result['review_id']);
				$result['cireview_id'] = 0;
				$result['comment'] = '';
				$result['title'] = '';
				$result['imp'] = '';
				if($cireview_info) {
					$result['cireview_id'] = $cireview_info['cireview_id'];
					$result['comment'] = $cireview_info['comment'];
					$result['title'] = $cireview_info['title'];
					$result['imp'] = $cireview_info['imp'];
					if($this->config->get('cireviewpro_reviewrating')) {
			
						$cireview_ratings = $this->model_cireviewpro_cireview->getCiReviewRatings($cireview_info['cireview_id']);
						foreach($cireview_ratings as $cireview_rating) {
							$ciratingtype_name = '';
							$ratingtype = $this->model_cireviewpro_cireview->getCiRatingType($cireview_rating['ciratingtype_id']);
							if($ratingtype) {
								$ciratingtype_name = $ratingtype['name'];
							} else {
								$ciratingtype_names = json_decode($cireview_rating['ciratingtype_name'],1);
								if(!empty($ciratingtype_names)) {
									if(isset($ciratingtype_names[(int)$this->config->get('config_language_id')])) {
										$ciratingtype_name = $ciratingtype_names[(int)$this->config->get('config_language_id')];
									} else {
										reset($ciratingtype_names);
										$ciratingtype_name = end($ciratingtype_names);
									}
								}
							}
							
							$result['cireview_ratings'][] = array(
								'cireview_rating_id' => $cireview_rating['cireview_rating_id'],
								'ciratingtype_id' => $cireview_rating['ciratingtype_id'],
								'ciratingtype_name' => $ciratingtype_name,
								'rating' => $cireview_rating['rating'],
								'show_rating' => (int)$cireview_rating['rating'],
							);
						}
					
					}
				}
				/*31-10-2018 verify purchase info start*/
				$cireviewverify_info = $this->model_cireviewpro_cireview->getCiReviewVerify($result['review_id']);
				$verified = false;
				if($cireviewverify_info) {
					$verified = $cireviewverify_info['review'] == 1;
				}
				/*31-10-2018 verify purchase info end*/
				$data['reviews'][] = array(
					'review_id'     => $result['review_id'],				
					'imp'     => $result['imp'],
					'verified'     => $verified,
					'cireview_id'     => $result['cireview_id'],
					'author'     => $result['author'],
					'text'       => nl2br($result['text']),
					'reviewtitle'       => (int)$this->config->get('cireviewpro_reviewpagetitleshow') ? nl2br($result['title']) : '',
					'comment'       => (int)$this->config->get('cireviewpro_reviewreply') ? nl2br($result['comment']) : '',
					'rating'     => $this->config->get('cireviewpro_reviewrating') ? (int)$result['rating'] : 0,
					
					'show_rating'     => (int)$result['rating'],
					
					'cireview_ratings'     => $result['cireview_ratings'],
					'date_added' => date($this->config->get('cireviewpro_reviewdateformat'), strtotime($result['date_added'])),
				);
			}
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireview_top.tpl')) {
					$output = $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireview_top.tpl', $data);
				} else {
					$output = $this->load->view('default/template/cireviewpro/cireview_top.tpl', $data);
				}
			} else{
				$output = $this->load->view('cireviewpro/cireview_top', $data);
			}
			return $output;
		}
	}
	private function cireviewGraph() {
		$this->load->model('cireviewpro/cireview');
		$this->load->language('cireviewpro/cireview');
		// no. of stars
		$data['ratingstars'] = 5;
		if((int)$this->config->get('cireviewpro_ratingstars')) {
			$data['ratingstars'] = (int)$this->config->get('cireviewpro_ratingstars');
		}
		
		$data['text_star'] = $this->language->get('text_star');	
		$data['reviewgraph_color'] = $this->config->get('cireviewpro_reviewgraph_color');
		$data['sharetype'] = $this->config->get('cireviewpro_sharetype');
		$data['reviewgraph_option'] = $this->config->get('cireviewpro_reviewgraph_option');
		$data['reviewgraph'] = (int)$this->config->get('cireviewpro_reviewgraph');
		$filter_data = array(
			'product_id' => $this->request->get['product_id'],
		);
		$data['review_total'] = $this->model_cireviewpro_cireview->getTotalCiReviewsByProductId($filter_data);
		$ratingreviews = $this->model_cireviewpro_cireview->getProductReviewsByRating($this->request->get['product_id']);
		$reviewsrating = array();
		$options_reviewrating = array();
		for($i=1;$i<=$data['ratingstars'];$i++) {
			$options_reviewrating[$i] = 0;
		}
		foreach($ratingreviews as $ratingreview) {
			if($ratingreview['rating']) {
			$reviewsrating[$ratingreview['rating']] = $ratingreview['total'];
			}
		}
		$data['ratingreviews'] = ($reviewsrating + array_diff_key($options_reviewrating ,$reviewsrating));
		// ksort($data['ratingreviews']);
		krsort($data['ratingreviews']);
		if(VERSION < '2.2.0.0') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireview_graph.tpl')) {
				$output = $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireview_graph.tpl', $data);
			} else {
				$output = $this->load->view('default/template/cireviewpro/cireview_graph.tpl', $data);
			}
		} else{
			$output = $this->load->view('cireviewpro/cireview_graph', $data);
		}
		return $output;
	}
	private function aggerateReview() {
		$this->load->language('cireviewpro/cireview');
		$this->load->model('catalog/product');
		// no. of stars
		$data['ratingstars'] = 5;
		if((int)$this->config->get('cireviewpro_ratingstars')) {
			$data['ratingstars'] = (int)$this->config->get('cireviewpro_ratingstars');
		}
		$filter_data = array(
			/*'filter_rating' => $cirating_filter,*/
			'product_id' => $this->request->get['product_id'],
		);
		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		if($product_info) {
			$data['href_review'] = $this->url->link('cireviewpro/cireviews', 'cireview_product_id='. $product_info['product_id'] , true);
		
			$reviewtotal = $this->model_cireviewpro_cireview->getTotalCiReviewsByProductId($filter_data);
			$data['text_write_review'] = $this->language->get('text_write_review');
			$data['reviewratingcount'] = $this->config->get('cireviewpro_reviewratingcount');
			$data['text_rating'] = $this->language->get('text_rating');
			$data['text_reviewover'] = sprintf($this->language->get('text_reviewover'), $product_info['name']);
			
			$data['avg_rating'] = round($this->model_cireviewpro_cireview->getAvgRatingOfProducts($product_info['product_id']));
			
			
			$data['show_avg_rating'] = round($data['avg_rating']);
			
			$data['cireview_ratings'] = array();
			
			$cirating_types = $this->model_cireviewpro_cireview->getCiRatingTypes($this->request->get['product_id']);
			foreach($cirating_types as $cirating_type) {
				$avg_rating = $this->model_cireviewpro_cireview->getCiReviewRatingAvg($cirating_type['ciratingtype_id'], $product_info['product_id']);	
				
				$data['cireview_ratings'][] = array(
					'ciratingtype_id' 	=> $cirating_type['ciratingtype_id'],
					'ciratingtype_name' 	=> $cirating_type['name'],
					'rating' 				=> number_format($avg_rating,2),
					'show_rating' => (int)$avg_rating,
				);	
			}
			$data['text_total_reviews'] = sprintf($this->language->get('text_total_reviews'), $reviewtotal) ;
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireview_aggerate.tpl')) {
					$output = $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireview_aggerate.tpl', $data);
				} else {
					$output = $this->load->view('default/template/cireviewpro/cireview_aggerate.tpl', $data);
				}
			} else{
				$output = $this->load->view('cireviewpro/cireview_aggerate', $data);
			}
			return $output;
		}
	}
	
	public function review() {
		$this->load->language('product/product');
		$this->load->language('cireviewpro/cireview');
		$this->load->model('cireviewpro/cireview');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		if(isset($this->request->get['cirating_filter'])) {
			$cirating_filter = $this->request->get['cirating_filter'];
		} else {
			$cirating_filter = 0;
		}
		
		if(isset($this->request->get['cirating_dofilter'])) {
			$cirating_dofilter = $this->request->get['cirating_dofilter'];
		} else {
			$cirating_dofilter = '';
		}
		
		// no. of stars
		$data['ratingstars'] = 5;
		if((int)$this->config->get('cireviewpro_ratingstars')) {
			$data['ratingstars'] = (int)$this->config->get('cireviewpro_ratingstars');
		}
		$default = $this->config->get('cireviewpro_reviewsortdefault');
		$default_part = explode('-', $default);
		
		if(count($default_part)==2) {
			if(!isset($this->request->get['sort'])) {
				$this->request->get['sort'] = $default_part[0];
			}
			if(!isset($this->request->get['order'])) {
				$this->request->get['order'] = $default_part[1];
			}
		}
		if(isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
		}
		if(isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		if($product_info) {
			$data['text_no_reviews'] = $this->language->get('text_no_reviews');
			$data['text_author'] = $this->language->get('text_author');
			$data['text_title'] = $this->language->get('text_title');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_rating'] = $this->language->get('text_rating');
			$data['text_yes'] = $this->language->get('text_yes');
			$data['text_no'] = $this->language->get('text_no');
			$data['text_reviewabuse'] = $this->language->get('text_reviewabuse');
			$data['text_verified'] = $this->language->get('text_verified');
			
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_replyby'] = $this->language->get('text_replyby');
				
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			$data['product_id'] = $this->request->get['product_id'];
			$data['reviews'] = array();
			$limit = 5;
			if($this->config->get('cireviewpro_reviewlimit')) {
				$limit = $this->config->get('cireviewpro_reviewlimit');
			}
			
			$filter_data = array(
				/*'filter_rating' => $cirating_filter,*/
				'product_id' => $this->request->get['product_id'],
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit,
			);
			
			$reviewtotal = $this->model_cireviewpro_cireview->getTotalCiReviewsByProductId($filter_data);
			
			
			$filter_data = array(
				'filter_rating' => $cirating_filter,
				'filter_attachimages' => $cirating_dofilter,
				'product_id' => $this->request->get['product_id'],
				'sort' => $sort,
				'order' => $order,				
			);
			$data['ajax'] = 0;
			if(isset($this->request->get['ajax']) && $this->request->get['ajax']=1) {
				$filter_data = array_merge($filter_data, array(
					'start' => ($page - 1) * $limit,
					'limit' => $limit,
				));
				$data['ajax'] = 1;
			}
			
			$review_total = $this->model_cireviewpro_cireview->getTotalCiReviewsByProductId($filter_data);
			// show reply comment/reply by admin
			$data['reviewreplyauthor'] = $this->config->get('cireviewpro_reviewreplyauthor');
			$results = $this->model_cireviewpro_cireview->getCiReviewsByProductId($filter_data);
			$thumbwidth = (int)$this->config->get('cireviewpro_reviewimagesthumb_width');
			$thumbheight = (int)$this->config->get('cireviewpro_reviewimagesthumb_height');
			if(empty($thumbwidth) || is_null($thumbwidth) ) {
				$thumbwidth = 100;
			}
			if(empty($thumbheight) || is_null($thumbheight) ) {
				$thumbheight = 100;
			}
			$popupwidth = (int)$this->config->get('cireviewpro_reviewimagespopup_width');
			$popupheight = (int)$this->config->get('cireviewpro_reviewimagespopup_height');
			if(empty($popupwidth) || is_null($popupwidth) ) {
				$popupwidth = 500;
			}
			if(empty($popupheight) || is_null($popupheight) ) {
				$popupheight = 500;
			}
			
			$data['reviewabuse'] = false;
			if($this->config->get('cireviewpro_reviewabuse')) {
				if($this->customer->isLogged() || $this->config->get('cireviewpro_reviewabuseguest')) {
					$data['reviewabuse'] = true;
				}
			}
			$data['reviewvote'] = false;
			if($this->config->get('cireviewpro_reviewgetvote')) {
				if($this->customer->isLogged() || $this->config->get('cireviewpro_reviewvoteguest')) {
					$data['reviewvote'] = true;
				}
			}
			
			$reviewvote_info = $this->config->get('cireviewpro_reviewvote');
			if(isset($reviewvote_info[(int)$this->config->get('config_language_id')])) {
				$reviewvote = $reviewvote_info[(int)$this->config->get('config_language_id')];
			} else {
				reset($reviewvote_info);
				$first_key = key($reviewvote_info);
				$reviewvote = $reviewvote_info[$first_key];
			}
			foreach($reviewvote as $key => $votetext) {
				if(empty($votetext)) {
					$reviewvote[$key] =	$this->language->get('text_reviewvote_'.$key);
				}
			}
			foreach ($results as $result) {
				$cireview_info = $this->model_cireviewpro_cireview->getCiReviewByReviewId($result['review_id']);
				
				$result['cireview_ratings'] = array();
				$result['attach_images'] = array();
				$result['votes'] = array();
				$result['votes']['before_text'] = $reviewvote['before'];
				if($this->config->get('cireviewpro_reviewvotetype') == 'PERCENT') {
				$result['votes']['after_text'] = str_replace('{PERCENTAGE}','0',$reviewvote['percent'] );
				}
				if($this->config->get('cireviewpro_reviewvotetype') == 'OUTOF') {
					$result['votes']['after_text'] = str_replace(array('{VOTES}', '{TOTAL_VOTES}'), array('0', '0'), $reviewvote['outof']);
				}
				$result['cireview_id'] = 0;
				$result['comment'] = '';
				$result['title'] = '';
				$result['imp'] = '';
		
				if($cireview_info) {
					$result['cireview_id'] = $cireview_info['cireview_id'];
					$result['comment'] = $cireview_info['comment'];
					$result['title'] = $cireview_info['title'];
					$result['imp'] = $cireview_info['imp'];
					
					if($data['reviewvote']) {
						$total_voteup = 0;
						$total_votedown = 0;
						$total_votes = 0;
						$cireview_votes = $this->model_cireviewpro_cireview->getCiReviewVotes($cireview_info['cireview_id']);
						if($cireview_votes) {
							$total_votes = count($cireview_votes);
							
							foreach ($cireview_votes as $cireview_vote) {
								if($cireview_vote['vote']==1) {
									$total_voteup++;
								}
								if($cireview_vote['vote']==0) {
									$total_votedown++;
								}
							}
							
							if($this->config->get('cireviewpro_reviewvotetype') == 'PERCENT') {
								
							$result['votes']['after_text'] = str_replace('{PERCENTAGE}', round($total_voteup*100/$total_votes,2), $reviewvote['percent'] );
							}
							if($this->config->get('cireviewpro_reviewvotetype') == 'OUTOF') {
								$result['votes']['after_text'] = str_replace(array('{VOTES}', '{TOTAL_VOTES}'), array($total_voteup, $total_votes), $reviewvote['outof']);
							}
						}
					}
					if($this->config->get('cireviewpro_reviewrating')) {
		
						$cireview_ratings = $this->model_cireviewpro_cireview->getCiReviewRatings($cireview_info['cireview_id']);
						foreach($cireview_ratings as $cireview_rating) {
							$ciratingtype_name = '';
							$ratingtype = $this->model_cireviewpro_cireview->getCiRatingType($cireview_rating['ciratingtype_id']);
							if($ratingtype) {
								$ciratingtype_name = $ratingtype['name'];
							} else {
								$ciratingtype_names = json_decode($cireview_rating['ciratingtype_name'],1);
								if(!empty($ciratingtype_names)) {
									if(isset($ciratingtype_names[(int)$this->config->get('config_language_id')])) {
										$ciratingtype_name = $ciratingtype_names[(int)$this->config->get('config_language_id')];
									} else {
										reset($ciratingtype_names);
										$ciratingtype_name = end($ciratingtype_names);
									}
								}
							}
							
							$result['cireview_ratings'][] = array(
								'cireview_rating_id' => $cireview_rating['cireview_rating_id'],
								'ciratingtype_id' => $cireview_rating['ciratingtype_id'],
								'ciratingtype_name' => $ciratingtype_name,
								'rating' => $cireview_rating['rating'],
								'show_rating' => (int)$cireview_rating['rating'],
							);
						}
					
					}
					$attach_images = $this->model_cireviewpro_cireview->getCiReviewAttachImages($cireview_info['cireview_id']);
					foreach ($attach_images as $attach_image) {
						if(!empty($attach_image['image']) && file_exists(DIR_IMAGE .$attach_image['image'] )) {
							$thumb = $this->model_tool_image->resize($attach_image['image'], $thumbwidth, $thumbheight ) ;
							$popup = $this->model_tool_image->resize($attach_image['image'], $popupwidth, $popupheight ) ;
						} else {
							$thumb = $this->model_tool_image->resize('no_image.png', $thumbwidth, $thumbheight ) ;
							$popup = $this->model_tool_image->resize('no_image.png', $popupwidth, $popupheight ) ;
						}
						$image_description = $this->model_cireviewpro_cireview->getCiReviewImagesDescriptions($attach_image['cireview_image_id']);
						$result['attach_images'][] = array(
							'cireview_image_id' => $attach_image['cireview_image_id'],
							'thumb' => $thumb,
							'popup' => $popup,
							'alt' => !empty($image_description['alt']) ? htmlentities($image_description['alt'], ENT_QUOTES, 'UTF-8') : '',
							'title' => !empty($image_description['title']) ? htmlentities($image_description['title'], ENT_QUOTES, 'UTF-8') : '',
						);
					}
			
				}
				
				$reviewdateformat = $this->config->get('cireviewpro_reviewdateformat');
				if(empty($reviewdateformat)) {
					$reviewdateformat = $this->language->get('date_format_short');
				}
				$date_added = date($reviewdateformat, strtotime($result['date_added']));
				if($this->config->get('cireviewpro_reviewaddon') == 'DAYSAGO') {
					// load language cireviewpro/cireview first.
					$date_added = $this->model_cireviewpro_cireview->timeElapsedString($result['date_added']);
				}
				/*31-10-2018 verify purchase info start*/
				$cireviewverify_info = $this->model_cireviewpro_cireview->getCiReviewVerify($result['review_id']);
				$verified = false;
				if($cireviewverify_info) {
					$verified = $cireviewverify_info['review'] == 1;
				}
				/*31-10-2018 verify purchase info end*/
				$data['reviews'][] = array(
					'review_id'     => $result['review_id'],
					'imp'     => $result['imp'],
					'verified'     => $verified,
					'cireview_id'     => $result['cireview_id'],
					'author'     => $result['author'],
					'text'       => nl2br($result['text']),
					'reviewtitle'       => (int)$this->config->get('cireviewpro_reviewpagetitleshow') ? nl2br($result['title']) : '',
					'comment'       => (int)$this->config->get('cireviewpro_reviewreply') ? nl2br($result['comment']) : '',
					'rating'     => $this->config->get('cireviewpro_reviewrating') ? (int)$result['rating'] : 0,
					'attach_images'     => $result['attach_images'],
					'show_rating'     => (int)$result['rating'],
					'votes'     => $result['votes'],
					'cireview_ratings'     => $result['cireview_ratings'],
					'date_added' => $date_added,
					'share' => $this->url->link('cireviewpro/cireviews', 'review_id=' . $result['review_id']),
				);
			}
			$data['reviewshare'] = $this->config->get('cireviewpro_reviewshare');
			
			$data['sharetype'] = $this->config->get('cireviewpro_sharetype');
			
			$data['reviewratingcount'] = $this->config->get('cireviewpro_reviewratingcount');
						
			
			$url = '';
			if (isset($this->request->get['cirating_filter'])) {
				$url .= '&cirating_filter=' . $this->request->get['cirating_filter'];
			}
			
			$pagination = new Pagination();
			$pagination->total = $review_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('cireviewpro/cireview/review', 'product_id=' . $this->request->get['product_id'] . '&ajax=1&page={page}' . $url);
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($review_total - $limit)) ? $review_total : ((($page - 1) * $limit) + $limit), $review_total, ceil($review_total / $limit));
			$data['product_id'] = $product_info['product_id'];
			
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireviews_product_tab.tpl')) {
				$output = $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireviews_product_tab.tpl', $data);
				} else {
					$output = $this->load->view('default/template/cireviewpro/cireviews_product_tab.tpl', $data);
				}
			} else{
				$output = $this->load->view('cireviewpro/cireviews_product_tab', $data);
			}
			if(isset($this->request->get['ajax']) && $this->request->get['ajax']=1) {
				$this->response->setOutput($output);
			} else {
				return $output;	
			}
		}
	}
	public function write() {
		$this->response->addHeader('Content-Type: application/json');
		$this->load->language('product/product');
		$this->load->language('cireviewpro/cireview');
		$this->load->model('cireviewpro/cireview');
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			$purchasefirst = false;
			// check purchasefirst condition when customer is login and verify purchase for review or coupon or reward is enable
			if($this->customer->isLogged() && ($this->config->get('cireviewpro_reviewpurchaseonly') || $this->config->get('cireviewpro_reviewcouponpurchaseonly') || $this->config->get('cireviewpro_reviewrewardpurchaseonly'))) {
				$purchasefirst = $this->model_cireviewpro_cireview->isRequirePurchaseFirst($this->request->get['product_id'],(array)$this->config->get('cireviewpro_verifypurchase_orderstatus'));
			}
			$verifypurchasereward = true;
			$verifypurchasecoupon = true;
			if($this->config->get('cireviewpro_reviewcouponpurchaseonly')) {
				//echo "purchasefirst :" . $purchasefirst; 
				//echo "\n";
				$verifypurchasecoupon = !$purchasefirst; 
				//echo '$verifypurchasecoupon:' .$verifypurchasecoupon;
				//echo "\n";
				// echo $verifypurchasecoupon;die;
				// if guest then no need to give coupon, with varifypurchase only enabled
				if(!$this->customer->isLogged()) {
					$verifypurchasecoupon = false;
				}
			}
			if($this->config->get('cireviewpro_reviewrewardpurchaseonly')) {
				//echo '$purchasefirst: ' . $purchasefirst;
				$verifypurchasereward = !$purchasefirst; 
				//echo "\n";
				//echo '$verifypurchasereward: ' . $verifypurchasereward;
				//echo "\n";
			}
			// check customer login and make sure review can give for verify purchase only. when order status in order status for verify purchase.
			if($this->customer->isLogged() && $this->config->get('cireviewpro_reviewpurchaseonly')) {
				/*31-10-2018*/
				if(!$purchasefirst) {
					$json['error'] = $this->language->get('error_purchasereviewgiven');
					$this->response->setOutput(json_encode($json));
					$this->response->output();
					exit();	
				}
			}
			// check customer login and max reviews attempts against product
			// now we also make sure Allow Review To Purchasers only is disable as well
			if($this->customer->isLogged() && (int)$this->config->get('cireviewpro_reviewmax') > 0 && !$this->config->get('cireviewpro_reviewpurchaseonly')) {
				$customer_reviews = $this->model_cireviewpro_cireview->getCustomerTotalReviews($this->customer->getId(), $this->request->get['product_id']);
				if($customer_reviews->num_rows >= (int)$this->config->get('cireviewpro_reviewmax')) {
					$json['error'] = $this->language->get('error_max_reviews');
					$this->response->setOutput(json_encode($json));
					$this->response->output();
					exit();	
				}
			}
			
			// Agree to terms
			if ($this->config->get('cireviewpro_reviewterm_id')) {
				$this->load->model('catalog/information');
				$information_info = $this->model_catalog_information->getInformation($this->config->get('cireviewpro_reviewterm_id'));
				if ($information_info && !isset($this->request->post['reviewterm'])) {
					$json['error'] = sprintf($this->language->get('error_agree'), $information_info['title']);
					$this->response->setOutput(json_encode($json));
					$this->response->output();
					exit();	
				}
			}
			
			if($this->config->get('cireviewpro_reviewauthor') && $this->config->get('cireviewpro_reviewauthor_require')) {
				if ((utf8_strlen($this->request->post['ciname']) < 3) || (utf8_strlen($this->request->post['ciname']) > 25)) {
					$json['name'] = $this->language->get('error_name');
				}
			}
			if($this->config->get('cireviewpro_reviewtitle') && $this->config->get('cireviewpro_reviewtitle_require')) {
				if ((utf8_strlen($this->request->post['cititle']) < 3) || (utf8_strlen($this->request->post['cititle']) > 255)) {
					$json['title'] = $this->language->get('error_title');
				}
			}
			if($this->config->get('cireviewpro_reviewtext') && $this->config->get('cireviewpro_reviewtext_require')) {
				if ((utf8_strlen($this->request->post['cireview']) < 25) || (utf8_strlen($this->request->post['cireview']) > 1000)) {
					$json['text'] = $this->language->get('error_text');
				}
			}
			if($this->config->get('cireviewpro_reviewemail')) {
				if ((utf8_strlen($this->request->post['ciemail']) > 96) || !filter_var($this->request->post['ciemail'], FILTER_VALIDATE_EMAIL)) {
					$json['email'] = $this->language->get('error_email');
				}
			}
			if($this->config->get('cireviewpro_rating')) {
				$stars = 5;
				if($this->config->get('cireviewpro_ratingstars')) {
					$stars = $this->config->get('cireviewpro_ratingstars');
				}
				
				if(isset($this->request->post['cirating'])) {
					foreach($this->request->post['cirating'] as $ciratingtype_id => $rating) {
						if (empty($rating) || $rating < 0 || $rating > $stars) {
							$ciratingtype_info = $this->model_cireviewpro_cireview->getCiRatingType($ciratingtype_id);
							if($ciratingtype_info) {
								$json['rating'][$ciratingtype_id] = sprintf($this->language->get('error_cirating'), $ciratingtype_info['name'] );
							} else {
								$json['rating'][$ciratingtype_id] = $this->language->get('error_rating');
							}
						}
					}
				}
				if(!isset($this->request->post['cirating'])) {
					$ratingtypes = $this->model_cireviewpro_cireview->getCiRatingTypes($this->request->get['product_id']);
					foreach ($ratingtypes as $ratingtype) {
						$json['rating'][$ratingtype['ciratingtype_id']] =sprintf($this->language->get('error_cirating'), $ratingtype['name'] );
					}
				}
			}
			// Captcha
			if (VERSION >= '3.0.0.0' && $this->config->get('cireviewpro_captcha') && $this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
				if ($captcha) {
					$json['captcha'] = $captcha;
				}
			} else if (VERSION < '3.0.0.0' && $this->config->get('cireviewpro_captcha') && $this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				
				if (VERSION <= '2.2.0.0') {
					$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');
				} else {
					$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
				}
				if ($captcha) {
					$json['captcha'] = $captcha;
				}
			}
			if (!$json) {
				$this->load->model('cireviewpro/cireview');
				if(!$this->config->get('cireviewpro_reviewemail')) {
					$this->request->post['ciemail'] = $this->customer->getEmail();
				}
				
				if(!$this->config->get('cireviewpro_reviewtitle')) {
					$this->request->post['cititle'] = '';
				}
				if(!$this->config->get('cireviewpro_reviewauthor')) {
					$this->request->post['ciname'] = '';
					if($this->customer->isLogged()) {
						$this->request->post['ciname'] = $this->customer->getFirstName() .' ' . $this->customer->getLastName();
					}
				}
				if(!$this->config->get('cireviewpro_reviewtext')) {
					$this->request->post['cireview'] = '';
				}
				
				$reviewsuccessmsg_info = (array)$this->config->get('cireviewpro_reviewsuccessmsg');
				$reviewsuccessmsg = array();
				if(isset($reviewsuccessmsg_info[(int)$this->config->get('config_language_id')])) {
					$reviewsuccessmsg = $reviewsuccessmsg_info[(int)$this->config->get('config_language_id')];
				} else {
					reset($reviewsuccessmsg_info);
					$first_key = key($reviewsuccessmsg_info);
					$reviewsuccessmsg = $reviewsuccessmsg_info[$first_key];					
				}
				if(empty($reviewsuccessmsg['message']) || (!empty($reviewsuccessmsg['message']) && $reviewsuccessmsg['message'] == '<p><br></p>') ) {
					$reviewsuccessmsg['message'] = $this->language->get('success_cireview');
				}
				if(empty($reviewsuccessmsg['messagepending']) || (!empty($reviewsuccessmsg['messagepending']) && $reviewsuccessmsg['messagepending'] == '<p><br></p>') ) {
					$reviewsuccessmsg['messagepending'] = $this->language->get('success_cireview_pending');
				}
				if(empty($reviewsuccessmsg['rewardpoints']) || (!empty($reviewsuccessmsg['rewardpoints']) && $reviewsuccessmsg['rewardpoints'] == '<p><br></p>') ) {
					$reviewsuccessmsg['rewardpoints'] = '<br/>'.$this->language->get('success_rewardpoints');
				}
				if(empty($reviewsuccessmsg['couponcode']) || (!empty($reviewsuccessmsg['couponcode']) && $reviewsuccessmsg['couponcode'] == '<p><br></p>') ) {
					$reviewsuccessmsg['couponcode'] = '<br/>'.$this->language->get('success_coupon');
				}
				if(empty($reviewsuccessmsg['title']) || (!empty($reviewsuccessmsg['title']) && $reviewsuccessmsg['title'] == '<p><br></p>') ) {
					$reviewsuccessmsg['title'] = $this->language->get('success_cireview_title');
				}
				/*decode html entites for all messages*/
				foreach ($reviewsuccessmsg as $key => &$value) {
					$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
				}
				if($this->config->get('cireviewpro_rewardsuccessalert') == 'POPUP') {
					$json['reviewsuccessmsg_title'] = $reviewsuccessmsg['title'];
				}
				$json['success'] = $reviewsuccessmsg['messagepending'] ;
				$json['refresh'] = false;
				if($this->customer->isLogged() && ($this->config->get('cireviewpro_reviewapprove')=='LOGGED' || $this->config->get('cireviewpro_reviewapprove')=='BOTH')) {
					$json['success'] = $reviewsuccessmsg['message'];
					$json['refresh'] = true;
				} elseif($this->config->get('cireviewpro_reviewapprove')=='BOTH') {
					$json['success'] = $reviewsuccessmsg['message'];
					$json['refresh'] = true;
				}
				
				$this->request->post['coupon_code'] = '';
				$coupon_code = '';
				
				$this->request->post['coupon_id'] = 0;
				
				if($this->config->get('cireviewpro_reviewcoupon') && ($this->customer->isLogged() || $this->config->get('cireviewpro_reviewcouponguest')) && $verifypurchasecoupon) {
					// generate coupon here and save the code in our records as well.
/*echo "I am inside coupon system. Shall i need to be here?";
echo "\n";
die;*/
					
					do {
						$code = token(10);
						$coupon_info = $this->model_cireviewpro_cireview->getCouponByCode($code);
					} while ($coupon_info);
					$coupon_code = $this->request->post['coupon_code'] = $code;
					$days = 1;
					if((int)$this->config->get('cireviewpro_reviewcoupondays')) {
						$days = (int)$this->config->get('cireviewpro_reviewcoupondays');
					}
					
					$date_start = date('Y-m-d');
					$date_end = date('Y-m-d', strtotime('+ '. $days .' DAYS' . $date_start));
					$coupon = array(
						'name' => $code,
						'code' => $code,
						'discount' => $this->config->get('cireviewpro_reviewcoupondiscount'),
						'type' => $this->config->get('cireviewpro_reviewcoupontype'),
						'total' => $this->config->get('cireviewpro_reviewcoupontotal'),
						'logged' => $this->config->get('cireviewpro_reviewcouponlogged'),
						'shipping' => $this->config->get('cireviewpro_reviewcouponshipping'),
						'date_start' => $date_start,
						'date_end' => $date_end,
						'uses_total' => $this->config->get('cireviewpro_reviewcouponuses_total'),
						'uses_customer' => $this->config->get('cireviewpro_reviewcouponuses_customer'),
						'status' => 1,
						'coupon_product' => (array)$this->config->get('cireviewpro_reviewcoupon_product'),
						'coupon_category' => (array)$this->config->get('cireviewpro_reviewcoupon_category'),
					);
					
					$coupon_id = $this->model_cireviewpro_cireview->addCoupon($coupon);
					$this->request->post['coupon_id'] = $coupon_id;
					
					$json['success'] .= str_replace('{COUPON_CODE}', $coupon_code, $reviewsuccessmsg['couponcode']);
					
				}
				
				$this->request->post['reward_points'] = '';
				$this->request->post['customer_reward_id'] = 0;
				if($this->customer->isLogged() && ($this->config->get('cireviewpro_reviewreward') && (int)$this->config->get('cireviewpro_rewardpoints') > 0) && $verifypurchasereward) {
/*echo "I am inside reward points. Shall i need to be here?";
echo "\n";
die;*/
					$reward_points = (int)$this->config->get('cireviewpro_rewardpoints');
					$point = array(
						'reward_points' => $reward_points,
						'description' => $this->config->get('cireviewpro_rewarddesc'),
					);
					$customer_reward_id = $this->model_cireviewpro_cireview->addRewardPoints($point);
					if($customer_reward_id) {
						$this->request->post['reward_points'] = $reward_points;
						$this->request->post['customer_reward_id'] = $customer_reward_id;
						
						$json['success'] .= str_replace('{REWARD_POINTS}', $reward_points, $reviewsuccessmsg['rewardpoints']);
						
					}
				}
				$this->model_cireviewpro_cireview->addCiReview($this->request->get['product_id'], $this->request->post);
				
				$filter_data = array(
					'product_id' => $this->request->get['product_id'],
				);
				if($json['refresh']) {
					$data['review_total'] = $review_total = $this->model_cireviewpro_cireview->getTotalCiReviewsByProductId($filter_data);
					$json['tab_review'] = sprintf($this->language->get('tab_review'), $review_total);
					$data['reviewgraph_option'] = $this->config->get('cireviewpro_reviewgraph_option');
					
					$json['cireviewgraph'] = $this->cireviewGraph();
					$json['aggeratereview'] = $this->aggerateReview();
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	private function mkdir($dir) {
		if(!is_dir($dir)) {
			$oldmask = umask(0);
			mkdir($dir, 0777);
			umask($oldmask);
		}
	}
	
	public function upload() {
		$json = array();
		$this->response->addHeader('Content-Type: application/json');
		$this->load->language('tool/upload');
		$this->load->language('cireviewpro/cireview');
		if(!isset($this->request->post['cireview_images'])) {
			$json['error'] = $this->language->get('text_invalid');
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}
		
 		$ids = array_filter(explode(",", $this->request->post['cireview_images']));
		$total_images = count($ids);
		if($total_images >= $this->config->get('cireviewpro_reviewimageslimit')) {
			$json['error'] = sprintf($this->language->get('text_maximage'), $this->config->get('cireviewpro_reviewimageslimit'));
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}
		if (!empty($this->request->files['ciattachfile']['name']) && is_file($this->request->files['ciattachfile']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['ciattachfile']['name'], ENT_QUOTES, 'UTF-8')));
			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}
			// Allowed file extension types
			$allowed = array();
			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('cireviewpro_file_ext_allowed'));
			$filetypes = explode("\n", $extension_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Allowed file mime types
			$allowed = array();
			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('cireviewpro_file_mime_allowed'));
			$filetypes = explode("\n", $mime_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array($this->request->files['ciattachfile']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['ciattachfile']['tmp_name']);
			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Return any upload error
			if ($this->request->files['ciattachfile']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['ciattachfile']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		if (!$json) {
			
			$dir = 'catalog/cireviewpro_images/';
			if($this->config->get('cireviewpro_reviewimagespath')) {
				// remove trailing slah from path.
				do{
					if(substr($this->config->get('cireviewpro_reviewimagespath'), -1) == '/') {
					    $this->config->set('cireviewpro_reviewimagespath', substr($this->config->get('cireviewpro_reviewimagespath'), 0, -1));
					}
				}while(substr($this->config->get('cireviewpro_reviewimagespath'), -1) == '/');
				$dir = $this->config->get('cireviewpro_reviewimagespath').'/';
			}
			$odir = $dir;
			$dirs = explode("/", $dir);
			$mkdir = '';
			foreach ($dirs as $key => $value) {
				$mkdir .= $value.'/';
				$this->mkdir(DIR_IMAGE . $mkdir);
			}
			
			$pathfinfo = pathinfo($filename);
			$mask = $pathfinfo['filename'];
			$filename = 'as1'.time().'sd4' .'.'. $pathfinfo['extension'];
			$ext = $pathfinfo['extension'];
			$file = $dir. $filename;
			move_uploaded_file($this->request->files['ciattachfile']['tmp_name'], DIR_IMAGE . $file);
			// hold all images for temporary
			$this->load->model('cireviewpro/cireview');
			$this->load->model('tool/image');
			// id is cireview_image_id
			$this->model_cireviewpro_cireview->addUpload($file, $mask, $ext);
			
			$json['attach_images'] = array();
			$thumbwidth = (int)$this->config->get('cireviewpro_reviewimagesthumb_width');
			$thumbheight = (int)$this->config->get('cireviewpro_reviewimagesthumb_height');
			if(empty($thumbwidth) || is_null($thumbwidth) ) {
				$thumbwidth = 100;
			}
			if(empty($thumbheight) || is_null($thumbheight) ) {
				$thumbheight = 100;
			}
			
			$popupwidth = (int)$this->config->get('cireviewpro_reviewimagespopup_width');
			$popupheight = (int)$this->config->get('cireviewpro_reviewimagespopup_height');
			if(empty($popupwidth) || is_null($popupwidth) ) {
				$popupwidth = 500;
			}
			if(empty($popupheight) || is_null($popupheight) ) {
				$popupheight = 500;
			}
			$attach_images = $this->model_cireviewpro_cireview->getUploadedImage();
			$ids = array();
			foreach($attach_images as $attach_image) {				
				$ids[] = $attach_image['cireview_image_id'];
				if(!empty($attach_image['image']) && file_exists(DIR_IMAGE .$attach_image['image'] )) {
					$thumb = $this->model_tool_image->resize($attach_image['image'], $thumbwidth, $thumbheight ) ;
					$popup = $this->model_tool_image->resize($attach_image['image'], $popupwidth, $popupheight ) ;
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', $thumbwidth, $thumbheight ) ;
					$popup = $this->model_tool_image->resize('no_image.png', $popupwidth, $popupheight ) ;
				}
				$image_description = $this->model_cireviewpro_cireview->getCiReviewImagesDescriptions($attach_image['cireview_image_id']);
				$json['attach_images'][] = array(
					'cireview_image_id' => $attach_image['cireview_image_id'],
					'thumb' => $thumb,
					'popup' => $popup,
					'alt' => !empty($image_description['alt']) ? htmlentities($image_description['alt'], ENT_QUOTES, 'UTF-8') : '',
					'title' => !empty($image_description['title']) ? htmlentities($image_description['title'], ENT_QUOTES, 'UTF-8') : '',
				);	
				
			}
			$json['code'] = implode(",", $ids);
			$json['success'] = $this->language->get('text_upload');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function delete() {
		$json = array();
		if(!empty($this->request->post['id'])) {
			$this->load->model('cireviewpro/cireview');
			$this->load->model('tool/image');
			$this->model_cireviewpro_cireview->removeUpload($this->request->post['id']);
			$json['success'] = $this->language->get('text_delete');;
			$json['attach_images'] = array();
			$thumbwidth = (int)$this->config->get('cireviewpro_reviewimagesthumb_width');
			$thumbheight = (int)$this->config->get('cireviewpro_reviewimagesthumb_height');
			if(empty($thumbwidth) || is_null($thumbwidth) ) {
				$thumbwidth = 100;
			}
			if(empty($thumbheight) || is_null($thumbheight) ) {
				$thumbheight = 100;
			}
			
			$popupwidth = (int)$this->config->get('cireviewpro_reviewimagespopup_width');
			$popupheight = (int)$this->config->get('cireviewpro_reviewimagespopup_height');
			if(empty($popupwidth) || is_null($popupwidth) ) {
				$popupwidth = 500;
			}
			if(empty($popupheight) || is_null($popupheight) ) {
				$popupheight = 500;
			}
			$attach_images = $this->model_cireviewpro_cireview->getUploadedImage();
			$ids = array();
			foreach($attach_images as $attach_image) {
				if(!empty($attach_image['image']) && file_exists(DIR_IMAGE .$attach_image['image'] )) {
					$thumb = $this->model_tool_image->resize($attach_image['image'], $thumbwidth, $thumbheight ) ;
					$popup = $this->model_tool_image->resize($attach_image['image'], $popupwidth, $popupheight ) ;
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', $thumbwidth, $thumbheight ) ;
					$popup = $this->model_tool_image->resize('no_image.png', $popupwidth, $popupheight ) ;
				}
				$ids[] = $attach_image['cireview_image_id'];
				$image_description = $this->model_cireviewpro_cireview->getCiReviewImagesDescriptions($attach_image['cireview_image_id']);
				$json['attach_images'][] = array(
					'cireview_image_id' => $attach_image['cireview_image_id'],
					'thumb' => $thumb,
					'popup' => $popup,
					'alt' => !empty($image_description['alt']) ? htmlentities($image_description['alt'], ENT_QUOTES, 'UTF-8') : '',
					'title' => !empty($image_description['title']) ? htmlentities($image_description['title'], ENT_QUOTES, 'UTF-8') : '',
				);
				
			}
			$json['code'] = '';
			if($ids) {	$json['code'] = implode(",", $ids); }
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));	
	}
	public function cireviewAbuse() {
		$json = array();
		$this->response->addHeader('Content-Type: application/json');
		$this->load->language('cireviewpro/cireview');
		$this->load->model('cireviewpro/cireview');
		if(!isset($this->request->post['ciabreason'])) {
			$json['error'] = $this->language->get('error_ciabreason');
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}
		// abuse reasons
		$ciabreasons = $this->model_cireviewpro_cireview->getCiAbReasons($this->request->get['product_id']);
		$ciabreasonss = array();
		$ciabreasons_ = array();
		foreach ($ciabreasons as $ciabreason) {
			$ciabreasonss[] = $ciabreason['ciabreason_id'];
			$ciabreasons_[$ciabreason['ciabreason_id']] = array(
				'ciabreason_id' => $ciabreason['ciabreason_id'],
				'name' => $ciabreason['name'],
				'details' => $ciabreason['details'],
			);
		}
		if(isset($this->request->post['ciabreason']) && !in_array($this->request->post['ciabreason'], $ciabreasonss) && $this->request->post['ciabreason'] != 'OTHER' ) {
			$json['error'] = $this->language->get('error_ciabreason_invalid');
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}
		if(isset($this->request->post['ciabreason']) && ($this->request->post['ciabreason']=='OTHER' || (isset($ciabreasons_[$this->request->post['ciabreason']]) && $ciabreasons_[$this->request->post['ciabreason']]['details']==1)) && (utf8_strlen($this->request->post['ciabreason_other']) < 10 || utf8_strlen($this->request->post['ciabreason_other']) > 1000) ) {
			$json['error'] = $this->language->get('error_ciabreason_other');
			$this->response->setOutput(json_encode($json));
			$this->response->output();
			exit();
		}
		if(isset($ciabreasons_[$this->request->post['ciabreason']])) {
			$this->request->post['ciabreason_name'] = $ciabreasons_[$this->request->post['ciabreason']]['name'];
			if($ciabreasons_[$this->request->post['ciabreason']]['details'] == 0) {
				$this->request->post['ciabreason_other'] = '';	
			}
		} else {
			$this->request->post['ciabreason_name'] = $this->language->get('text_other');
			$this->request->post['ciabreason'] = 'OTHER';
		}
		$cireview_abuse = $this->model_cireviewpro_cireview->addCiAbReason($this->request->post);
		$json['success'] = $this->language->get('success_abuse');
		$this->response->setOutput(json_encode($json));
	}
	public function cireviewVote() {
		$json = array();
		$this->response->addHeader('Content-Type: application/json');
		if(!empty($this->request->post['review_id']) && !empty($this->request->post['product_id']) && !empty($this->request->post['cireview_id'])) {
			// check if already voted or not ?
			// we use cookies and session id to manage this.
			$this->load->language('cireviewpro/cireview');
			
			if(isset($this->request->cookies[$this->request->post['cireview_id'].'_cireview_'.$this->request->post['review_id'].'_'.$this->request->post['product_id']])) {
				$json['error'] = $this->language->get('error_alreadyvoted');
				$this->response->setOutput(json_encode($json));
				$this->response->output();
				exit();
			}
			$this->load->model('cireviewpro/cireview');
			$is_voted = $this->model_cireviewpro_cireview->isCiReviewVoted($this->request->post);
			if($is_voted) {
				$json['error'] = $this->language->get('error_alreadyvoted');
				$this->response->setOutput(json_encode($json));
				$this->response->output();
				exit();	
			}
			$cireview_vote_id = $this->model_cireviewpro_cireview->addCiReviewVote($this->request->post);
			$json['success'] = $this->language->get('success_vote');
			setcookie($this->request->post['cireview_id'].'_cireview_'.$this->request->post['review_id'].'_'.$this->request->post['product_id'], 'true'); // Not ask until browser is open. Once browser closes ask again to confirm.
			$reviewvote_info = $this->config->get('cireviewpro_reviewvote');
			if(isset($reviewvote_info[(int)$this->config->get('config_language_id')])) {
				$reviewvote = $reviewvote_info[(int)$this->config->get('config_language_id')];
			} else {
				reset($reviewvote_info);
				$first_key = key($reviewvote_info);
				$reviewvote = $reviewvote_info[$first_key];
			}
			
			/*fill out empty language string*/
			foreach($reviewvote as $key => $votetext) {
				if(empty($votetext)) {
					$reviewvote[$key] =	$this->language->get('text_reviewvote_'.$key);
				}
			}
			
			if($this->request->post['action']==1) {
				$json['before_text'] = $reviewvote['yes'];
			} else {
				$json['before_text'] = $reviewvote['no'];
			}
			$cireview_votes = $this->model_cireviewpro_cireview->getCiReviewVotes($this->request->post['cireview_id']);
			if($cireview_votes) {
				$total_votes = count($cireview_votes);
				$total_voteup = 0;
				$total_votedown = 0;
				foreach ($cireview_votes as $cireview_vote) {
					if($cireview_vote['vote']==1) {
						$total_voteup++;
					}
					if($cireview_vote['vote']==0) {
						$total_votedown++;
					}
				}
		
				if($this->config->get('cireviewpro_reviewvotetype') == 'PERCENT') {
					
				$json['after_text'] = str_replace('{PERCENTAGE}',  round($total_voteup*100/$total_votes,2), $reviewvote['percent'] );
				}
				if($this->config->get('cireviewpro_reviewvotetype') == 'OUTOF') {
					$json['after_text'] = str_replace(array('{VOTES}', '{TOTAL_VOTES}'), array($total_voteup, $total_votes), $reviewvote['outof']);
				}
			}
		}	
		
		$this->response->setOutput(json_encode($json));
	}
}
