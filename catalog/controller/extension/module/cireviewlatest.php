<?php
class ControllerExtensionModuleCiReviewLatest extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/cireviewlatest');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/cireviewpro/cireview.css');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_no_reviews'] = $this->language->get('text_no_reviews');
		
		$data['text_author'] = $this->language->get('text_author');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_allrating'] = $this->language->get('text_allrating');
		$data['text_rating'] = $this->language->get('text_rating');


		$this->load->model('cireviewpro/cireview');
		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['reviews'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 5;
		}

		if(isset($this->request->get['cirating_filter'])) {
			$cirating_filter = $this->request->get['cirating_filter'];
		} else {
			$cirating_filter = 0;
		}

		if(isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
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

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$filter_data = array(
			'product_id' => $product_id,
			'cirating_filter' => $cirating_filter,
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $setting['limit'],
			'limit' => $setting['limit'],
		);

		$results = $this->model_cireviewpro_cireview->getCiReviewsByProductId($filter_data);

		foreach ($results as $result) {
				
			$cireview_info = $this->model_cireviewpro_cireview->getCiReviewByReviewId($result['review_id']);

			

			$result['cireview_id'] = 0;
			$result['comment'] = '';
			$result['title'] = '';
			if($cireview_info) {
				$result['cireview_id'] = $cireview_info['cireview_id'];
				$result['comment'] = $cireview_info['comment'];
				$result['title'] = $cireview_info['title'];
			}

			$product = array();

			$product_info = $this->model_catalog_product->getProduct($result['product_id']);

			if($product_info) {
				
				$productthumb_width = 100;
				$productthumb_height = 100;
				if($setting['productthumb_width']) {
					$productthumb_width = $setting['productthumb_width'];
				}
				if($setting['productthumb_height']) {
					$productthumb_height = $setting['productthumb_height'];
				}



				if(!empty($product_info['image']) && file_exists(DIR_IMAGE .$product_info['image'] )) {
					$thumb = $this->model_tool_image->resize($product_info['image'], $productthumb_width, $productthumb_height ) ;
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', $productthumb_width, $productthumb_height ) ;
				}
				
				$product = array(
					'product_id' => $product_info['product_id'],
					'name' => $product_info['name'],
					'thumb' => $thumb,
					'href' => $this->url->link('product/product','product_id='.$product_info['product_id'], true),
				);
			}

			/*start working 25 july */
			$dateformat = $setting['dateformat'];
			if(empty($dateformat)) {
				$dateformat = $this->config->get('cireviewpro_reviewdateformat');
			}
			if(empty($dateformat)) {
				$dateformat = $this->language->get('date_format_short');
			}
			$date_added = date($dateformat, strtotime($result['date_added']));
			// remove isset after 2 months on 27-09-2018
			if(isset($setting['reviewaddon']) && $setting['reviewaddon'] == 'DAYSAGO') {
				// load language extension/module/cireviewlatest first.
				$date_added = $this->model_cireviewpro_cireview->timeElapsedString($result['date_added']);
			}
			/*end working 25 july */
			$data['reviews'][] = array(
				'review_id'     => $result['review_id'],
				'cireview_id'     => $result['cireview_id'],
				'author'     => $result['author'],
				'text'       => nl2br( strlen($result['text']) > 100 ? substr($result['text'], 0, 100) . ' ' . sprintf($this->language->get('text_cireadmore'), $this->url->link('cireviewpro/cireviews','review_id='.$result['review_id'], true)) : $result['text'] ),
				'reviewtitle'       => (int)$setting['titleshow'] ? nl2br($result['title']) : '',
				'product_id'  => $result['product_id'],
				'product'  => $product,
				'rating'     => (int)$result['rating'],
				'href'     => $this->url->link('cireviewpro/cireviews','review_id='.$result['review_id'], true),
				'date_added' => $date_added,
			);

		}
		$data['ratingshow'] = $setting['ratingshow'];
		$data['ratingshowcount'] = $setting['ratingshowcount'];
		
		if(isset($setting['cireviewpro_position']) && ($setting['cireviewpro_position']=='column_left' || $setting['cireviewpro_position']=='column_right')) {
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cireviewlatest_list.tpl')) {
					$data['reviews_view'] = $this->load->view($this->config->get('config_template') . '/template/module/cireviewlatest_list.tpl', $data);
				} else {
					$data['reviews_view'] = $this->load->view('default/template/module/cireviewlatest_list.tpl', $data);
				}
			} else if(VERSION == '2.2.0.0') {
				$data['reviews_view'] = $this->load->view('module/cireviewlatest_list', $data);
			} else{
				$data['reviews_view'] = $this->load->view('extension/module/cireviewlatest_list', $data);
			}
		} else {
			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cireviewlatest_grid.tpl')) {
					$data['reviews_view'] = $this->load->view($this->config->get('config_template') . '/template/module/cireviewlatest_grid.tpl', $data);
				} else {
					$data['reviews_view'] = $this->load->view('default/template/module/cireviewlatest_grid.tpl', $data);
				}
			} else if(VERSION == '2.2.0.0') {
				$data['reviews_view'] = $this->load->view('module/cireviewlatest_grid', $data);
			} else {
				$data['reviews_view'] = $this->load->view('extension/module/cireviewlatest_grid', $data);
			}
		}

		if(VERSION < '2.2.0.0') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cireviewlatest.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/cireviewlatest.tpl', $data);
			} else {
				return $this->load->view('default/template/module/cireviewlatest.tpl', $data);
			}
		} else if(VERSION == '2.2.0.0') {
			return $this->load->view('module/cireviewlatest', $data);
		} else {
			return $this->load->view('extension/module/cireviewlatest', $data);
		}
	}
}