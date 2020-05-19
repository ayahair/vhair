<?php
class ControllerCiReviewProCiReviews extends Controller {
	public function index() {
		$this->load->language('cireviewpro/cireviews');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/cireviewpro/cireview.css');
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		if($this->config->get('cireviewpro_status')) {
			$this->load->language('cireviewpro/cireview');
			$this->load->model('cireviewpro/cireview');	
			$this->load->model('catalog/product');	
			$this->load->model('catalog/category');	
			$this->load->model('catalog/manufacturer');	
			$this->load->model('tool/image');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$ciurl = array();
			if(!empty($this->request->get['cireview_product_id'])) {
				$filter_cireview_product_id = $this->request->get['cireview_product_id'];
				$ciurl[] = 'cireview_product_id=' . $this->request->get['cireview_product_id'];
			} else {
				$filter_cireview_product_id = null;
			}
			if(!empty($this->request->get['review_id'])) {
				$filter_review_id = $this->request->get['review_id'];
				//$ciurl[] = 'review_id=' . $this->request->get['review_id'];
			} else {
				$filter_review_id = null;
			}
			$cireview_product_id = implode("&", $ciurl);
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
			// no. of stars
			$data['ratingstars'] = 5;
			if((int)$this->config->get('cireviewpro_ratingstars')) {
				$data['ratingstars'] = (int)$this->config->get('cireviewpro_ratingstars');
			}
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'r.date_added';
			}
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			if (isset($this->request->get['limit'])) {
				$limit = (int)$this->request->get['limit'];
			} else {
				$limit = (int)$this->config->get('cireviewpro_reviewpagelimit');
			}
			if(!$limit) {
				$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
				$this->request->get['limit'] = $limit;
			}
			
			if(!empty($this->request->get['cireviewsearch'])) {
				$cireviewsearch = $this->request->get['cireviewsearch'];				
			} else {
				$cireviewsearch = '';
			}
			
			$reviewlistpage_info = $this->config->get('cireviewpro_reviewlistpage');
			if(isset($reviewlistpage_info[(int)$this->config->get('config_language_id')])) {
				$reviewlistpage = $reviewlistpage_info[(int)$this->config->get('config_language_id')];
			} else {
				reset($reviewlistpage_info);
				$first_key = key($reviewlistpage_info);
				$reviewlistpage = $reviewlistpage_info[$first_key];
			}
			if(!empty($this->request->get['cireview_product_id'])) {
				$product_info = $this->model_catalog_product->getProduct($this->request->get['cireview_product_id']);
			}			
			// Set the last review breadcrumb
			if(!empty($product_info)) {
				$data['breadcrumbs'][] = array(
					'text' => $product_info['name'],
					'href' => $this->url->link('product/product', 'product_id='. $product_info['product_id'] )
				);
			}
		
			$data['breadcrumbs'][] = array(
				'text' => $reviewlistpage['title'],
				'href' => $this->url->link('cireviewpro/cireviews', $cireview_product_id )
			);
			
			$this->document->setTitle($reviewlistpage['meta_title']);
			$this->document->setDescription($reviewlistpage['meta_description']);
			$this->document->setKeywords($reviewlistpage['meta_keyword']);
			$data['heading_title'] = $reviewlistpage['meta_title'];
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			$data['text_author'] = $this->language->get('text_author');
			$data['text_title'] = $this->language->get('text_title');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_rating'] = $this->language->get('text_rating');
			$data['text_limit'] = $this->language->get('text_limit');
			$data['text_limit'] = $this->language->get('text_limit');
			$data['text_no_reviews'] = $this->language->get('text_no_reviews');
			$data['text_replyby'] = $this->language->get('text_replyby');
			$data['text_verified'] = $this->language->get('text_verified');
			$data['text_search'] = $this->language->get('text_search');
			
			$data['description'] = html_entity_decode($reviewlistpage['message'], ENT_QUOTES, 'UTF-8');
			// show reply comment/reply by admin
			$data['reviewreplyauthor'] = $this->config->get('cireviewpro_reviewreplyauthor');
			$data['reviewshare'] = $this->config->get('cireviewpro_reviewshare');
			
			$data['reviewratingcount'] = $this->config->get('cireviewpro_reviewratingcount');
			
			$data['reviewsearch'] = $this->config->get('cireviewpro_reviewsearch');
			
			
			$thumbwidth = (int)$this->config->get('cireviewpro_reviewpageimagesthumb_width');
			$thumbheight = (int)$this->config->get('cireviewpro_reviewpageimagesthumb_height');
			if(empty($thumbwidth) || is_null($thumbwidth) ) {
				$thumbwidth = 100;
			}
			if(empty($thumbheight) || is_null($thumbheight) ) {
				$thumbheight = 100;
			}
			
			$popupwidth = (int)$this->config->get('cireviewpro_reviewpageimagespopup_width');
			$popupheight = (int)$this->config->get('cireviewpro_reviewpageimagespopup_height');
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
			if($this->config->get('cireviewpro_reviewvote')) {
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
			$filter_data = array(
				'filter_cireview_product_id' => $filter_cireview_product_id,
				'filter_review_id' => $filter_review_id,
				
				'filter_cireviewsearch' => $cireviewsearch,
				
				'sort' => $sort,
				'order' => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$review_total = $this->model_cireviewpro_cireview->getTotalCiReviews($filter_data);
			$results = $this->model_cireviewpro_cireview->getCiReviews($filter_data);
			$data['reviews'] = array();
			foreach ($results as $result) {
				$result['cireview_ratings'] = array();
				$result['attach_images'] = array();
				$result['votes'] = array();
				if($data['reviewvote']) {
					$total_voteup = 0;
					$total_votedown = 0;
					$total_votes = 0;
					$cireview_votes = $this->model_cireviewpro_cireview->getCiReviewVotes($result['cireview_id']);
					$result['votes']['before_text'] = $reviewvote['before'];
					if($this->config->get('cireviewpro_reviewvotetype') == 'PERCENT') {
					$result['votes']['after_text'] = str_replace('{PERCENTAGE}','0',$reviewvote['percent'] );
					}
					if($this->config->get('cireviewpro_reviewvotetype') == 'OUTOF') {
						$result['votes']['after_text'] = str_replace(array('{VOTES}', '{TOTAL_VOTES}'), array('0', '0'), $reviewvote['outof']);
					}
					
					
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
					$cireview_ratings = $this->model_cireviewpro_cireview->getCiReviewRatings($result['cireview_id']);
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
							'show_rating' => $cireview_rating['rating'],
						);
					}
				}
				
				$attach_images = $this->model_cireviewpro_cireview->getCiReviewAttachImages($result['cireview_id']);
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
				$product = array();
				$product_info = $this->model_catalog_product->getProduct($result['product_id']);
				if($product_info) {
					
					$productthumb_width = 100;
					$productthumb_height = 100;
					if($this->config->get('cireviewpro_reviewpageproductthumb_width')) {
						$productthumb_width = $this->config->get('cireviewpro_reviewpageproductthumb_width');
					}
					if($this->config->get('cireviewpro_reviewpageproductthumb_height')) {
						$productthumb_height = $this->config->get('cireviewpro_reviewpageproductthumb_height');
					}
					if(!empty($product_info['image']) && file_exists(DIR_IMAGE .$product_info['image'] )) {
						$thumb = $this->model_tool_image->resize($product_info['image'], $productthumb_width, $productthumb_height ) ;
					} else {
						$thumb = $this->model_tool_image->resize('no_image.png', $productthumb_width, $productthumb_height ) ;
					}
					
					$product = array(
						'name' => $product_info['name'],
						'thumb' => $thumb,
						'href' => $this->url->link('product/product','product_id='.$product_info['product_id'], true),
					);
				}
				
				$reviewdateformat = $this->config->get('cireviewpro_reviewpagedateformat');
				if(empty($reviewdateformat)) {
					$reviewdateformat = $this->language->get('date_format_short');
				}
				$date_added = date($reviewdateformat, strtotime($result['date_added']));
				if($this->config->get('cireviewpro_reviewpageaddon') == 'DAYSAGO') {
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
					'review_id'  => $result['review_id'],
					'imp'     => $result['imp'],
					'verified'     => $verified,
					'cireview_id'  => $result['cireview_id'],
					'comment'  => (int)$this->config->get('cireviewpro_reviewreply') ? nl2br($result['comment']) : '',
					'reviewtitle'  => (int)$this->config->get('cireviewpro_reviewpagetitleshow') ? nl2br($result['title']) : '',
					'product_id'  => $result['product_id'],
					'product'  => $product,
					'author'        => $result['author'],
					'text'        => nl2br($result['text']),
					'rating'        => $this->config->get('cireviewpro_reviewrating') ? (int)$result['rating'] : 0,
					'attach_images'     => $result['attach_images'],
					'votes'     => $result['votes'],
					'cireview_ratings'     => $result['cireview_ratings'],
					'date_added'        => $date_added,
					'share' => $this->url->link('cireviewpro/cireviews', 'review_id=' . $result['review_id']),
					
				);
			}
			$url = '';
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			if (isset($this->request->get['cireviewsearch'])) {
				$url .= '&cireviewsearch=' . $this->request->get['cireviewsearch'];
			}
			
			$data['sorts'] = array();
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'r.cireview_id-ASC',
				'href'  => $this->url->link('cireviewpro/cireviews', $cireview_product_id.'&sort=r.cireview_id&order=ASC' . $url)
			);
			
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'r.rating-DESC',
				'href'  => $this->url->link('cireviewpro/cireviews', $cireview_product_id.'&sort=r.rating&order=DESC' . $url)
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'r.rating-ASC',
				'href'  => $this->url->link('cireviewpro/cireviews', $cireview_product_id.'&sort=r.rating&order=ASC' . $url)
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('cireviewpro/cireviews', $cireview_product_id.'&sort=p.date_added&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'p.date_added-ASC',
				'href'  => $this->url->link('cireviewpro/cireviews', $cireview_product_id.'&sort=p.date_added&order=ASC' . $url)
			);
			
