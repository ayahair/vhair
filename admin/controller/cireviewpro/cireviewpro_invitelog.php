<?php
class ControllerCiReviewProCiReviewProInviteLog extends Controller {
	private $error = array();
	private $module_token = '';
	private $ci_token = '';

	public function __construct($registry) {
		parent :: __construct($registry);

		if(VERSION <= '2.3.0.2') {
			$this->module_token = 'token';
			$this->ci_token = $this->session->data['token'];
		} else {
			$this->module_token = 'user_token';
			$this->ci_token = $this->session->data['user_token'];
		}
	}

	public function index() {
		$this->load->language('cireviewpro/cireviewpro_invitelog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/cireviewpro_invitelog');

		$this->load->model('cireviewpro/ciratingtype');
		$this->model_cireviewpro_ciratingtype->Buildtable();

		$this->getList();
	}

	public function edit() {
		$this->load->language('cireviewpro/cireviewpro_invitelog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/cireviewpro_invitelog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_cireviewpro_cireviewpro_invitelog->editCiReview($this->request->get['review_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . urldecode(html_entity_decode($this->request->get['filter_order_id'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product'])) {
				$url .= '&filter_product=' . urldecode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urldecode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_store_id'])) {
				$url .= '&filter_store_id=' . urldecode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_review_given'])) {
				$url .= '&filter_review_given=' . urldecode(html_entity_decode($this->request->get['filter_review_given'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . urldecode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cireviewpro/cireviewpro_invitelog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/cireviewpro_invitelog');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $cireviews_id) {
				$this->model_cireviewpro_cireviewpro_invitelog->deleteCiReviewInvite($cireviews_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';			

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . urldecode(html_entity_decode($this->request->get['filter_order_id'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product'])) {
				$url .= '&filter_product=' . urldecode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urldecode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_store_id'])) {
				$url .= '&filter_store_id=' . urldecode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_review_given'])) {
				$url .= '&filter_review_given=' . urldecode(html_entity_decode($this->request->get['filter_review_given'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . urldecode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_store_id'])) {
			$filter_store_id = $this->request->get['filter_store_id'];
		} else {
			$filter_store_id = null;
		}

		if (isset($this->request->get['filter_review_given'])) {
			$filter_review_given = $this->request->get['filter_review_given'];
		} else {
			$filter_review_given = null;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cri.date_added';
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

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . urldecode(html_entity_decode($this->request->get['filter_order_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urldecode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urldecode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . urldecode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_review_given'])) {
			$url .= '&filter_review_given=' . urldecode(html_entity_decode($this->request->get['filter_review_given'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urldecode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->module_token .'=' . $this->ci_token, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url, true)
		);

		$data['ci_token'] = $this->ci_token;
		$data['module_token'] = $this->module_token;
		
		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => '0',
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		

		
		$data['delete'] = $this->url->link('cireviewpro/cireviewpro_invitelog/delete', $this->module_token .'=' . $this->ci_token . $url, true);

		$data['cireviews_invitelogs'] = array();

		$filter_data = array(			
			'filter_order_id'  => $filter_order_id,
			'filter_product'  => $filter_product,
			'filter_customer'  => $filter_customer,
			'filter_store_id'  => $filter_store_id,
			'filter_review_given'  => $filter_review_given,
			'filter_date_added'  => $filter_date_added,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$cireviews_total = $this->model_cireviewpro_cireviewpro_invitelog->getTotalCiReviewsInvites($filter_data);

		$results = $this->model_cireviewpro_cireviewpro_invitelog->getCiReviewsInvites($filter_data);
		
		$this->load->model('tool/image');
		$this->load->model('sale/order');
		
		if(VERSION > '2.0.3.1') {
			$this->load->model('customer/customer');
		} else {
			$this->load->model('sale/customer');
		}


		foreach ($results as $result) {

			$store = $this->language->get('text_default');

			if((int)$result['store_id'] != 0) {
				$store_info = $this->model_setting_store->getStore((int)$result['store_id']);
				if($store_info) {
					$store = $store_info['name'];
				}
			}

			$order_info = $this->model_sale_order->getOrder($result['order_id']);
			$customer = array();
			$customer['is_customer'] = false;
			$customer['firstname'] = false;
			$customer['lastname'] = false;
			$customer['email'] = false;
			$customer_id = 0;
			
			if($order_info) {		
				$customer['firstname'] = $order_info['firstname'];
				$customer['lastname'] = $order_info['lastname'];
				$customer['email'] = $order_info['email'];
				$customer['customer_id'] = $order_info['customer_id'];
				if($order_info['customer_id']) {

					if(VERSION > '2.0.3.1') {
						$customer_info = $this->model_customer_customer->getCustomer($order_info['customer_id']);
					} else {
						$customer_info = $this->model_sale_customer->getCustomer($order_info['customer_id']);
					}

					if($customer_info) {
						$customer['is_customer'] = true;
						$customer['firstname'] = $order_info['firstname'];
						$customer['lastname'] = $order_info['lastname'];
						$customer['email'] = $order_info['email'];
						$customer['href'] = $this->url->link('customer/customer/edit', $this->module_token .'=' . $this->ci_token . '&customer_id=' . $order_info['customer_id'], true);
					}
				}
			}
			$product = array();
			$order_products = $this->model_sale_order->getOrderProducts($result['order_id']);

			foreach ($order_products as $key => $value) {				
				if($value['product_id'] == $result['product_id']) {
					$product['name'] = $value['name'];
					$product['href'] = $this->url->link('catalog/product/edit', $this->module_token .'=' . $this->ci_token . '&product_id=' . $result['product_id'], true);
					break;
				}
			}


			$data['cireviews_invitelogs'][] = array(
				'cireview_invite_id'    => $result['cireview_invite_id'],
				'order_id'    => $result['order_id'],
				'customer'    => $customer,
				'product'    => $product,
				'store'    => $store,
				/*29-08-2018*/'invite'    => $result['invite'],
				'invite_text'    => ($result['invite']) ? $this->language->get('text_reminder_go') : $this->language->get('text_reminder_notgo'),
				'status'    => $result['status'],
				'status_text'    => ($result['status']) ?  $this->language->get('text_enabled') : $this->language->get('text_disabled'),/*29-08-2018*/
				'review_given'    => ($result['review'] != 0) ? $this->language->get('text_given') : $this->language->get('text_pending'),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'      => $this->url->link('cireviewpro/cireviewpro_invitelog/edit', $this->module_token .'=' . $this->ci_token . '&cireview_invite_id=' . $result['cireview_invite_id'] . $url, true)
			);
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_given'] = $this->language->get('text_given');
		$data['text_pending'] = $this->language->get('text_pending');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['column_store'] = $this->language->get('column_store');		
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_review_given'] = $this->language->get('column_review_given');
		/*29-08-2018*/$data['column_invite'] = $this->language->get('column_invite');
		$data['column_status'] = $this->language->get('column_status');/*29-08-2018*/
		$data['column_action'] = $this->language->get('column_action');

		
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_review_given'] = $this->language->get('entry_review_given');


		$data['button_view'] = $this->language->get('button_view');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_date_added'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . '&sort=cri.date_added' . $url, true);		
		$data['sort_review_given'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . '&sort=cri.review' . $url, true);		
		/*29-08-2018*/$data['sort_invite'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . '&sort=cri.invite' . $url, true);
		$data['sort_status'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . '&sort=cri.status' . $url, true);/*29-08-2018*/
		$data['sort_store_id'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . '&sort=cri.store_id' . $url, true);
		$data['sort_order_id'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . '&sort=cri.order_id' . $url, true);
		


		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . urldecode(html_entity_decode($this->request->get['filter_order_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urldecode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urldecode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . urldecode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_review_given'])) {
			$url .= '&filter_review_given=' . urldecode(html_entity_decode($this->request->get['filter_review_given'], ENT_QUOTES, 'UTF-8'));
		}			

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urldecode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $cireviews_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($cireviews_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($cireviews_total - $this->config->get('config_limit_admin'))) ? $cireviews_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $cireviews_total, ceil($cireviews_total / $this->config->get('config_limit_admin')));

		
		$data['filter_order_id'] = $filter_order_id;
		$data['filter_product'] = $filter_product;
		$data['filter_customer'] = $filter_customer;
		$data['filter_store_id'] = $filter_store_id;
		$data['filter_review_given'] = $filter_review_given;
		$data['filter_date_added'] = $filter_date_added;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_invitelog_list.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_invitelog_list', $data));
		}
	}

	protected function getForm() {
		$this->document->addStyle('view/stylesheet/cireviewpro/cireview.css');
		
		if (!isset($this->request->get['cireview_invite_id'])) {
			$this->response->redirect($this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url, true));
		}
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['cireview_invite_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_no_record'] = $this->language->get('text_no_record');
		$data['text_invite_detail'] = $this->language->get('text_invite_detail');
		$data['text_customer_detail'] = $this->language->get('text_customer_detail');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_order_view'] = $this->language->get('text_order_view');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_product_view'] = $this->language->get('text_product_view');
		$data['text_pending'] = $this->language->get('text_pending');
		$data['text_review_view'] = $this->language->get('text_review_view');
		$data['text_review_status'] = $this->language->get('text_review_status');
		/*29-08-2018*/$data['text_action'] = $this->language->get('text_action');
		$data['text_reminder_go'] = $this->language->get('text_reminder_go');
		$data['text_reminder_notgo'] = $this->language->get('text_reminder_notgo');/*29-08-2018*/

		$data['column_reminder_id'] = $this->language->get('column_reminder_id');
		$data['column_date_added'] = $this->language->get('column_date_added');

		
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_store'] = $this->language->get('entry_store');
		/*29-08-2018*/$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_invite'] = $this->language->get('entry_invite');/*29-08-2018*/

		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
	

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . urldecode(html_entity_decode($this->request->get['filter_order_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urldecode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urldecode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . urldecode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_review_given'])) {
			$url .= '&filter_review_given=' . urldecode(html_entity_decode($this->request->get['filter_review_given'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urldecode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->module_token .'=' . $this->ci_token, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url, true)
		);

		$data['ci_token'] = $this->ci_token;
		$data['module_token'] = $this->module_token;

				
		$this->load->model('setting/store');
		$this->load->model('sale/order');
		
		if(VERSION > '2.0.3.1') {
			$this->load->model('customer/customer');
		} else {
			$this->load->model('sale/customer');
		}

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		
		
		$data['action'] = $this->url->link('cireviewpro/cireviewpro_invitelog/edit', $this->module_token .'=' . $this->ci_token . '&cireview_invite_id=' . $this->request->get['cireview_invite_id'] . $url, true);
		$data['cireview_invite_id'] = $this->request->get['cireview_invite_id'];
		


		$data['cancel'] = $this->url->link('cireviewpro/cireviewpro_invitelog', $this->module_token .'=' . $this->ci_token . $url, true);


		$cireview_invite_info = $this->model_cireviewpro_cireviewpro_invitelog->getCiReviewsInvite($this->request->get['cireview_invite_id']);

		$data['invite_reminders'] = array();	
		$data['cireview_invite']	= false;
		$data['status']	= 0;
		$data['invite']	= 0;

		if($cireview_invite_info) {

			$data['cireview_invite'] = true;
			$data['status'] = $cireview_invite_info['status'];
			$data['invite'] = $cireview_invite_info['invite'];

			$order_info = $this->model_sale_order->getOrder($cireview_invite_info['order_id']);

			$data['order_id'] = '#'. $cireview_invite_info['order_id'];
			

			$data['order_href'] = $this->url->link('sale/order/info', $this->module_token .'=' . $this->ci_token . '&order_id=' . $cireview_invite_info['order_id'], true);

			$data['customer'] = '';

			if($cireview_invite_info['customer_id']) {
				$data['customer'] = $this->url->link('customer/customer/edit', $this->module_token .'=' . $this->ci_token . '&customer_id=' . $cireview_invite_info['customer_id'], true);;				
			}

			$data['product'] = '';
			$data['product_url'] = '';
			$data['firstname'] = '';
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['store_url'] = '';
			if($order_info) {
				$data['firstname'] = $order_info['firstname'];
				$data['lastname'] = $order_info['lastname'];
				$data['email'] = $order_info['email'];
				$data['telephone'] = $order_info['telephone'];
				if($order_info['customer_id']) {
					if(VERSION > '2.0.3.1') {
						$customer_info = $this->model_customer_customer->getCustomer($order_info['customer_id']);
					} else {
						$customer_info = $this->model_sale_customer->getCustomer($order_info['customer_id']);
					}

					if($customer_info) {
						$data['firstname'] = $customer_info['firstname'];
						$data['lastname'] = $customer_info['lastname'];
						$data['email'] = $customer_info['email'];
						$data['telephone'] = $customer_info['telephone'];
					}
				}
				$data['store_url'] = $order_info['store_url'];
			}

			$order_products = $this->model_sale_order->getOrderProducts($cireview_invite_info['order_id']);

			foreach ($order_products as $key => $value) {				
				if($value['product_id'] == $cireview_invite_info['product_id']) {
					$data['product'] = $value['name'];
					$data['product_url'] = $this->url->link('catalog/product/edit', $this->module_token .'=' . $this->ci_token . '&product_id=' . $cireview_invite_info['product_id'], true);
					break;
				}
			}


			$data['store_name'] = $this->language->get('text_default');

			if((int)$cireview_invite_info['store_id'] != 0) {
				$store_info = $this->model_setting_store->getStore((int)$cireview_invite_info['store_id']);
				if($store_info) {
					$data['store_name'] = $store_info['name'];
				}
			}

			$data['given_review'] = false;
			$data['review_url'] = '';
			if($cireview_invite_info['review']	!= 0) {
				$data['given_review'] = true;
				$data['review_url'] = $this->url->link('cireviewpro/cireviews/edit', $this->module_token .'=' . $this->ci_token . '&review_id=' . $cireview_invite_info['review_id'], true);
			}		


					
			
			$data['review_id'] = $cireview_invite_info['review_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($cireview_invite_info['date_added']));
			


			$invite_reminders = $this->model_cireviewpro_cireviewpro_invitelog->getCiReviewsInviteReminders($cireview_invite_info['cireview_invite_id']);

			foreach ($invite_reminders as $invite_reminder) {
				$data['invite_reminders'][] = array(
					'cireview_invitereminder_id' => $invite_reminder['cireview_invitereminder_id'],
					'cireview_invite_id' => $invite_reminder['cireview_invite_id'],
					'reminder' => $invite_reminder['reminder'],
					'date_added' => date($this->language->get('date_format_short'), strtotime($invite_reminder['date_added'])),
				);
			}
		}




		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_invitelog_form.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro_invitelog_form', $data));
		}
	}


	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cireviewpro/cireviewpro_invitelog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}

	public function updateInvite() {
		$json = array();
		$this->load->language('cireviewpro/cireviewpro_invitelog');
		$this->load->model('cireviewpro/cireviewpro_invitelog');
		
		if(empty($this->request->get['cireview_invite_id'])) {
			$json['error'] = $this->language->get('error_error');
		}

		if(!isset($this->request->get['value'])) {
			$json['error'] = $this->language->get('error_error');
		}

		if(!$json) {
			$this->model_cireviewpro_cireviewpro_invitelog->updateInviteLog($this->request->get['cireview_invite_id'], 'invite',  $this->request->get['value']);
			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function updateStatus() {
		$json = array();
		$this->load->language('cireviewpro/cireviewpro_invitelog');
		$this->load->model('cireviewpro/cireviewpro_invitelog');
		
		if(empty($this->request->get['cireview_invite_id'])) {
			$json['error'] = $this->language->get('error_error');
		}

		if(!isset($this->request->get['value'])) {
			$json['error'] = $this->language->get('error_error');
		}

		if(!$json) {
			$this->model_cireviewpro_cireviewpro_invitelog->updateInviteLog($this->request->get['cireview_invite_id'], 'status',  $this->request->get['value']);
			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
