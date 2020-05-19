<?php
class ControllerCiReviewProCiAbReason extends Controller {
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
		$this->load->language('cireviewpro/ciabreason');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/ciabreason');
		$this->model_cireviewpro_ciabreason->Buildtable();

		$this->getList();
	}

	public function add() {
		$this->load->language('cireviewpro/ciabreason');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/ciabreason');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cireviewpro_ciabreason->addCiAbReason($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('cireviewpro/ciabreason');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/ciabreason');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cireviewpro_ciabreason->editCiAbReason($this->request->get['ciabreason_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cireviewpro/ciabreason');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cireviewpro/ciabreason');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $ciabreason_id) {
				$this->model_cireviewpro_ciabreason->deleteCiAbReason($ciabreason_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pg.date_added';
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->module_token .'=' . $this->ci_token, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url, true)
		);

		$data['add'] = $this->url->link('cireviewpro/ciabreason/add', $this->module_token .'=' . $this->ci_token . $url, true);
		$data['delete'] = $this->url->link('cireviewpro/ciabreason/delete', $this->module_token .'=' . $this->ci_token . $url, true);

		$data['ciabreasons'] = array();

		$filter_data = array(
			'filter_name'  => $filter_name,
			'filter_date_added'  => $filter_date_added,
			'filter_status'  => $filter_status,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$ciabreason_total = $this->model_cireviewpro_ciabreason->getTotalCiAbReasons($filter_data);

		$results = $this->model_cireviewpro_ciabreason->getCiAbReasons($filter_data);


		foreach ($results as $result) {
			$data['ciabreasons'][] = array(
				'ciabreason_id' 	=> $result['ciabreason_id'],
				'name' 	=> $result['name'],
				'sort_order' 	=> $result['sort_order'],
				'status' 	=> $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'        => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'           	=> $this->url->link('cireviewpro/ciabreason/edit', $this->module_token .'=' . $this->ci_token . '&ciabreason_id=' . $result['ciabreason_id'] . $url, true)
			);
		}


		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_details'] = $this->language->get('entry_details');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		
		$data['button_filter'] = $this->language->get('button_filter');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_sort_order'] = $this->language->get('column_sort_order');	
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->load->model('setting/store');
		$data['sort_name'] = $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . '&sort=pd.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . '&sort=p.sort_order' . $url, true);
		$data['sort_date_added'] = $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . '&sort=p.date_added' . $url, true);
		$data['sort_status'] = $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . '&sort=p.status' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}


		$pagination = new Pagination();
		$pagination->total = $ciabreason_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($ciabreason_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ciabreason_total - $this->config->get('config_limit_admin'))) ? $ciabreason_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ciabreason_total, ceil($ciabreason_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		$data['ci_token'] = $this->ci_token;
		$data['module_token'] = $this->module_token;


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/ciabreason_list.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/ciabreason_list', $data));
		}
	}

	public function getForm() {
		$this->document->addStyle('view/stylesheet/cireviewpro/cireview.css');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['ciabreason_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_default'] = $this->language->get('text_default');
		$data['text_language'] = $this->language->get('text_language');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');


		$data['entry_name'] = $this->language->get('entry_name');
		
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_details'] = $this->language->get('entry_details');
		
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_settings'] = $this->language->get('tab_settings');

		$data['help_product'] = $this->language->get('help_product');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href' => $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url, true)
		);

		if (!isset($this->request->get['ciabreason_id'])) {
			$data['action'] = $this->url->link('cireviewpro/ciabreason/add', $this->module_token .'=' . $this->ci_token . $url, true);
		} else {
			$data['action'] = $this->url->link('cireviewpro/ciabreason/edit', $this->module_token .'=' . $this->ci_token . '&ciabreason_id=' . $this->request->get['ciabreason_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('cireviewpro/ciabreason', $this->module_token .'=' . $this->ci_token . $url, true);

		if (isset($this->request->get['ciabreason_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$ciabreason_info = $this->model_cireviewpro_ciabreason->getCiAbReason($this->request->get['ciabreason_id']);
		}

		$data['ci_token'] = $this->ci_token;
		$data['module_token'] = $this->module_token;

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['ciabreason_description'])) {
			$data['ciabreason_description'] = $this->request->post['ciabreason_description'];
		} elseif (isset($this->request->get['ciabreason_id'])) {
			$data['ciabreason_description'] = $this->model_cireviewpro_ciabreason->getCiAbReasonDescriptions($this->request->get['ciabreason_id']);
		} else {
			$data['ciabreason_description'] = array();
		}

		
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['ciabreason_store'])) {
			$data['ciabreason_store'] = $this->request->post['ciabreason_store'];
		} elseif (isset($this->request->get['ciabreason_id'])) {
			$data['ciabreason_store'] = $this->model_cireviewpro_ciabreason->getCiAbReasonStores($this->request->get['ciabreason_id']);
		} else {
			$data['ciabreason_store'] = array(0);
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($ciabreason_info)) {
			$data['status'] = $ciabreason_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['details'])) {
			$data['details'] = $this->request->post['details'];
		} elseif (!empty($ciabreason_info)) {
			$data['details'] = $ciabreason_info['details'];
		} else {
			$data['details'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($ciabreason_info)) {
			$data['sort_order'] = $ciabreason_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['ciabreason_category'])) {
			$ciabreason_categories = $this->request->post['ciabreason_category'];
		} elseif (isset($this->request->get['ciabreason_id'])) {
			$ciabreason_categories = $this->model_cireviewpro_ciabreason->getCiAbReasonCategories($this->request->get['ciabreason_id']);
		} else {
			$ciabreason_categories = array();
		}

		$data['ciabreason_categories'] = array();
		$this->load->model('catalog/category');
		foreach ($ciabreason_categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['ciabreason_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		if (isset($this->request->post['ciabreason_product'])) {
			$ciabreason_products = $this->request->post['ciabreason_product'];
		} elseif (isset($this->request->get['ciabreason_id'])) {
			$ciabreason_products = $this->model_cireviewpro_ciabreason->getCiAbReasonProducts($this->request->get['ciabreason_id']);
		} else {
			$ciabreason_products = array();
		}

		$data['ciabreason_products'] = array();
		$this->load->model('catalog/product');
		foreach ($ciabreason_products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['ciabreason_products'][] = array(
					'product_id' 	=> $product_info['product_id'],
					'name'        	=> $product_info['name'],
				);
			}
		}

		if (isset($this->request->post['ciabreason_manufacturer'])) {
			$ciabreason_manufacturers = $this->request->post['ciabreason_manufacturer'];
		} elseif (isset($this->request->get['ciabreason_id'])) {
			$ciabreason_manufacturers = $this->model_cireviewpro_ciabreason->getCiAbReasonManufacturers($this->request->get['ciabreason_id']);
		} else {
			$ciabreason_manufacturers = array();
		}

		$data['ciabreason_manufacturers'] = array();
		$this->load->model('catalog/manufacturer');
		foreach ($ciabreason_manufacturers as $manufacturer_id) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

			if ($manufacturer_info) {
				$data['ciabreason_manufacturers'][] = array(
					'manufacturer_id' 	=> $manufacturer_info['manufacturer_id'],
					'name'        		=> $manufacturer_info['name'],
				);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/ciabreason_form.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/ciabreason_form', $data));
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cireviewpro/ciabreason')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cireviewpro/ciabreason')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['ciabreason_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;

	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('cireviewpro/ciabreason');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_cireviewpro_ciabreason->getCiAbReasons($filter_data);

			foreach ($results as $result) {


				$json[] = array(
					'ciabreason_id' => $result['ciabreason_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),					
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}