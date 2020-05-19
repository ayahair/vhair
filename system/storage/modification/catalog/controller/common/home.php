<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

			if ($this->config->get('hb_snippets_og_enable') == '1'){
				$this->document->setOpengraph('og:title', $this->config->get('config_meta_title'));
				$this->document->setOpengraph('og:type', 'website');
				$this->document->setOpengraph('og:site_name', $this->config->get('config_name'));
				$this->document->setOpengraph('og:image', HTTP_SERVER . 'image/' . $this->config->get('config_logo'));
				$this->document->setOpengraph('og:url', $this->config->get('config_url'));
				$this->document->setOpengraph('og:description', $this->config->get('config_meta_description'));
			}
			

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

			$data['store_name'] = $store_name = $this->config->get('config_name');
			$data['store_url'] = $store_url = HTTPS_SERVER;
			
			$hb_snippets_kg_data = $this->config->get('hb_snippets_kg_data');
			
			if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$logo = $store_url . 'image/' . $this->config->get('config_logo');
			} else {
				$logo = '';
			}
			
			$hb_snippets_kg_data = str_replace('{store_name}',$store_name, $hb_snippets_kg_data);
			$hb_snippets_kg_data = str_replace('{store_logo}',$logo, $hb_snippets_kg_data);
			$hb_snippets_kg_data = str_replace('{store_url}',$store_url, $hb_snippets_kg_data);
			
			$data['hb_snippets_kg_data'] = $hb_snippets_kg_data ;
			$data['hb_snippets_kg_enable'] = $this->config->get('hb_snippets_kg_enable');
				
			$data['hb_snippets_local_enable'] = $this->config->get('hb_snippets_local_enable');
			$data['hb_snippets_local_snippet'] = $this->config->get('hb_snippets_local_snippet');
			

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