			$url = $cireview_product_id;
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['cireviewsearch'])) {
				$url .= '&cireviewsearch=' . $this->request->get['cireviewsearch'];
			}
			
			$data['limits'] = array();
			$limits = array_unique(array($this->config->get('cireviewpro_reviewpagelimit'), 25, 50, 75, 100));
			sort($limits);
			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('cireviewpro/cireviews', $url . '&limit=' . $value)
				);
			}
			
			$data['reviewsortshow'] = $this->config->get('cireviewpro_reviewsortshow');
			if(!$data['reviewsortshow']) {
				$data['limits'] = array();
				$data['sorts'] = array();
			}
			
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			if (isset($this->request->get['cireviewsearch'])) {
				$url .= '&cireviewsearch=' . $this->request->get['cireviewsearch'];
			}
			
			
			$pagination = new Pagination();
			$pagination->total = $review_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('cireviewpro/cireviews', $cireview_product_id .  $url . '&page={page}');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($review_total - $limit)) ? $review_total : ((($page - 1) * $limit) + $limit), $review_total, ceil($review_total / $limit));
			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('cireviewpro/cireviews', $cireview_product_id, true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('cireviewpro/cireviews', $cireview_product_id, true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('cireviewpro/cireviews', $cireview_product_id . '&page='. ($page - 1), true), 'prev');
			}
			
			if ($limit && ceil($review_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('cireviewpro/cireviews', $cireview_product_id . '&page='. ($page + 1), true), 'next');
			}
			$data['filter_cireview_product_id'] = $filter_cireview_product_id;
			$data['filter_review_id'] = $filter_review_id;
			$data['sort'] = $sort;
			
			$data['cireviewsearch'] = $cireviewsearch;
			
			$data['order'] = $order;
			$data['limit'] = $limit;
			$data['promo_products'] = array();
			$data['promo_categories'] = array();
			$data['promo_manufacturers'] = array();
			$reviewpromo_info = $this->config->get('cireviewpro_reviewpromo');
			if(isset($reviewpromo_info[(int)$this->config->get('config_language_id')])) {
				$reviewpromo = $reviewpromo_info[(int)$this->config->get('config_language_id')];
			} else {
				reset($reviewpromo_info);
				$first_key = key($reviewpromo_info);
				$reviewpromo = $reviewpromo_info[$first_key];
			}
			$data['text_promoproduct_title'] = $reviewpromo['product'];
			$data['text_promocategory_title'] = $reviewpromo['category'];
			$data['text_promomanufacturer_title'] = $reviewpromo['manufacturer'];
			$data['reviewpromoalign'] = strtolower($this->config->get('cireviewpro_reviewpromoalign'));
			$data['reviewpromoproductnameshow'] = $this->config->get('cireviewpro_reviewpromoproductnameshow');
			$data['reviewpromocategorynameshow'] = $this->config->get('cireviewpro_reviewpromocategorynameshow');
			$data['reviewpromomanufacturernameshow'] = $this->config->get('cireviewpro_reviewpromomanufacturernameshow');
			if($this->config->get('cireviewpro_reviewpromoshow')) {
				// promo product			
				if($this->config->get('cireviewpro_product')) {
					foreach ($this->config->get('cireviewpro_product') as $cireviewproduct_id) {
						$product_info = $this->model_catalog_product->getProduct($cireviewproduct_id);
						if($product_info) {
							if(!empty($product_info['image']) && file_exists(DIR_IMAGE . $product_info['image'])) {
								$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('cireviewpro_reviewpromoproduct_width'), $this->config->get('cireviewpro_reviewpromoproduct_height'));
							} else {
								$image = $this->model_tool_image->resize('no_image.png', $this->config->get('cireviewpro_reviewpromoproduct_width'), $this->config->get('cireviewpro_reviewpromoproduct_height'));
							}
							if ($this->config->get('cireviewpro_reviewpromoproductpriceshow')) {
								$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
							} else {
								$price = false;
							}
						
							if ((float)$product_info['special']) {
								$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
							} else {
								$special = false;
							}
							if ($this->config->get('config_tax')) {
								$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
							} else {
								$tax = false;
							}
							if ($this->config->get('cireviewpro_reviewpromoproductratingshow')) {
								$rating = $product_info['rating'];
							} else {
								$rating = false;
							}
							$data['promo_products'][] = array(
								'product_id' => $product_info['product_id'],
								'thumb' => $image,
								'name' => $product_info['name'],
								'price'       => $price,
								'special'     => $special,
								'tax'         => $tax,
								'rating'      => $rating,
								'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
							);
						}
					}
				}
				
				// promo category
				if($this->config->get('cireviewpro_category')) {
					foreach ($this->config->get('cireviewpro_category') as $category_id) {
						$category_info = $this->model_catalog_category->getCategory($category_id);
						if($category_info) {
							if(!empty($category_info['image']) && file_exists(DIR_IMAGE . $category_info['image'])) {
								$image = $this->model_tool_image->resize($category_info['image'], $this->config->get('cireviewpro_reviewpromocategory_width'), $this->config->get('cireviewpro_reviewpromocategory_height'));
							} else {
								$image = $this->model_tool_image->resize('no_image.png', $this->config->get('cireviewpro_reviewpromocategory_width'), $this->config->get('cireviewpro_reviewpromocategory_height'));
							}
							$path = array();
							// get parent category_ids if we have. So we can get correct path.
							$path_query = $this->model_cireviewpro_cireview->getCategoryPath($category_info['category_id']);
							if($path_query->num_rows) {
								foreach($path_query->rows as $row) {
									$path[] = $row['path_id'];
								}
							}
							$path[] = $category_info['category_id'];
							$data['promo_categories'][] = array(
								'category_id' => $category_info['category_id'],
								'thumb' => $image,
								'name' => $category_info['name'],
								'href'        => $this->url->link('product/category', 'path=' . implode('_', $path) )
							);
						}
					}
				}
				// promo manufacturer			
				if($this->config->get('cireviewpro_manufacturer')) {
					foreach ($this->config->get('cireviewpro_manufacturer') as $manufacturer_id) {
						$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
						if($manufacturer_info) {
							if(!empty($manufacturer_info['image']) && file_exists(DIR_IMAGE . $manufacturer_info['image'])) {
								$image = $this->model_tool_image->resize($manufacturer_info['image'], $this->config->get('cireviewpro_reviewpromomanufacturer_width'), $this->config->get('cireviewpro_reviewpromomanufacturer_height'));
							} else {
								$image = $this->model_tool_image->resize('no_image.png', $this->config->get('cireviewpro_reviewpromomanufacturer_width'), $this->config->get('cireviewpro_reviewpromomanufacturer_height'));
							}
							$data['promo_manufacturers'][] = array(
								'manufacturer_id' => $manufacturer_info['manufacturer_id'],
								'thumb' => $image,
								'name' => $manufacturer_info['name'],
								'href'        => $this->url->link('product/manufacturer', 'manufacturer_id=' . $manufacturer_info['manufacturer_id'] )
							);
						}
					}
				}
			}
			if($this->config->get('cireviewpro_reviewperrow')) {
				$data['reviewperrow'] = (int)$this->config->get('cireviewpro_reviewperrow');	
			} else {
				$data['reviewperrow'] = 1;
			}
			$data['text_product'] = $this->language->get('text_product');
			$data['text_attachments'] = $this->language->get('text_attachments');
			$data['text_allrating'] = $this->language->get('text_allrating');
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
			
			$data['customcss'] = $this->config->get('cireviewpro_customcss');
			if( $this->config->get('cireviewpro_reviewview') == 'GRID') {
				if(VERSION < '2.2.0.0') {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireviews_page_grid.tpl')) {
						$data['reviews_view'] = $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireviews_page_grid.tpl', $data);
					} else {
						$data['reviews_view'] = $this->load->view('default/template/cireviewpro/cireviews_page_grid.tpl', $data);
					}
				} else{
					$data['reviews_view'] = $this->load->view('cireviewpro/cireviews_page_grid', $data);
				}
			} else {
				if(VERSION < '2.2.0.0') {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireviews_page_list.tpl')) {
						$data['reviews_view'] = $this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireviews_page_list.tpl', $data);
					} else {
						$data['reviews_view'] = $this->load->view('default/template/cireviewpro/cireviews_page_list.tpl', $data);
					}
				} else{
					$data['reviews_view'] = $this->load->view('cireviewpro/cireviews_page_list', $data);
				}	
			}
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cireviewpro/cireviews_page.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/cireviewpro/cireviews_page.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/cireviewpro/cireviews_page.tpl', $data));
				}
			} else{
				$this->response->setOutput($this->load->view('cireviewpro/cireviews_page', $data));
			}			
		} else {
			$url = '';
			if(isset($this->request->get['cireview_product_id'])) {
				$url .= '&cireview_product_id=' . $this->request->get['cireview_product_id'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			if (isset($this->request->get['cireviewsearch'])) {
				$url .= '&cireviewsearch=' . $this->request->get['cireviewsearch'];
			}
			
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('cireviewpro/cireviews', $url)
			);
			$this->document->setTitle($this->language->get('text_error'));
			$data['heading_title'] = $this->language->get('text_error');
			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
				}
			} else{
				$this->response->setOutput($this->load->view('error/not_found', $data));
			}
		}
	}
}
