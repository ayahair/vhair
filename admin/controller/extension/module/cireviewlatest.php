<?php
class ControllerExtensionModuleCiReviewLatest extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/cireviewlatest');
		$this->document->addStyle('view/stylesheet/cireviewpro/cireview.css');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('cireviewlatest', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_width'] = $this->language->get('text_width');
		$data['text_height'] = $this->language->get('text_height');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_productthumb'] = $this->language->get('entry_productthumb');
		$data['entry_titleshow'] = $this->language->get('entry_titleshow');
		$data['entry_dateformat'] = $this->language->get('entry_dateformat');
		$data['entry_ratingshow'] = $this->language->get('entry_ratingshow');
		$data['entry_ratingshowcount'] = $this->language->get('entry_ratingshowcount');
		/*start working 25 july */
		$data['entry_reviewaddon'] = $this->language->get('entry_reviewaddon');
		$data['entry_daysago'] = $this->language->get('entry_daysago');
		$data['entry_dateformat'] = $this->language->get('entry_dateformat');
		/*end working 25 july */
		$data['help_product'] = $this->language->get('help_product');

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
			$data['error_name'] = '';
		}

		if (isset($this->error['productthumb'])) {
			$data['error_productthumb'] = $this->error['productthumb'];
		} else {
			$data['error_productthumb'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/cireviewlatest', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/cireviewlatest', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/cireviewlatest', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/cireviewlatest', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['ratingshow'])) {
			$data['ratingshow'] = $this->request->post['ratingshow'];
		} elseif(isset($module_info['ratingshow'])) {
			$data['ratingshow'] = $module_info['ratingshow'];
		} else {
			$data['ratingshow'] = 1;
		}
		
		if (isset($this->request->post['ratingshowcount'])) {
			$data['ratingshowcount'] = $this->request->post['ratingshowcount'];
		} elseif(isset($module_info['ratingshowcount'])) {
			$data['ratingshowcount'] = $module_info['ratingshowcount'];
		} else {
			$data['ratingshowcount'] = 0;
		}
		
		if (isset($this->request->post['titleshow'])) {
			$data['titleshow'] = $this->request->post['titleshow'];
		} elseif(isset($module_info['titleshow'])) {
			$data['titleshow'] = $module_info['titleshow'];
		} else {
			$data['titleshow'] = 1;
		}
		/*start working 25 july */
		if (isset($this->request->post['reviewaddon'])) {
			$data['reviewaddon'] = $this->request->post['reviewaddon'];
		} elseif(isset($module_info['reviewaddon'])) {
			$data['reviewaddon'] = $module_info['reviewaddon'];
		} else {
			$data['reviewaddon'] = 'DATEFORMAT';
		}
		/*end working 25 july */
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}
		
		if (isset($this->request->post['productthumb_width'])) {
			$data['productthumb_width'] = $this->request->post['productthumb_width'];
		} elseif (isset($module_info['productthumb_width'])) {
			$data['productthumb_width'] = $module_info['productthumb_width'];
		} else {
			$data['productthumb_width'] = 100;
		}

		if (isset($this->request->post['productthumb_height'])) {
			$data['productthumb_height'] = $this->request->post['productthumb_height'];
		} elseif (isset($module_info['productthumb_height'])) {
			$data['productthumb_height'] = $module_info['productthumb_height'];
		} else {
			$data['productthumb_height'] = 100;
		}

		if (isset($this->request->post['dateformat'])) {
			$data['dateformat'] = $this->request->post['dateformat'];
		} elseif (isset($module_info['dateformat'])) {
			$data['dateformat'] = $module_info['dateformat'];
		} else {
			$data['dateformat'] = $this->language->get('date_format_short');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/cireviewlatest', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/cireviewlatest')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['productthumb_width'] || !$this->request->post['productthumb_height']) {
			$this->error['productthumb'] = $this->language->get('error_productthumb');
		}

		return !$this->error;
	}
}
