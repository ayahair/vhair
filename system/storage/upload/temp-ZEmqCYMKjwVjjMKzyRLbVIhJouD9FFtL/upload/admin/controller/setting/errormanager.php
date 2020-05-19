<?php
class ControllerSettingErrorManager extends Controller {
	private $error = array();

	public function index() {
		$data['extension_version'] =  '4.3'; 
		$this->language->load('setting/errormanager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/errormanager');
		$this->load->model('setting/setting');
		if ($this->config->get('error_manager_installed') <> 1){
			$this->response->redirect($this->url->link('setting/errormanager/install', 'token=' . $this->session->data['token'], true));
		}
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_404', $this->request->post);	
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}
	
	public function install(){
		$this->load->model('setting/errormanager');
		$this->model_setting_errormanager->install();
		$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
	}
	
	public function uninstall(){
		$this->load->model('setting/errormanager');
		$this->model_setting_errormanager->uninstall();
		$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
	}
	
	public function upgrade(){
		$this->load->model('setting/errormanager');
		$this->model_setting_errormanager->upgrade();
		$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
	}

	public function delete() {
		$this->language->load('setting/errormanager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/errormanager');

		if (isset($this->request->post['selected']) && ($this->validateDelete())) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_setting_errormanager->deleteRecord($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['link'])) {
			$url .= '&link=' . $this->request->get['link'];
			}
			if (isset($this->request->get['author'])) {
				$url .= '&author=' . $this->request->get['author'];
			}
			if (isset($this->request->get['type'])) {
				$url .= '&type=' . $this->request->get['type'];
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

			$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['extension_version'] =  '4.2'; 

		if (isset($this->request->get['link'])) {
			$link = $this->request->get['link'];
		} else {
			$link = 0;
		}
		
		if (isset($this->request->get['author'])) {
			$author = $this->request->get['author'];
		} else {
			$author = 0;
		}
		
		if (isset($this->request->get['type'])) {
			$type = $this->request->get['type'];
		} else {
			$type = 0;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_modified';
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

		if (isset($this->request->get['link'])) {
			$url .= '&link=' . $this->request->get['link'];
		}
		if (isset($this->request->get['author'])) {
			$url .= '&author=' . $this->request->get['author'];
		}
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['action'] = $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'] . $url, true);
		$data['insert'] = $this->url->link('setting/errormanager/insert', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('setting/errormanager/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['view_referrer'] = $this->url->link('setting/errormanager/referrers', 'token=' . $this->session->data['token'] . $url, true);

		$data['errorlinks'] = array();

		$filter_data = array(
			'link'     				 => $link,
			'author'     			 => $author,
			'type'     			 	 => $type,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$error_total = $this->model_setting_errormanager->getTotalRecords($filter_data);

		$results = $this->model_setting_errormanager->getRecords($filter_data);

		foreach ($results as $result) {
			$data['errorlinks'][] = array(
				'id'      		=> $result['id'],
				'error'     	=> urldecode($result['error']),
				'redirect'      => urldecode($result['redirect']),
				'type'          => ($result['type'] == 0)?'404':$result['type'],
				'author'          => $result['author'],
				'hits'          => $result['hits'],
				'redirect_hits'  => $result['redirect_hits'],
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected'])
			);
		}

		$text_strings = array(
				'heading_title','tab_manager','tab_setting','tab_tools',
				'text_no_results','text_confirm','text_missing','text_open_new_tab',
				'column_query_exclude','column_error_exclude','column_ignore_ip','column_ignore_agent','column_smart_url',
				'tool_redirect_update','tool_assign_default','tool_reset', 'tool_type_update',
				'column_default_url','column_page_designer','column_enable_page','column_redirect_type',
				'filter_link','filter_author','filter_type',
				'column_error_url','column_redirect_url','column_hits','column_redirect_hits','column_referrer','column_referrer','column_recent_date',
				'option_all','option_blank_redirect','option_filled_redirect',
				'button_save','button_add','button_delete','button_filter',
				'button_cancel'
				);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}

		$data['token'] = $this->session->data['token'];
		
		$data['hb_404_excludequery'] = $this->config->get('hb_404_excludequery');
		$data['hb_404_excludeterms'] = $this->config->get('hb_404_excludeterms');
		$data['hb_404_ignoreip'] = $this->config->get('hb_404_ignoreip');
		$data['hb_404_ignoreagents'] = $this->config->get('hb_404_ignoreagents');
		
		$data['hb_404_defaulturl'] = $this->config->get('hb_404_defaulturl');
		$data['hb_404_smarturl'] = $this->config->get('hb_404_smarturl');
		$data['hb_404_enablepage'] = $this->config->get('hb_404_enablepage');
		$data['hb_404_type'] = $this->config->get('hb_404_type');
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		foreach ($data['languages'] as $result){
	 		$language_id = $result['language_id'];
			$data['hb_404_page_'.$language_id] =  $this->config->get('hb_404_page_'.$language_id);
		}
		
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
		
		$url = '';

		if (isset($this->request->get['link'])) {
			$url .= '&link=' . $this->request->get['link'];
		}
		if (isset($this->request->get['author'])) {
			$url .= '&author=' . $this->request->get['author'];
		}
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}


		$data['sort_hits'] = $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'] . '&sort=hits' . $url, true);
		$data['sort_date_modified'] = $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'] . '&sort=date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['link'])) {
			$url .= '&link=' . $this->request->get['link'];
		}
		
		if (isset($this->request->get['author'])) {
			$url .= '&author=' . $this->request->get['author'];
		}
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $error_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($error_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($error_total - $this->config->get('config_limit_admin'))) ? $error_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $error_total, ceil($error_total / $this->config->get('config_limit_admin')));

