<?php
class ControllerExtensionHbSeopack extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$this->load->language('extension/hb_seopack');

		$this->document->setTitle($this->language->get('heading_title'));
	
		$data['heading_title'] = $this->language->get('heading_title');

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/hb_seopack', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_seopack', 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
		$data['link_seobulk'] = $this->url->link('extension/hb_seo_bulk', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_sitemap'] = $this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_seoimage'] = $this->url->link('extension/hb_seoimage', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_seosnippets'] = $this->url->link('extension/hb_snippets', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['link_tags'] = $this->url->link('extension/hb_tags', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_errormanager'] = $this->url->link('setting/errormanager', 'token=' . $this->session->data['token'], 'SSL');
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_seopack.tpl', $data));

	}
		
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_seopack')) {
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