		$data['link'] = $link;
		$data['author'] = $author;
		$data['type'] = $type;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/error_manager', $data));
		
	}


	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/errormanager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateRedirect(){
		$id = $_POST['id'];
		$redirect = $_POST['redirect'];
		$type = $this->config->get('hb_404_type');
		
		$this->language->load('setting/errormanager');
		$this->load->model('setting/errormanager');
		
		if ($this->model_setting_errormanager->checkRedirect($id,$redirect) == true){
    		$this->model_setting_errormanager->updateRecord($id,$redirect,$type);	
			$text = sprintf($this->language->get('text_redirect_updated'),$redirect);
			$json['success'] = '<span style="color:green;"><i class="fa fa-check-circle"></i> '.$text.'</span>';
			$this->response->setOutput(json_encode($json));
		}else {
			$json['success'] = '<span style="color:red;"><i class="fa fa-times-circle"></i> Redirect Link cannot be same as Error URL</span>';
			$this->response->setOutput(json_encode($json));
		}
	}
	
	public function insert() {
		$data['extension_version'] =  '4.2'; 
		$this->language->load('setting/errormanager');

		$this->document->setTitle($this->language->get('heading_title_insert'));

		$this->load->model('setting/errormanager');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$error_urls = $this->request->post['error_url'];
			$redirect_url = $this->request->post['redirect_url'];
			$redirect_code = $this->request->post['redirect_type'];
			$redirect_author = $this->request->post['redirect_author'];
			
			$error_urls = explode(',',$error_urls);
			
			foreach ($error_urls as $error_url){
				$error = trim(html_entity_decode($error_url));
				$redirect = trim($redirect_url);
				
				if (!empty($error) and !empty($redirect)){
					$this->model_setting_errormanager->insertRecord(urlencode($error),$redirect,$redirect_code,$redirect_author);
					$this->session->data['success'] = $this->language->get('text_insert_success');
				}else{
					$this->error['warning'] = $this->language->get('error_warning');
				}
			}
			
			$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_insert'),
			'href' => $this->url->link('setting/errormanager/insert', 'token=' . $this->session->data['token'], true)
		);

		$data['cancel'] = $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true);

		$data['heading_title'] = $this->language->get('heading_title_insert');

		$data['text_error_url'] = $this->language->get('text_error_url');
		$data['text_redirect_url'] = $this->language->get('text_redirect_url');
		$data['text_redirect_type'] = $this->language->get('text_redirect_type');
		$data['text_redirect_author'] = $this->language->get('text_redirect_author');
		$data['text_error_url_help'] = $this->language->get('text_error_url_help');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

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

		$url = '';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/error_manager_insert', $data));
	}

	public function referrers() {
		
		$this->language->load('setting/errormanager');

		$this->load->model('setting/errormanager');

		if (isset($this->request->get['id'])) {
				$id = $this->request->get['id'];
		}
		
		$data['referrers'] = $this->model_setting_errormanager->getReferrers($id);
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];
		$data['column_referrer'] = $this->language->get('column_referrer');
		$data['column_useragent'] = $this->language->get('column_useragent');
		$data['column_datetime'] = $this->language->get('column_datetime');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$this->response->setOutput($this->load->view('setting/error_manager_referrers', $data));
	}
	
	public function tool_resetall() {
		$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "error`");
		$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "error_logs`");
		$this->session->data['success'] = 'TRUNCATED ALL DATA';
		$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
	}
	public function tool_bulkredirectupdate() {
		$old = $_GET['old'];
		$new = $_GET['new'];
		
		if (isset($old) and isset($new)){
			$query = $this->db->query("UPDATE `" . DB_PREFIX . "error` SET `redirect` = '".$this->db->escape($new)."' WHERE `redirect` = '".$old."'");
			$this->session->data['success'] = 'UPDATED SUCCESSFULLY';
		}
		$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
	}
	public function tool_bulktype() {
		$old = $_GET['old'];
		$new = $_GET['new'];
		
		if (isset($old) and isset($new)){
			$query = $this->db->query("UPDATE `" . DB_PREFIX . "error` SET `type` = '".$new."' WHERE `type` = '".$old."'");
			$this->session->data['success'] = 'UPDATED SUCCESSFULLY';
		}
		$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
	}
	public function tool_bulkdefault() {
		$value = $this->config->get('hb_404_defaulturl');
		$type = $this->config->get('hb_404_type');
		$query = $this->db->query("UPDATE `" . DB_PREFIX . "error` SET `redirect` = '".$this->db->escape($value)."', `type` = '".$type."' WHERE `redirect` IS NULL or `redirect` = ''");
		$this->session->data['success'] = 'UPDATED SUCCESSFULLY';
		$this->response->redirect($this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], true));
	}
	
	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'setting/errormanager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>