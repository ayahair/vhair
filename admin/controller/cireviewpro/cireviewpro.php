<?php
class ControllerCiReviewProCiReviewPro extends Controller {
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
	
	public function doReviewSync() {
		$json = array();
		$this->load->language('cireviewpro/cireviewpro');
		if(isset($this->request->post['sync']) && $this->request->post['sync']=='1' ) {
			$this->load->model('cireviewpro/ciratingtype');

			$this->model_cireviewpro_ciratingtype->reviewSync();

			$json['success'] = $this->language->get('text_sucesssync');
		} else {
			$json['error'] = $this->language->get('error_request_invalid');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function index() {
		$this->document->addStyle('view/stylesheet/cireviewpro/cireview.css');

		$this->load->language('cireviewpro/cireviewpro');
		$this->document->setTitle($this->language->get('heading_title'));

		
		$this->document->addStyle('view/javascript/cireviewpro/colorpicker/css/bootstrap-colorpicker.css');
		$this->document->addScript('view/javascript/cireviewpro/colorpicker/js/bootstrap-colorpicker.js');
 		
		
		$this->load->model('cireviewpro/ciratingtype');
		$this->model_cireviewpro_ciratingtype->Buildtable();

		$data['requiresync'] = $this->model_cireviewpro_ciratingtype->requireSync();


		

		$store_id = 0;
		if(isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		}

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			
			if(VERSION <= '2.3.0.2') {
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'cireviewpro/cireviews'");

				if (!empty($this->request->post['cireviewpro_reviewlistpage_keyword'])) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'cireviewpro/cireviews', keyword = '" . $this->db->escape($this->request->post['cireviewpro_reviewlistpage_keyword']) . "'");
				}
			} else {
				$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'cireviewpro/cireviews'");
				if ($this->request->post['cireviewpro_reviewlistpage_keyword']) {
					foreach ($this->request->post['cireviewpro_reviewlistpage_keyword'] as $storeid => $language) {
						foreach ($language as $language_id => $keyword) {
							if (!empty($keyword)) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$storeid . "', language_id = '" . (int)$language_id . "', query = 'cireviewpro/cireviews', keyword = '" . $this->db->escape($keyword) . "'");
							}
						}
					}
				}
			}

			$this->model_setting_setting->editSetting('cireviewpro', $this->request->post, $store_id);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cireviewpro/cireviewpro', $this->module_token .'=' . $this->ci_token, true));
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_keyword'] = $this->language->get('text_keyword');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_width'] = $this->language->get('text_width');
		$data['text_height'] = $this->language->get('text_height');
		$data['text_percent_find_usefull'] = $this->language->get('text_percent_find_usefull');
		$data['text_outof_find_usefull'] = $this->language->get('text_outof_find_usefull');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_grid'] = $this->language->get('text_grid');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['text_onlylogged'] = $this->language->get('text_onlylogged');
		$data['text_onlyboth'] = $this->language->get('text_onlyboth');


		$data['text_reviewsetting'] = $this->language->get('text_reviewsetting');
		$data['text_reviewform'] = $this->language->get('text_reviewform');
		$data['text_reviewimage'] = $this->language->get('text_reviewimage');
		$data['text_reviewrating'] = $this->language->get('text_reviewrating');
		$data['text_reviewvote'] = $this->language->get('text_reviewvote');
		$data['text_reviewabuse'] = $this->language->get('text_reviewabuse');
		$data['text_reviewpage'] = $this->language->get('text_reviewpage');
		$data['text_reviewfilter'] = $this->language->get('text_reviewfilter');
		$data['text_ratingstars'] = $this->language->get('text_ratingstars');
		$data['text_alterratingstars'] = str_replace('[LINK]', $this->url->link('cireviewpro/ciratingtype',$this->module_token .'='. $this->ci_token, true), $this->language->get('text_alterratingstars')) ;
		$data['text_progressbar'] = $this->language->get('text_progressbar');

		$data['text_requiresync'] = $this->language->get('text_requiresync');
		$data['text_reviewcoupon'] = $this->language->get('text_reviewcoupon');
		
		$data['text_reviewreward'] = $this->language->get('text_reviewreward');
		$data['text_reviewsuccess'] = $this->language->get('text_reviewsuccess');
		$data['text_successdefault'] = $this->language->get('text_successdefault');
		$data['text_successpopup'] = $this->language->get('text_successpopup');
		
		$data['text_promoproduct'] = $this->language->get('text_promoproduct');
		$data['text_promocategory'] = $this->language->get('text_promocategory');
		$data['text_promomanufacturer'] = $this->language->get('text_promomanufacturer');

		$data['text_align_left'] = $this->language->get('text_align_left');
		$data['text_align_center'] = $this->language->get('text_align_center');
		$data['text_align_right'] = $this->language->get('text_align_right');

		$data['text_sort_default'] = $this->language->get('text_sort_default');
		$data['text_sort_rating_desc'] = $this->language->get('text_sort_rating_desc');
		$data['text_sort_rating_asc'] = $this->language->get('text_sort_rating_asc');
		$data['text_sort_dateadd_desc'] = $this->language->get('text_sort_dateadd_desc');
		$data['text_sort_dateadd_asc'] = $this->language->get('text_sort_dateadd_asc');
		
		$data['text_none'] = $this->language->get('text_none');
		

		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_reviewreply'] = $this->language->get('entry_reviewreply');
		
		$data['entry_reviewreplyauthor'] = $this->language->get('entry_reviewreplyauthor');
		
		$data['entry_reviewaddon'] = $this->language->get('entry_reviewaddon');
		$data['entry_daysago'] = $this->language->get('entry_daysago');
		$data['entry_dateformat'] = $this->language->get('entry_dateformat');
		
		$data['entry_reviewdateformat'] = $this->language->get('entry_reviewdateformat');
		$data['entry_reviewpagedateformat'] = $this->language->get('entry_reviewpagedateformat');
		$data['entry_reviewview'] = $this->language->get('entry_reviewview');
		$data['entry_reviewperrow'] = $this->language->get('entry_reviewperrow');
		$data['entry_reviewimages'] = $this->language->get('entry_reviewimages');
		$data['entry_reviewimagespath'] = $this->language->get('entry_reviewimagespath');
		$data['entry_reviewfilters'] = $this->language->get('entry_reviewfilters');
		$data['entry_is_multilanguage'] = $this->language->get('entry_is_multilanguage');
		$data['entry_reviewimp'] = $this->language->get('entry_reviewimp');
		$data['entry_is_multistore'] = $this->language->get('entry_is_multistore');
		$data['entry_reviewimageslimit'] = $this->language->get('entry_reviewimageslimit');
		$data['entry_reviewimagesthumb'] = $this->language->get('entry_reviewimagesthumb');
		$data['entry_reviewimagespopup'] = $this->language->get('entry_reviewimagespopup');
		$data['entry_reviewpageimagesthumb'] = $this->language->get('entry_reviewpageimagesthumb');
		$data['entry_reviewpageimagespopup'] = $this->language->get('entry_reviewpageimagespopup');
		
		$data['entry_reviewpageproductthumb'] = $this->language->get('entry_reviewpageproductthumb');
			

		$data['entry_file_ext_allowed'] = $this->language->get('entry_file_ext_allowed');
		$data['entry_file_mime_allowed'] = $this->language->get('entry_file_mime_allowed');

		$data['entry_reviewabuse'] = $this->language->get('entry_reviewabuse');
		$data['entry_reviewabuseguest'] = $this->language->get('entry_reviewabuseguest');
		$data['entry_reviewshare'] = $this->language->get('entry_reviewshare');
		$data['entry_reviewviewsource'] = $this->language->get('entry_reviewviewsource');
		$data['entry_richsnippets'] = $this->language->get('entry_richsnippets');
		
		$data['entry_sharetype'] = $this->language->get('entry_sharetype');
		$data['entry_shareaddthis'] = $this->language->get('entry_shareaddthis');
		$data['entry_sharesharethis'] = $this->language->get('entry_sharesharethis');
		$data['entry_reviewgraph'] = $this->language->get('entry_reviewgraph');
		$data['entry_reviewgraph_color'] = $this->language->get('entry_reviewgraph_color');
		$data['entry_reviewgraph_option'] = $this->language->get('entry_reviewgraph_option');
		$data['entry_reviewsearch'] = $this->language->get('entry_reviewsearch');
		
		$data['entry_reviewtitle'] = $this->language->get('entry_reviewtitle');
		$data['entry_reviewtitle_require'] = $this->language->get('entry_reviewtitle_require');
		$data['entry_reviewauthor'] = $this->language->get('entry_reviewauthor');
		$data['entry_reviewauthor_require'] = $this->language->get('entry_reviewauthor_require');
		$data['entry_reviewemail'] = $this->language->get('entry_reviewemail');
		$data['entry_reviewtext'] = $this->language->get('entry_reviewtext');
		$data['entry_reviewtext_require'] = $this->language->get('entry_reviewtext_require');
		$data['entry_reviewlimit'] = $this->language->get('entry_reviewlimit');
		
		$data['entry_reviewterm'] = $this->language->get('entry_reviewterm');
		$data['entry_reviewfields'] = $this->language->get('entry_reviewfields');
		
		$data['entry_reviewpagelimit'] = $this->language->get('entry_reviewpagelimit');
		$data['entry_reviewsortshow'] = $this->language->get('entry_reviewsortshow');
		$data['entry_reviewpagetitleshow'] = $this->language->get('entry_reviewpagetitleshow');
		$data['entry_reviewsortdefault'] = $this->language->get('entry_reviewsortdefault');
		$data['entry_reviewpromoshow'] = $this->language->get('entry_reviewpromoshow');
		$data['entry_reviewpromoalign'] = $this->language->get('entry_reviewpromoalign');
		$data['entry_reviewpromoproductnameshow'] = $this->language->get('entry_reviewpromoproductnameshow');
		$data['entry_reviewpromoproductpriceshow'] = $this->language->get('entry_reviewpromoproductpriceshow');
		$data['entry_reviewpromoproductratingshow'] = $this->language->get('entry_reviewpromoproductratingshow');
		$data['entry_reviewpromocategorynameshow'] = $this->language->get('entry_reviewpromocategorynameshow');
		$data['entry_reviewpromomanufacturernameshow'] = $this->language->get('entry_reviewpromomanufacturernameshow');
		$data['entry_reviewpromoproduct'] = $this->language->get('entry_reviewpromoproduct');
		$data['entry_reviewpromocategory'] = $this->language->get('entry_reviewpromocategory');
		$data['entry_reviewpromomanufacturer'] = $this->language->get('entry_reviewpromomanufacturer');
		$data['entry_reviewpromotextproduct'] = $this->language->get('entry_reviewpromotextproduct');
		$data['entry_reviewpromotextcategory'] = $this->language->get('entry_reviewpromotextcategory');
		$data['entry_reviewpromotextmanufacturer'] = $this->language->get('entry_reviewpromotextmanufacturer');
		$data['entry_reviewgetvote'] = $this->language->get('entry_reviewgetvote');
		$data['entry_reviewvoteguest'] = $this->language->get('entry_reviewvoteguest');
		$data['entry_reviewvotetype'] = $this->language->get('entry_reviewvotetype');
		$data['entry_reviewvotebefore'] = $this->language->get('entry_reviewvotebefore');
		$data['entry_reviewvoteyes'] = $this->language->get('entry_reviewvoteyes');
		$data['entry_reviewvoteno'] = $this->language->get('entry_reviewvoteno');
		$data['entry_reviewvoteoutof'] = $this->language->get('entry_reviewvoteoutof');
		$data['entry_reviewvotepercent'] = $this->language->get('entry_reviewvotepercent');
		$data['entry_reviewapprove'] = $this->language->get('entry_reviewapprove');


		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_customcss'] = $this->language->get('entry_customcss');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');

		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['entry_customertitle'] = $this->language->get('entry_customertitle');
		$data['entry_customermessage'] = $this->language->get('entry_customermessage');
		$data['entry_admintitle'] = $this->language->get('entry_admintitle');
		$data['entry_adminmessage'] = $this->language->get('entry_adminmessage');
		$data['entry_customersend'] = $this->language->get('entry_customersend');
		$data['entry_adminsend'] = $this->language->get('entry_adminsend');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_ratingstars'] = $this->language->get('entry_ratingstars');
		$data['entry_reviewratingcount'] = $this->language->get('entry_reviewratingcount');
		$data['entry_reviewrating'] = $this->language->get('entry_reviewrating');
		$data['entry_reviewguest'] = $this->language->get('entry_reviewguest');
		$data['entry_reviewpurchaseonly'] = $this->language->get('entry_reviewpurchaseonly');
		$data['entry_verifypurchase_orderstatus'] = $this->language->get('entry_verifypurchase_orderstatus');
		$data['entry_rewardsuccessalert'] = $this->language->get('entry_rewardsuccessalert');
		$data['entry_rewardsuccessmsg'] = $this->language->get('entry_rewardsuccessmsg');
		$data['entry_rewardsuccessmsg_pending'] = $this->language->get('entry_rewardsuccessmsg_pending');
		$data['entry_rewardsuccessmsg_title'] = $this->language->get('entry_rewardsuccessmsg_title');
		$data['entry_rewardsuccessmsg_couponcode'] = $this->language->get('entry_rewardsuccessmsg_couponcode');
		$data['entry_rewardsuccessmsg_rewardpoints'] = $this->language->get('entry_rewardsuccessmsg_rewardpoints');
		$data['entry_reviewcoupon'] = $this->language->get('entry_reviewcoupon');
		
		$data['entry_adminmail'] = $this->language->get('entry_adminmail');
		$data['entry_mailproductimagethumb'] = $this->language->get('entry_mailproductimagethumb');
		$data['entry_maillogoimagethumb'] = $this->language->get('entry_maillogoimagethumb');
		$data['entry_reviewreward'] = $this->language->get('entry_reviewreward');
		$data['entry_reviewrewardpurchaseonly'] = $this->language->get('entry_reviewrewardpurchaseonly');
		$data['entry_rewardpoints'] = $this->language->get('entry_rewardpoints');
		$data['entry_rewarddesc'] = $this->language->get('entry_rewarddesc');
		
		$data['entry_reviewcouponguest'] = $this->language->get('entry_reviewcouponguest');
		$data['entry_reviewcouponpurchaseonly'] = $this->language->get('entry_reviewcouponpurchaseonly');
		$data['entry_reviewpolicy'] = $this->language->get('entry_reviewpolicy');
		$data['entry_reviewmax'] = $this->language->get('entry_reviewmax');
		$data['entry_reviewadmindir'] = $this->language->get('entry_reviewadmindir');


		
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		
		$data['entry_reviewcoupontype'] = $this->language->get('entry_reviewcoupontype');
		$data['entry_reviewcoupondiscount'] = $this->language->get('entry_reviewcoupondiscount');
		$data['entry_reviewcouponlogged'] = $this->language->get('entry_reviewcouponlogged');
		$data['entry_reviewcouponshipping'] = $this->language->get('entry_reviewcouponshipping');
		$data['entry_reviewcoupontotal'] = $this->language->get('entry_reviewcoupontotal');
		$data['entry_reviewcouponcategory'] = $this->language->get('entry_reviewcouponcategory');
		$data['entry_reviewcouponproduct'] = $this->language->get('entry_reviewcouponproduct');
		$data['entry_reviewcoupondays'] = $this->language->get('entry_reviewcoupondays');
		$data['entry_reviewcouponuses_total'] = $this->language->get('entry_reviewcouponuses_total');
		$data['entry_reviewcouponuses_customer'] = $this->language->get('entry_reviewcouponuses_customer');


		$data['legend_promo'] = $this->language->get('legend_promo');
		
		$data['legend_reviewshare'] = $this->language->get('legend_reviewshare');
		$data['legend_reviewproduct'] = $this->language->get('legend_reviewproduct');
		$data['legend_reviewpage'] = $this->language->get('legend_reviewpage');
		
		
		$data['const_names'] = $this->language->get('const_names');
		$data['const_coupon_code'] = $this->language->get('const_coupon_code');
		
		$data['const_reward_points'] = $this->language->get('const_reward_points');
		
		$data['const_short_codes'] = $this->language->get('const_short_codes');
		$data['const_logo'] = $this->language->get('const_logo');
		$data['const_store_name'] = $this->language->get('const_store_name');
		$data['const_store_link'] = $this->language->get('const_store_link');
		$data['const_review_author'] = $this->language->get('const_review_author');
		$data['const_review_email'] = $this->language->get('const_review_email');
		$data['const_review_title'] = $this->language->get('const_review_title');
		$data['const_review_text'] = $this->language->get('const_review_text');
		$data['const_review_rating'] = $this->language->get('const_review_rating');
		$data['const_review_ratings'] = $this->language->get('const_review_ratings');
		$data['const_review_attachment'] = $this->language->get('const_review_attachment');
		$data['const_review_link'] = $this->language->get('const_review_link');
		$data['const_product_name'] = $this->language->get('const_product_name');
		$data['const_product_image'] = $this->language->get('const_product_image');
		$data['const_product_description'] = $this->language->get('const_product_description');
		$data['const_product_link'] = $this->language->get('const_product_link');
		$data['const_promo_product'] = $this->language->get('const_promo_product');
		$data['const_promo_category'] = $this->language->get('const_promo_category');
		$data['const_promo_manufacturer'] = $this->language->get('const_promo_manufacturer');

		$data['help_customcss'] = $this->language->get('help_customcss');
		$data['help_keyword'] = $this->language->get('help_keyword');

		
		$data['help_product'] = $this->language->get('help_product');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');

		$data['help_file_ext_allowed'] = $this->language->get('help_file_ext_allowed');
		$data['help_file_mime_allowed'] = $this->language->get('help_file_mime_allowed');


		$data['help_reviewvotebefore'] = $this->language->get('help_reviewvotebefore');
		$data['help_reviewvoteyes'] = $this->language->get('help_reviewvoteyes');
		$data['help_reviewvoteno'] = $this->language->get('help_reviewvoteno');
		$data['help_reviewvoteoutof'] = $this->language->get('help_reviewvoteoutof');
		$data['help_reviewvotepercent'] = $this->language->get('help_reviewvotepercent');
		
		$data['help_reviewreply'] = $this->language->get('help_reviewreply');
		$data['help_reviewauthor'] = $this->language->get('help_reviewauthor');
		$data['help_reviewemail'] = $this->language->get('help_reviewemail');
		$data['help_reviewtext'] = $this->language->get('help_reviewtext');

		$data['help_reviewcoupontype'] = $this->language->get('help_reviewcoupontype');
		$data['help_reviewcoupontotal'] = $this->language->get('help_reviewcoupontotal');
		$data['help_reviewcouponlogged'] = $this->language->get('help_reviewcouponlogged');
		$data['help_reviewcouponcategory'] = $this->language->get('help_reviewcouponcategory');
		$data['help_reviewcouponproduct'] = $this->language->get('help_reviewcouponproduct');
		$data['help_reviewcouponuses_total'] = $this->language->get('help_reviewcouponuses_total');
		$data['help_reviewcouponuses_customer'] = $this->language->get('help_reviewcouponuses_customer');
		$data['help_reviewcoupondays'] = $this->language->get('help_reviewcoupondays');
		$data['help_reviewimagespath'] = $this->language->get('help_reviewimagespath');
		$data['help_reviewadmindir'] = $this->language->get('help_reviewadmindir');
		$data['help_reviewmax'] = $this->language->get('help_reviewmax');
		$data['help_reviewpurchaseonly'] = $this->language->get('help_reviewpurchaseonly');
		$data['help_reviewcouponpurchaseonly'] = $this->language->get('help_reviewcouponpurchaseonly');
		$data['help_reviewrewardpurchaseonly'] = $this->language->get('help_reviewrewardpurchaseonly');
		$data['help_verifypurchase_orderstatus'] = $this->language->get('help_verifypurchase_orderstatus');
		$data['help_rewardsuccessmsg_title'] = $this->language->get('help_rewardsuccessmsg_title');
		$data['help_rewardsuccessmsg_couponcode'] = $this->language->get('help_rewardsuccessmsg_couponcode');
		$data['help_rewardsuccessmsg_rewardpoints'] = $this->language->get('help_rewardsuccessmsg_rewardpoints');
		$data['help_richsnippets'] = $this->language->get('help_richsnippets');
		$data['help_richsnippets_verify'] = $this->language->get('help_richsnippets_verify');
		
		$data['help_reviewterm'] = $this->language->get('help_reviewterm');
		

		
		$data['placeholder_reviewvotebefore'] = $this->language->get('placeholder_reviewvotebefore');
		$data['placeholder_reviewvoteyes'] = $this->language->get('placeholder_reviewvoteyes');
		$data['placeholder_reviewvoteno'] = $this->language->get('placeholder_reviewvoteno');
		$data['placeholder_reviewvoteoutof'] = $this->language->get('placeholder_reviewvoteoutof');
		$data['placeholder_reviewvotepercent'] = $this->language->get('placeholder_reviewvotepercent');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_reviewsync'] = $this->language->get('button_reviewsync');

		
		$data['tab_pageinfo'] = $this->language->get('tab_pageinfo');
		$data['tab_review_list'] = $this->language->get('tab_review_list');
		$data['tab_review_policy'] = $this->language->get('tab_review_policy');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_email'] = $this->language->get('tab_email');
		$data['tab_promotion'] = $this->language->get('tab_promotion');
		$data['tab_mail_promotion'] = $this->language->get('tab_mail_promotion');
		$data['tab_css'] = $this->language->get('tab_css');
		$data['tab_support'] = $this->language->get('tab_support');
		$data['tab_customeremail'] = $this->language->get('tab_customeremail');
		$data['tab_adminemail'] = $this->language->get('tab_adminemail');

		$data['tab_field'] = $this->language->get('tab_field');
		
		$data['legend_product'] = $this->language->get('legend_product');
		$data['legend_category'] = $this->language->get('legend_category');
		$data['legend_manufacturer'] = $this->language->get('legend_manufacturer');
		$data['legend_rewardsuccessmsg'] = $this->language->get('legend_rewardsuccessmsg');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		
		if (isset($this->error['cireviewpro_reviewlistpage'])) {
			$data['error_cireviewpro_reviewlistpage'] = $this->error['cireviewpro_reviewlistpage'];
		} else {
			$data['error_cireviewpro_reviewlistpage'] = array();
		}
		
		if (isset($this->error['cireviewpro_reviewpolicypage'])) {
			$data['error_cireviewpro_reviewpolicypage'] = $this->error['cireviewpro_reviewpolicypage'];
		} else {
			$data['error_cireviewpro_reviewpolicypage'] = array();
		}
		if (isset($this->error['reviewsuccessmsg'])) {
			$data['error_reviewsuccessmsg'] = $this->error['reviewsuccessmsg'];
		} else {
			$data['error_reviewsuccessmsg'] = array();
		}
		
		if (isset($this->error['cireviewpro_reviewvote'])) {
			$data['error_cireviewpro_reviewvote'] = $this->error['cireviewpro_reviewvote'];
		} else {
			$data['error_cireviewpro_reviewvote'] = array();
		}

		if (isset($this->error['customertitle'])) {
			$data['error_customertitle'] = $this->error['customertitle'];
		} else {
			$data['error_customertitle'] = array();
		}

		if (isset($this->error['customermessage'])) {
			$data['error_customermessage'] = $this->error['customermessage'];
		} else {
			$data['error_customermessage'] = array();
		}

		if (isset($this->error['admintitle'])) {
			$data['error_admintitle'] = $this->error['admintitle'];
		} else {
			$data['error_admintitle'] = array();
		}

		if (isset($this->error['adminmessage'])) {
			$data['error_adminmessage'] = $this->error['adminmessage'];
		} else {
			$data['error_adminmessage'] = array();
		}
		
		if (isset($this->error['verifypurchase_orderstatus'])) {
			$data['error_verifypurchase_orderstatus'] = $this->error['verifypurchase_orderstatus'];
		} else {
			$data['error_verifypurchase_orderstatus'] = '';
		}
		
		if (isset($this->error['cireviewpro_reviewlistpage_keyword'])) {
			$data['error_cireviewpro_reviewlistpage_keyword'] = $this->error['cireviewpro_reviewlistpage_keyword'];
		} else {
			$data['error_cireviewpro_reviewlistpage_keyword'] = '';
		}
		
		if (isset($this->error['cireviewpro_rewardpoints'])) {
			$data['error_cireviewpro_rewardpoints'] = $this->error['cireviewpro_rewardpoints'];
		} else {
			$data['error_cireviewpro_rewardpoints'] = '';
		}
		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->module_token .'=' . $this->ci_token, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cireviewpro/cireviewpro', $this->module_token .'=' . $this->ci_token, true)
		);

		if(isset($store_id)) {
			$data['action'] = $this->url->link('cireviewpro/cireviewpro', $this->module_token .'=' . $this->ci_token . '&store_id='. $store_id, true);
		} else{
			$data['action'] = $this->url->link('cireviewpro/cireviewpro', $this->module_token .'=' . $this->ci_token, true);
		}

		$data['config_language_id'] = $this->config->get('config_language_id');

		// get all languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		// get all stores
		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();

		$data['all_stores'] = array();
		
		$data['all_stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);

		$stores = $this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$data['all_stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		
		// get all informations
		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();
		
		// get all order statuses
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$module_info = $this->model_setting_setting->getSetting('cireviewpro', $store_id);
		$data['store_id'] = $store_id;

		
		if (isset($this->request->post['cireviewpro_reviewlistpage'])) {
			$data['cireviewpro_reviewlistpage'] = $this->request->post['cireviewpro_reviewlistpage'];
		} elseif(isset($module_info['cireviewpro_reviewlistpage'])) {
			$data['cireviewpro_reviewlistpage'] = $module_info['cireviewpro_reviewlistpage'];
		} else {
			$data['cireviewpro_reviewlistpage'] = array();
		}

		if (isset($this->request->post['cireviewpro_reviewreply'])) {
			$data['cireviewpro_reviewreply'] = $this->request->post['cireviewpro_reviewreply'];
		} elseif(isset($module_info['cireviewpro_reviewreply'])) {
			$data['cireviewpro_reviewreply'] = $module_info['cireviewpro_reviewreply'];
		} else {
			$data['cireviewpro_reviewreply'] = '';
		}
		
		if (isset($this->request->post['cireviewpro_reviewaddon'])) {
			$data['cireviewpro_reviewaddon'] = $this->request->post['cireviewpro_reviewaddon'];
		} elseif(isset($module_info['cireviewpro_reviewaddon'])) {
			$data['cireviewpro_reviewaddon'] = $module_info['cireviewpro_reviewaddon'];
		} else {
			$data['cireviewpro_reviewaddon'] = 'DATEFORMAT';
		}
		if (isset($this->request->post['cireviewpro_reviewpageaddon'])) {
			$data['cireviewpro_reviewpageaddon'] = $this->request->post['cireviewpro_reviewpageaddon'];
		} elseif(isset($module_info['cireviewpro_reviewpageaddon'])) {
			$data['cireviewpro_reviewpageaddon'] = $module_info['cireviewpro_reviewpageaddon'];
		} else {
			$data['cireviewpro_reviewpageaddon'] = 'DATEFORMAT';
		}
		
		if (isset($this->request->post['cireviewpro_reviewreplyauthor'])) {
			$data['cireviewpro_reviewreplyauthor'] = $this->request->post['cireviewpro_reviewreplyauthor'];
		} elseif(isset($module_info['cireviewpro_reviewreplyauthor'])) {
			$data['cireviewpro_reviewreplyauthor'] = $module_info['cireviewpro_reviewreplyauthor'];
		} else {
			$data['cireviewpro_reviewreplyauthor'] = $this->config->get('config_name');
		}

		if (isset($this->request->post['cireviewpro_reviewdateformat'])) {
			$data['cireviewpro_reviewdateformat'] = $this->request->post['cireviewpro_reviewdateformat'];
		} elseif(isset($module_info['cireviewpro_reviewdateformat'])) {
			$data['cireviewpro_reviewdateformat'] = $module_info['cireviewpro_reviewdateformat'];
		} else {
			$data['cireviewpro_reviewdateformat'] = $this->language->get('date_format_short');
		}

		if (isset($this->request->post['cireviewpro_reviewpagedateformat'])) {
			$data['cireviewpro_reviewpagedateformat'] = $this->request->post['cireviewpro_reviewpagedateformat'];
		} elseif(isset($module_info['cireviewpro_reviewpagedateformat'])) {
			$data['cireviewpro_reviewpagedateformat'] = $module_info['cireviewpro_reviewpagedateformat'];
		} else {
			$data['cireviewpro_reviewpagedateformat'] = $this->language->get('date_format_short');
		}

		if (isset($this->request->post['cireviewpro_reviewview'])) {
			$data['cireviewpro_reviewview'] = $this->request->post['cireviewpro_reviewview'];
		} elseif(isset($module_info['cireviewpro_reviewview'])) {
			$data['cireviewpro_reviewview'] = $module_info['cireviewpro_reviewview'];
		} else {
			$data['cireviewpro_reviewview'] = 'LIST';
		}
		
		if (isset($this->request->post['cireviewpro_reviewperrow'])) {
			$data['cireviewpro_reviewperrow'] = $this->request->post['cireviewpro_reviewperrow'];
		} elseif(isset($module_info['cireviewpro_reviewperrow'])) {
			$data['cireviewpro_reviewperrow'] = $module_info['cireviewpro_reviewperrow'];
		} else {
			$data['cireviewpro_reviewperrow'] = 4;
		}

		if (isset($this->request->post['cireviewpro_reviewimages'])) {
			$data['cireviewpro_reviewimages'] = $this->request->post['cireviewpro_reviewimages'];
		} elseif(isset($module_info['cireviewpro_reviewimages'])) {
			$data['cireviewpro_reviewimages'] = $module_info['cireviewpro_reviewimages'];
		} else {
			$data['cireviewpro_reviewimages'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewimageslimit'])) {
			$data['cireviewpro_reviewimageslimit'] = $this->request->post['cireviewpro_reviewimageslimit'];
		} elseif(isset($module_info['cireviewpro_reviewimageslimit'])) {
			$data['cireviewpro_reviewimageslimit'] = $module_info['cireviewpro_reviewimageslimit'];
		} else {
			$data['cireviewpro_reviewimageslimit'] = 1;
		}
		
		if (isset($this->request->post['cireviewpro_reviewimagespath'])) {
			$data['cireviewpro_reviewimagespath'] = $this->request->post['cireviewpro_reviewimagespath'];
		} elseif(isset($module_info['cireviewpro_reviewimagespath'])) {
			$data['cireviewpro_reviewimagespath'] = $module_info['cireviewpro_reviewimagespath'];
		} else {
			$data['cireviewpro_reviewimagespath'] = 'catalog/cireviewpro_images';
		}
		if (isset($this->request->post['cireviewpro_is_multistore'])) {
			$data['cireviewpro_is_multistore'] = $this->request->post['cireviewpro_is_multistore'];
		} elseif(isset($module_info['cireviewpro_is_multistore'])) {
			$data['cireviewpro_is_multistore'] = $module_info['cireviewpro_is_multistore'];
		} else {
			$data['cireviewpro_is_multistore'] = 1;
		}
		if (isset($this->request->post['cireviewpro_is_multilanguage'])) {
			$data['cireviewpro_is_multilanguage'] = $this->request->post['cireviewpro_is_multilanguage'];
		} elseif(isset($module_info['cireviewpro_is_multilanguage'])) {
			$data['cireviewpro_is_multilanguage'] = $module_info['cireviewpro_is_multilanguage'];
		} else {
			$data['cireviewpro_is_multilanguage'] = 1;
		}
		if (isset($this->request->post['cireviewpro_reviewimp'])) {
			$data['cireviewpro_reviewimp'] = $this->request->post['cireviewpro_reviewimp'];
		} elseif(isset($module_info['cireviewpro_reviewimp'])) {
			$data['cireviewpro_reviewimp'] = $module_info['cireviewpro_reviewimp'];
		} else {
			$data['cireviewpro_reviewimp'] = 1;
		}
		
		if (isset($this->request->post['cireviewpro_reviewimagesthumb_width'])) {
			$data['cireviewpro_reviewimagesthumb_width'] = $this->request->post['cireviewpro_reviewimagesthumb_width'];
		} elseif(isset($module_info['cireviewpro_reviewimagesthumb_width'])) {
			$data['cireviewpro_reviewimagesthumb_width'] = $module_info['cireviewpro_reviewimagesthumb_width'];
		} else {
			$data['cireviewpro_reviewimagesthumb_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewimagesthumb_height'])) {
			$data['cireviewpro_reviewimagesthumb_height'] = $this->request->post['cireviewpro_reviewimagesthumb_height'];
		} elseif(isset($module_info['cireviewpro_reviewimagesthumb_height'])) {
			$data['cireviewpro_reviewimagesthumb_height'] = $module_info['cireviewpro_reviewimagesthumb_height'];
		} else {
			$data['cireviewpro_reviewimagesthumb_height'] = 100;
		}
		
		if (isset($this->request->post['cireviewpro_reviewimagespopup_width'])) {
			$data['cireviewpro_reviewimagespopup_width'] = $this->request->post['cireviewpro_reviewimagespopup_width'];
		} elseif(isset($module_info['cireviewpro_reviewimagespopup_width'])) {
			$data['cireviewpro_reviewimagespopup_width'] = $module_info['cireviewpro_reviewimagespopup_width'];
		} else {
			$data['cireviewpro_reviewimagespopup_width'] = 500;
		}

		if (isset($this->request->post['cireviewpro_reviewimagespopup_height'])) {
			$data['cireviewpro_reviewimagespopup_height'] = $this->request->post['cireviewpro_reviewimagespopup_height'];
		} elseif(isset($module_info['cireviewpro_reviewimagespopup_height'])) {
			$data['cireviewpro_reviewimagespopup_height'] = $module_info['cireviewpro_reviewimagespopup_height'];
		} else {
			$data['cireviewpro_reviewimagespopup_height'] = 500;
		}

		if (isset($this->request->post['cireviewpro_reviewpageimagesthumb_width'])) {
			$data['cireviewpro_reviewpageimagesthumb_width'] = $this->request->post['cireviewpro_reviewpageimagesthumb_width'];
		} elseif(isset($module_info['cireviewpro_reviewpageimagesthumb_width'])) {
			$data['cireviewpro_reviewpageimagesthumb_width'] = $module_info['cireviewpro_reviewpageimagesthumb_width'];
		} else {
			$data['cireviewpro_reviewpageimagesthumb_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpageimagesthumb_height'])) {
			$data['cireviewpro_reviewpageimagesthumb_height'] = $this->request->post['cireviewpro_reviewpageimagesthumb_height'];
		} elseif(isset($module_info['cireviewpro_reviewpageimagesthumb_height'])) {
			$data['cireviewpro_reviewpageimagesthumb_height'] = $module_info['cireviewpro_reviewpageimagesthumb_height'];
		} else {
			$data['cireviewpro_reviewpageimagesthumb_height'] = 100;
		}
		
		if (isset($this->request->post['cireviewpro_reviewpageimagespopup_width'])) {
			$data['cireviewpro_reviewpageimagespopup_width'] = $this->request->post['cireviewpro_reviewpageimagespopup_width'];
		} elseif(isset($module_info['cireviewpro_reviewpageimagespopup_width'])) {
			$data['cireviewpro_reviewpageimagespopup_width'] = $module_info['cireviewpro_reviewpageimagespopup_width'];
		} else {
			$data['cireviewpro_reviewpageimagespopup_width'] = 500;
		}

		if (isset($this->request->post['cireviewpro_reviewpageimagespopup_height'])) {
			$data['cireviewpro_reviewpageimagespopup_height'] = $this->request->post['cireviewpro_reviewpageimagespopup_height'];
		} elseif(isset($module_info['cireviewpro_reviewpageimagespopup_height'])) {
			$data['cireviewpro_reviewpageimagespopup_height'] = $module_info['cireviewpro_reviewpageimagespopup_height'];
		} else {
			$data['cireviewpro_reviewpageimagespopup_height'] = 500;
		}

		
		if (isset($this->request->post['cireviewpro_reviewpageproductthumb_width'])) {
			$data['cireviewpro_reviewpageproductthumb_width'] = $this->request->post['cireviewpro_reviewpageproductthumb_width'];
		} elseif(isset($module_info['cireviewpro_reviewpageproductthumb_width'])) {
			$data['cireviewpro_reviewpageproductthumb_width'] = $module_info['cireviewpro_reviewpageproductthumb_width'];
		} else {
			$data['cireviewpro_reviewpageproductthumb_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpageproductthumb_height'])) {
			$data['cireviewpro_reviewpageproductthumb_height'] = $this->request->post['cireviewpro_reviewpageproductthumb_height'];
		} elseif(isset($module_info['cireviewpro_reviewpageproductthumb_height'])) {
			$data['cireviewpro_reviewpageproductthumb_height'] = $module_info['cireviewpro_reviewpageproductthumb_height'];
		} else {
			$data['cireviewpro_reviewpageproductthumb_height'] = 100;
		}
		

		if (isset($this->request->post['cireviewpro_file_ext_allowed'])) {
			$data['cireviewpro_file_ext_allowed'] = $this->request->post['cireviewpro_file_ext_allowed'];
		} elseif(isset($module_info['cireviewpro_file_ext_allowed'])) {
			$data['cireviewpro_file_ext_allowed'] = $module_info['cireviewpro_file_ext_allowed'];
		} else {
			$data['cireviewpro_file_ext_allowed'] = "png\njpe\njpeg\njpg\ngif\nbmp";
		}

		if (isset($this->request->post['cireviewpro_file_mime_allowed'])) {
			$data['cireviewpro_file_mime_allowed'] = $this->request->post['cireviewpro_file_mime_allowed'];
		} elseif(isset($module_info['cireviewpro_file_mime_allowed'])) {
			$data['cireviewpro_file_mime_allowed'] = $module_info['cireviewpro_file_mime_allowed'];
		} else {
			$data['cireviewpro_file_mime_allowed'] = "image/png\nimage/jpeg\nimage/gif\nimage/bmp";
		}

		if (isset($this->request->post['cireviewpro_reviewabuse'])) {
			$data['cireviewpro_reviewabuse'] = $this->request->post['cireviewpro_reviewabuse'];
		} elseif(isset($module_info['cireviewpro_reviewabuse'])) {
			$data['cireviewpro_reviewabuse'] = $module_info['cireviewpro_reviewabuse'];
		} else {
			$data['cireviewpro_reviewabuse'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewabuseguest'])) {
			$data['cireviewpro_reviewabuseguest'] = $this->request->post['cireviewpro_reviewabuseguest'];
		} elseif(isset($module_info['cireviewpro_reviewabuseguest'])) {
			$data['cireviewpro_reviewabuseguest'] = $module_info['cireviewpro_reviewabuseguest'];
		} else {
			$data['cireviewpro_reviewabuseguest'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewviewsource'])) {
			$data['cireviewpro_reviewviewsource'] = $this->request->post['cireviewpro_reviewviewsource'];
		} elseif(isset($module_info['cireviewpro_reviewviewsource'])) {
			$data['cireviewpro_reviewviewsource'] = $module_info['cireviewpro_reviewviewsource'];
		} else {
			$data['cireviewpro_reviewviewsource'] = 0;
		}

		if (isset($this->request->post['cireviewpro_richsnippets'])) {
			$data['cireviewpro_richsnippets'] = $this->request->post['cireviewpro_richsnippets'];
		} elseif(isset($module_info['cireviewpro_richsnippets'])) {
			$data['cireviewpro_richsnippets'] = $module_info['cireviewpro_richsnippets'];
		} else {
			$data['cireviewpro_richsnippets'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_reviewfilters'])) {
			$data['cireviewpro_reviewfilters'] = $this->request->post['cireviewpro_reviewfilters'];
		} elseif(isset($module_info['cireviewpro_reviewfilters'])) {
			$data['cireviewpro_reviewfilters'] = $module_info['cireviewpro_reviewfilters'];
		} else {
			$data['cireviewpro_reviewfilters'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_reviewshare'])) {
			$data['cireviewpro_reviewshare'] = $this->request->post['cireviewpro_reviewshare'];
		} elseif(isset($module_info['cireviewpro_reviewshare'])) {
			$data['cireviewpro_reviewshare'] = $module_info['cireviewpro_reviewshare'];
		} else {
			$data['cireviewpro_reviewshare'] = 1;
		}

		
		if (isset($this->request->post['cireviewpro_reviewgraph'])) {
			$data['cireviewpro_reviewgraph'] = $this->request->post['cireviewpro_reviewgraph'];
		} elseif(isset($module_info['cireviewpro_reviewgraph'])) {
			$data['cireviewpro_reviewgraph'] = $module_info['cireviewpro_reviewgraph'];
		} else {
			$data['cireviewpro_reviewgraph'] = 1;
		}
		
		if (isset($this->request->post['cireviewpro_reviewgraph_option'])) {
			$data['cireviewpro_reviewgraph_option'] = $this->request->post['cireviewpro_reviewgraph_option'];
		} elseif(isset($module_info['cireviewpro_reviewgraph_option'])) {
			$data['cireviewpro_reviewgraph_option'] = $module_info['cireviewpro_reviewgraph_option'];
		} else {
			$data['cireviewpro_reviewgraph_option'] = 'PROGRESSBAR';
		}
		
		if (isset($this->request->post['cireviewpro_reviewgraph_color'])) {
			$data['cireviewpro_reviewgraph_color'] = $this->request->post['cireviewpro_reviewgraph_color'];
		} elseif(isset($module_info['cireviewpro_reviewgraph_color'])) {
			$data['cireviewpro_reviewgraph_color'] = $module_info['cireviewpro_reviewgraph_color'];
		} else {
			$data['cireviewpro_reviewgraph_color'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewsearch'])) {
			$data['cireviewpro_reviewsearch'] = $this->request->post['cireviewpro_reviewsearch'];
		} elseif(isset($module_info['cireviewpro_reviewsearch'])) {
			$data['cireviewpro_reviewsearch'] = $module_info['cireviewpro_reviewsearch'];
		} else {
			$data['cireviewpro_reviewsearch'] = 1;
		}

		if (isset($this->request->post['cireviewpro_sharetype'])) {
			$data['cireviewpro_sharetype'] = $this->request->post['cireviewpro_sharetype'];
		} elseif(isset($module_info['cireviewpro_sharetype'])) {
			$data['cireviewpro_sharetype'] = $module_info['cireviewpro_sharetype'];
		} else {
			$data['cireviewpro_sharetype'] = 'ADDTHIS';
		}
		

		if (isset($this->request->post['cireviewpro_reviewauthor'])) {
			$data['cireviewpro_reviewauthor'] = $this->request->post['cireviewpro_reviewauthor'];
		} elseif(isset($module_info['cireviewpro_reviewauthor'])) {
			$data['cireviewpro_reviewauthor'] = $module_info['cireviewpro_reviewauthor'];
		} else {
			$data['cireviewpro_reviewauthor'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewauthor_require'])) {
			$data['cireviewpro_reviewauthor_require'] = $this->request->post['cireviewpro_reviewauthor_require'];
		} elseif(isset($module_info['cireviewpro_reviewauthor_require'])) {
			$data['cireviewpro_reviewauthor_require'] = $module_info['cireviewpro_reviewauthor_require'];
		} else {
			$data['cireviewpro_reviewauthor_require'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewtitle'])) {
			$data['cireviewpro_reviewtitle'] = $this->request->post['cireviewpro_reviewtitle'];
		} elseif(isset($module_info['cireviewpro_reviewtitle'])) {
			$data['cireviewpro_reviewtitle'] = $module_info['cireviewpro_reviewtitle'];
		} else {
			$data['cireviewpro_reviewtitle'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewtitle_require'])) {
			$data['cireviewpro_reviewtitle_require'] = $this->request->post['cireviewpro_reviewtitle_require'];
		} elseif(isset($module_info['cireviewpro_reviewtitle_require'])) {
			$data['cireviewpro_reviewtitle_require'] = $module_info['cireviewpro_reviewtitle_require'];
		} else {
			$data['cireviewpro_reviewtitle_require'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewemail'])) {
			$data['cireviewpro_reviewemail'] = $this->request->post['cireviewpro_reviewemail'];
		} elseif(isset($module_info['cireviewpro_reviewemail'])) {
			$data['cireviewpro_reviewemail'] = $module_info['cireviewpro_reviewemail'];
		} else {
			$data['cireviewpro_reviewemail'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewtext'])) {
			$data['cireviewpro_reviewtext'] = $this->request->post['cireviewpro_reviewtext'];
		} elseif(isset($module_info['cireviewpro_reviewtext'])) {
			$data['cireviewpro_reviewtext'] = $module_info['cireviewpro_reviewtext'];
		} else {
			$data['cireviewpro_reviewtext'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewtext_require'])) {
			$data['cireviewpro_reviewtext_require'] = $this->request->post['cireviewpro_reviewtext_require'];
		} elseif(isset($module_info['cireviewpro_reviewtext_require'])) {
			$data['cireviewpro_reviewtext_require'] = $module_info['cireviewpro_reviewtext_require'];
		} else {
			$data['cireviewpro_reviewtext_require'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewlimit'])) {
			$data['cireviewpro_reviewlimit'] = $this->request->post['cireviewpro_reviewlimit'];
		} elseif(isset($module_info['cireviewpro_reviewlimit'])) {
			$data['cireviewpro_reviewlimit'] = $module_info['cireviewpro_reviewlimit'];
		} else {
			$data['cireviewpro_reviewlimit'] = 10;
		}
		
		if (isset($this->request->post['cireviewpro_reviewterm_id'])) {
			$data['cireviewpro_reviewterm_id'] = $this->request->post['cireviewpro_reviewterm_id'];
		} elseif(isset($module_info['cireviewpro_reviewterm_id'])) {
			$data['cireviewpro_reviewterm_id'] = $module_info['cireviewpro_reviewterm_id'];
		} else {
			$data['cireviewpro_reviewterm_id'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_reviewpagelimit'])) {
			$data['cireviewpro_reviewpagelimit'] = $this->request->post['cireviewpro_reviewpagelimit'];
		} elseif(isset($module_info['cireviewpro_reviewpagelimit'])) {
			$data['cireviewpro_reviewpagelimit'] = $module_info['cireviewpro_reviewpagelimit'];
		} else {
			$data['cireviewpro_reviewpagelimit'] = 10;
		}

		if (isset($this->request->post['cireviewpro_reviewpagetitleshow'])) {
			$data['cireviewpro_reviewpagetitleshow'] = $this->request->post['cireviewpro_reviewpagetitleshow'];
		} elseif(isset($module_info['cireviewpro_reviewpagetitleshow'])) {
			$data['cireviewpro_reviewpagetitleshow'] = $module_info['cireviewpro_reviewpagetitleshow'];
		} else {
			$data['cireviewpro_reviewpagetitleshow'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewsortshow'])) {
			$data['cireviewpro_reviewsortshow'] = $this->request->post['cireviewpro_reviewsortshow'];
		} elseif(isset($module_info['cireviewpro_reviewsortshow'])) {
			$data['cireviewpro_reviewsortshow'] = $module_info['cireviewpro_reviewsortshow'];
		} else {
			$data['cireviewpro_reviewsortshow'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewsortdefault'])) {
			$data['cireviewpro_reviewsortdefault'] = $this->request->post['cireviewpro_reviewsortdefault'];
		} elseif(isset($module_info['cireviewpro_reviewsortdefault'])) {
			$data['cireviewpro_reviewsortdefault'] = $module_info['cireviewpro_reviewsortdefault'];
		} else {
			$data['cireviewpro_reviewsortdefault'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromoshow'])) {
			$data['cireviewpro_reviewpromoshow'] = $this->request->post['cireviewpro_reviewpromoshow'];
		} elseif(isset($module_info['cireviewpro_reviewpromoshow'])) {
			$data['cireviewpro_reviewpromoshow'] = $module_info['cireviewpro_reviewpromoshow'];
		} else {
			$data['cireviewpro_reviewpromoshow'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromoalign'])) {
			$data['cireviewpro_reviewpromoalign'] = $this->request->post['cireviewpro_reviewpromoalign'];
		} elseif(isset($module_info['cireviewpro_reviewpromoalign'])) {
			$data['cireviewpro_reviewpromoalign'] = $module_info['cireviewpro_reviewpromoalign'];
		} else {
			$data['cireviewpro_reviewpromoalign'] = 'LEFT';
		}

		if (isset($this->request->post['cireviewpro_reviewpromoproductnameshow'])) {
			$data['cireviewpro_reviewpromoproductnameshow'] = $this->request->post['cireviewpro_reviewpromoproductnameshow'];
		} elseif(isset($module_info['cireviewpro_reviewpromoproductnameshow'])) {
			$data['cireviewpro_reviewpromoproductnameshow'] = $module_info['cireviewpro_reviewpromoproductnameshow'];
		} else {
			$data['cireviewpro_reviewpromoproductnameshow'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromoproductpriceshow'])) {
			$data['cireviewpro_reviewpromoproductpriceshow'] = $this->request->post['cireviewpro_reviewpromoproductpriceshow'];
		} elseif(isset($module_info['cireviewpro_reviewpromoproductpriceshow'])) {
			$data['cireviewpro_reviewpromoproductpriceshow'] = $module_info['cireviewpro_reviewpromoproductpriceshow'];
		} else {
			$data['cireviewpro_reviewpromoproductpriceshow'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromoproductratingshow'])) {
			$data['cireviewpro_reviewpromoproductratingshow'] = $this->request->post['cireviewpro_reviewpromoproductratingshow'];
		} elseif(isset($module_info['cireviewpro_reviewpromoproductratingshow'])) {
			$data['cireviewpro_reviewpromoproductratingshow'] = $module_info['cireviewpro_reviewpromoproductratingshow'];
		} else {
			$data['cireviewpro_reviewpromoproductratingshow'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromocategorynameshow'])) {
			$data['cireviewpro_reviewpromocategorynameshow'] = $this->request->post['cireviewpro_reviewpromocategorynameshow'];
		} elseif(isset($module_info['cireviewpro_reviewpromocategorynameshow'])) {
			$data['cireviewpro_reviewpromocategorynameshow'] = $module_info['cireviewpro_reviewpromocategorynameshow'];
		} else {
			$data['cireviewpro_reviewpromocategorynameshow'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromomanufacturernameshow'])) {
			$data['cireviewpro_reviewpromomanufacturernameshow'] = $this->request->post['cireviewpro_reviewpromomanufacturernameshow'];
		} elseif(isset($module_info['cireviewpro_reviewpromomanufacturernameshow'])) {
			$data['cireviewpro_reviewpromomanufacturernameshow'] = $module_info['cireviewpro_reviewpromomanufacturernameshow'];
		} else {
			$data['cireviewpro_reviewpromomanufacturernameshow'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewpromo'])) {
			$data['cireviewpro_reviewpromo'] = $this->request->post['cireviewpro_reviewpromo'];
		} elseif(isset($module_info['cireviewpro_reviewpromo'])) {
			$data['cireviewpro_reviewpromo'] = (array)$module_info['cireviewpro_reviewpromo'];
		} else {
			$data['cireviewpro_reviewpromo'] = array();
		}

		if (isset($this->request->post['cireviewpro_reviewpromoproduct_width'])) {
			$data['cireviewpro_reviewpromoproduct_width'] = $this->request->post['cireviewpro_reviewpromoproduct_width'];
		} elseif(isset($module_info['cireviewpro_reviewpromoproduct_width'])) {
			$data['cireviewpro_reviewpromoproduct_width'] = $module_info['cireviewpro_reviewpromoproduct_width'];
		} else {
			$data['cireviewpro_reviewpromoproduct_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpromoproduct_height'])) {
			$data['cireviewpro_reviewpromoproduct_height'] = $this->request->post['cireviewpro_reviewpromoproduct_height'];
		} elseif(isset($module_info['cireviewpro_reviewpromoproduct_height'])) {
			$data['cireviewpro_reviewpromoproduct_height'] = $module_info['cireviewpro_reviewpromoproduct_height'];
		} else {
			$data['cireviewpro_reviewpromoproduct_height'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpromocategory_width'])) {
			$data['cireviewpro_reviewpromocategory_width'] = $this->request->post['cireviewpro_reviewpromocategory_width'];
		} elseif(isset($module_info['cireviewpro_reviewpromocategory_width'])) {
			$data['cireviewpro_reviewpromocategory_width'] = $module_info['cireviewpro_reviewpromocategory_width'];
		} else {
			$data['cireviewpro_reviewpromocategory_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpromocategory_height'])) {
			$data['cireviewpro_reviewpromocategory_height'] = $this->request->post['cireviewpro_reviewpromocategory_height'];
		} elseif(isset($module_info['cireviewpro_reviewpromocategory_height'])) {
			$data['cireviewpro_reviewpromocategory_height'] = $module_info['cireviewpro_reviewpromocategory_height'];
		} else {
			$data['cireviewpro_reviewpromocategory_height'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpromomanufacturer_width'])) {
			$data['cireviewpro_reviewpromomanufacturer_width'] = $this->request->post['cireviewpro_reviewpromomanufacturer_width'];
		} elseif(isset($module_info['cireviewpro_reviewpromomanufacturer_width'])) {
			$data['cireviewpro_reviewpromomanufacturer_width'] = $module_info['cireviewpro_reviewpromomanufacturer_width'];
		} else {
			$data['cireviewpro_reviewpromomanufacturer_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewpromomanufacturer_height'])) {
			$data['cireviewpro_reviewpromomanufacturer_height'] = $this->request->post['cireviewpro_reviewpromomanufacturer_height'];
		} elseif(isset($module_info['cireviewpro_reviewpromomanufacturer_height'])) {
			$data['cireviewpro_reviewpromomanufacturer_height'] = $module_info['cireviewpro_reviewpromomanufacturer_height'];
		} else {
			$data['cireviewpro_reviewpromomanufacturer_height'] = 100;
		}

		if (isset($this->request->post['cireviewpro_reviewgetvote'])) {
			$data['cireviewpro_reviewgetvote'] = $this->request->post['cireviewpro_reviewgetvote'];
		} elseif(isset($module_info['cireviewpro_reviewgetvote'])) {
			$data['cireviewpro_reviewgetvote'] = (array)$module_info['cireviewpro_reviewgetvote'];
		} else {
			$data['cireviewpro_reviewgetvote'] = array();
		}

		if (isset($this->request->post['cireviewpro_reviewvote'])) {
			$data['cireviewpro_reviewvote'] = $this->request->post['cireviewpro_reviewvote'];
		} elseif(isset($module_info['cireviewpro_reviewvote'])) {
			$data['cireviewpro_reviewvote'] = (array)$module_info['cireviewpro_reviewvote'];
		} else {
			$data['cireviewpro_reviewvote'] = array();
		}

		if (isset($this->request->post['cireviewpro_reviewtvote'])) {
			$data['cireviewpro_reviewtvote'] = $this->request->post['cireviewpro_reviewtvote'];
		} elseif(isset($module_info['cireviewpro_reviewtvote'])) {
			$data['cireviewpro_reviewtvote'] = (array) $module_info['cireviewpro_reviewtvote'];
		} else {
			$data['cireviewpro_reviewtvote'] = array();
		}

		if (isset($this->request->post['cireviewpro_reviewvoteguest'])) {
			$data['cireviewpro_reviewvoteguest'] = $this->request->post['cireviewpro_reviewvoteguest'];
		} elseif(isset($module_info['cireviewpro_reviewvoteguest'])) {
			$data['cireviewpro_reviewvoteguest'] = $module_info['cireviewpro_reviewvoteguest'];
		} else {
			$data['cireviewpro_reviewvoteguest'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewvotetype'])) {
			$data['cireviewpro_reviewvotetype'] = $this->request->post['cireviewpro_reviewvotetype'];
		} elseif(isset($module_info['cireviewpro_reviewvotetype'])) {
			$data['cireviewpro_reviewvotetype'] = $module_info['cireviewpro_reviewvotetype'];
		} else {
			$data['cireviewpro_reviewvotetype'] = 'PERCENT';
		}

		if (isset($this->request->post['cireviewpro_reviewapprove'])) {
			$data['cireviewpro_reviewapprove'] = $this->request->post['cireviewpro_reviewapprove'];
		} elseif(isset($module_info['cireviewpro_reviewapprove'])) {
			$data['cireviewpro_reviewapprove'] = $module_info['cireviewpro_reviewapprove'];
		} else {
			$data['cireviewpro_reviewapprove'] = 'NO';
		}

		if (isset($this->request->post['cireviewpro_ratingstars'])) {
			$data['cireviewpro_ratingstars'] = $this->request->post['cireviewpro_ratingstars'];
		} elseif(isset($module_info['cireviewpro_ratingstars'])) {
			$data['cireviewpro_ratingstars'] = $module_info['cireviewpro_ratingstars'];
		} else {
			$data['cireviewpro_ratingstars'] = 5;
		}

		if (isset($this->request->post['cireviewpro_rating'])) {
			$data['cireviewpro_rating'] = $this->request->post['cireviewpro_rating'];
		} elseif(isset($module_info['cireviewpro_rating'])) {
			$data['cireviewpro_rating'] = $module_info['cireviewpro_rating'];
		} else {
			$data['cireviewpro_rating'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewrating'])) {
			$data['cireviewpro_reviewrating'] = $this->request->post['cireviewpro_reviewrating'];
		} elseif(isset($module_info['cireviewpro_reviewrating'])) {
			$data['cireviewpro_reviewrating'] = $module_info['cireviewpro_reviewrating'];
		} else {
			$data['cireviewpro_reviewrating'] = 1;
		}
		
		if (isset($this->request->post['cireviewpro_reviewratingcount'])) {
			$data['cireviewpro_reviewratingcount'] = $this->request->post['cireviewpro_reviewratingcount'];
		} elseif(isset($module_info['cireviewpro_reviewratingcount'])) {
			$data['cireviewpro_reviewratingcount'] = $module_info['cireviewpro_reviewratingcount'];
		} else {
			$data['cireviewpro_reviewratingcount'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_reviewguest'])) {
			$data['cireviewpro_reviewguest'] = $this->request->post['cireviewpro_reviewguest'];
		} elseif(isset($module_info['cireviewpro_reviewguest'])) {
			$data['cireviewpro_reviewguest'] = $module_info['cireviewpro_reviewguest'];
		} else {
			$data['cireviewpro_reviewguest'] = 1;
		}
		
		if (isset($this->request->post['cireviewpro_reviewpurchaseonly'])) {
			$data['cireviewpro_reviewpurchaseonly'] = $this->request->post['cireviewpro_reviewpurchaseonly'];
		} elseif(isset($module_info['cireviewpro_reviewpurchaseonly'])) {
			$data['cireviewpro_reviewpurchaseonly'] = $module_info['cireviewpro_reviewpurchaseonly'];
		} else {
			$data['cireviewpro_reviewpurchaseonly'] = 0;
		}
		if (isset($this->request->post['cireviewpro_verifypurchase_orderstatus'])) {
			$data['cireviewpro_verifypurchase_orderstatus'] = $this->request->post['cireviewpro_verifypurchase_orderstatus'];
		} elseif(isset($module_info['cireviewpro_verifypurchase_orderstatus'])) {
			$data['cireviewpro_verifypurchase_orderstatus'] = $module_info['cireviewpro_verifypurchase_orderstatus'];
		} else {
			$data['cireviewpro_verifypurchase_orderstatus'] = $this->config->get('config_complete_status');
		}
		
		if (isset($this->request->post['cireviewpro_reviewcoupon'])) {
			$data['cireviewpro_reviewcoupon'] = $this->request->post['cireviewpro_reviewcoupon'];
		} elseif(isset($module_info['cireviewpro_reviewcoupon'])) {
			$data['cireviewpro_reviewcoupon'] = $module_info['cireviewpro_reviewcoupon'];
		} else {
			$data['cireviewpro_reviewcoupon'] = 0;
		}
		
		
		if (isset($this->request->post['cireviewpro_reviewreward'])) {
			$data['cireviewpro_reviewreward'] = $this->request->post['cireviewpro_reviewreward'];
		} elseif(isset($module_info['cireviewpro_reviewreward'])) {
			$data['cireviewpro_reviewreward'] = $module_info['cireviewpro_reviewreward'];
		} else {
			$data['cireviewpro_reviewreward'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_reviewrewardpurchaseonly'])) {
			$data['cireviewpro_reviewrewardpurchaseonly'] = $this->request->post['cireviewpro_reviewrewardpurchaseonly'];
		} elseif(isset($module_info['cireviewpro_reviewrewardpurchaseonly'])) {
			$data['cireviewpro_reviewrewardpurchaseonly'] = $module_info['cireviewpro_reviewrewardpurchaseonly'];
		} else {
			$data['cireviewpro_reviewrewardpurchaseonly'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_rewardpoints'])) {
			$data['cireviewpro_rewardpoints'] = $this->request->post['cireviewpro_rewardpoints'];
		} elseif(isset($module_info['cireviewpro_rewardpoints'])) {
			$data['cireviewpro_rewardpoints'] = $module_info['cireviewpro_rewardpoints'];
		} else {
			$data['cireviewpro_rewardpoints'] = 0;
		}
		if (isset($this->request->post['cireviewpro_rewarddesc'])) {
			$data['cireviewpro_rewarddesc'] = $this->request->post['cireviewpro_rewarddesc'];
		} elseif(isset($module_info['cireviewpro_rewarddesc'])) {
			$data['cireviewpro_rewarddesc'] = $module_info['cireviewpro_rewarddesc'];
		} else {
			$data['cireviewpro_rewarddesc'] = '';
		}
		

		if (isset($this->request->post['cireviewpro_reviewcouponguest'])) {
			$data['cireviewpro_reviewcouponguest'] = $this->request->post['cireviewpro_reviewcouponguest'];
		} elseif(isset($module_info['cireviewpro_reviewcouponguest'])) {
			$data['cireviewpro_reviewcouponguest'] = $module_info['cireviewpro_reviewcouponguest'];
		} else {
			$data['cireviewpro_reviewcouponguest'] = 0;
		}
		
		if (isset($this->request->post['cireviewpro_reviewcouponpurchaseonly'])) {
			$data['cireviewpro_reviewcouponpurchaseonly'] = $this->request->post['cireviewpro_reviewcouponpurchaseonly'];
		} elseif(isset($module_info['cireviewpro_reviewcouponpurchaseonly'])) {
			$data['cireviewpro_reviewcouponpurchaseonly'] = $module_info['cireviewpro_reviewcouponpurchaseonly'];
		} else {
			$data['cireviewpro_reviewcouponpurchaseonly'] = 0;
		}
		if (isset($this->request->post['cireviewpro_reviewpolicy'])) {
			$data['cireviewpro_reviewpolicy'] = $this->request->post['cireviewpro_reviewpolicy'];
		} elseif(isset($module_info['cireviewpro_reviewpolicy'])) {
			$data['cireviewpro_reviewpolicy'] = $module_info['cireviewpro_reviewpolicy'];
		} else {
			$data['cireviewpro_reviewpolicy'] = 0;
		}
		if (isset($this->request->post['cireviewpro_reviewpolicypage'])) {
	      $data['cireviewpro_reviewpolicypage'] = $this->request->post['cireviewpro_reviewpolicypage'];
	    } elseif(isset($module_info['cireviewpro_reviewpolicypage'])) {
	      $data['cireviewpro_reviewpolicypage'] = $module_info['cireviewpro_reviewpolicypage'];
	    } else {
	      $data['cireviewpro_reviewpolicypage'] = array();
	    }
		if (isset($this->request->post['cireviewpro_rewardsuccessalert'])) {
			$data['cireviewpro_rewardsuccessalert'] = $this->request->post['cireviewpro_rewardsuccessalert'];
		} elseif(isset($module_info['cireviewpro_rewardsuccessalert'])) {
			$data['cireviewpro_rewardsuccessalert'] = $module_info['cireviewpro_rewardsuccessalert'];
		} else {
			$data['cireviewpro_rewardsuccessalert'] = 'DEFAULT';
		}
		if (isset($this->request->post['cireviewpro_reviewsuccessmsg'])) {
	      $data['cireviewpro_reviewsuccessmsg'] = $this->request->post['cireviewpro_reviewsuccessmsg'];
	    } elseif(isset($module_info['cireviewpro_reviewsuccessmsg'])) {
	      $data['cireviewpro_reviewsuccessmsg'] = $module_info['cireviewpro_reviewsuccessmsg'];
	    } else {
	      $data['cireviewpro_reviewsuccessmsg'] = array();
	    }
		
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
			if(!isset($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['title']) || empty($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['title'])) {
				$data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['title'] = $this->language->get('text_successmsg_title');
			}
			if(!isset($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['message']) || empty($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['message'])) {
				$data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['message'] = $this->language->get('text_successmsg_message');
			}
			if(!isset($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['messagepending']) || empty($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['messagepending'])) {
				$data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['messagepending'] = $this->language->get('text_successmsg_messagepending');
			}
			if(!isset($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['couponcode']) || empty($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['couponcode'])) {
				$data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['couponcode'] = $this->language->get('text_successmsg_couponcode');
			}
			if(!isset($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['rewardpoints']) || empty($data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['rewardpoints'])) {
				$data['cireviewpro_reviewsuccessmsg'][$language['language_id']]['rewardpoints'] = $this->language->get('text_successmsg_rewardpoints');
			}
		}

		/*coupon starts*/
		if (isset($this->request->post['cireviewpro_reviewcoupontype'])) {
			$data['cireviewpro_reviewcoupontype'] = $this->request->post['cireviewpro_reviewcoupontype'];
		} elseif(isset($module_info['cireviewpro_reviewcoupontype'])) {
			$data['cireviewpro_reviewcoupontype'] = $module_info['cireviewpro_reviewcoupontype'];
		} else {
			$data['cireviewpro_reviewcoupontype'] = 'F';
		}

		if (isset($this->request->post['cireviewpro_reviewcoupondays'])) {
			$data['cireviewpro_reviewcoupondays'] = $this->request->post['cireviewpro_reviewcoupondays'];
		} elseif(isset($module_info['cireviewpro_reviewcoupondays'])) {
			$data['cireviewpro_reviewcoupondays'] = $module_info['cireviewpro_reviewcoupondays'];
		} else {
			$data['cireviewpro_reviewcoupondays'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewcoupondiscount'])) {
			$data['cireviewpro_reviewcoupondiscount'] = $this->request->post['cireviewpro_reviewcoupondiscount'];
		} elseif(isset($module_info['cireviewpro_reviewcoupondiscount'])) {
			$data['cireviewpro_reviewcoupondiscount'] = $module_info['cireviewpro_reviewcoupondiscount'];
		} else {
			$data['cireviewpro_reviewcoupondiscount'] = '';
		}


		if (isset($this->request->post['cireviewpro_reviewcouponlogged'])) {
			$data['cireviewpro_reviewcouponlogged'] = $this->request->post['cireviewpro_reviewcouponlogged'];
		} elseif(isset($module_info['cireviewpro_reviewcouponlogged'])) {
			$data['cireviewpro_reviewcouponlogged'] = $module_info['cireviewpro_reviewcouponlogged'];
		} else {
			$data['cireviewpro_reviewcouponlogged'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewcouponshipping'])) {
			$data['cireviewpro_reviewcouponshipping'] = $this->request->post['cireviewpro_reviewcouponshipping'];
		} elseif(isset($module_info['cireviewpro_reviewcouponshipping'])) {
			$data['cireviewpro_reviewcouponshipping'] = $module_info['cireviewpro_reviewcouponshipping'];
		} else {
			$data['cireviewpro_reviewcouponshipping'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewcoupontotal'])) {
			$data['cireviewpro_reviewcoupontotal'] = $this->request->post['cireviewpro_reviewcoupontotal'];
		} elseif(isset($module_info['cireviewpro_reviewcoupontotal'])) {
			$data['cireviewpro_reviewcoupontotal'] = $module_info['cireviewpro_reviewcoupontotal'];
		} else {
			$data['cireviewpro_reviewcoupontotal'] = '';
		}

		if (isset($this->request->post['cireviewpro_reviewcoupon_product'])) {
			$products = $this->request->post['cireviewpro_reviewcoupon_product'];
		} elseif(isset($module_info['cireviewpro_reviewcoupon_product'])) {
			$products = (array)$module_info['cireviewpro_reviewcoupon_product'];
		} else {
			$products = array();
		}

		$this->load->model('catalog/product');

		$data['cireviewpro_reviewcoupon_products'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['cireviewpro_reviewcoupon_products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}

		if (isset($this->request->post['cireviewpro_reviewcoupon_category'])) {
			$categories = $this->request->post['cireviewpro_reviewcoupon_category'];
		} elseif (!empty($module_info['cireviewpro_reviewcoupon_category'])) {
			$categories = (array)$module_info['cireviewpro_reviewcoupon_category'];
		} else {
			$categories = array();
		}

		$this->load->model('catalog/category');

		$data['cireviewpro_reviewcoupon_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);
			if ($category_info) {
				$data['cireviewpro_reviewcoupon_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
				);
			}
		}
		

		
  	 	// coupons

		if (isset($this->request->post['cireviewpro_reviewcouponuses_total'])) {
			$data['cireviewpro_reviewcouponuses_total'] = $this->request->post['cireviewpro_reviewcouponuses_total'];
		} elseif(isset($module_info['cireviewpro_reviewcouponuses_total'])) {
			$data['cireviewpro_reviewcouponuses_total'] = $module_info['cireviewpro_reviewcouponuses_total'];
		} else {
			$data['cireviewpro_reviewcouponuses_total'] = 1;
		}

		if (isset($this->request->post['cireviewpro_reviewcouponuses_customer'])) {
			$data['cireviewpro_reviewcouponuses_customer'] = $this->request->post['cireviewpro_reviewcouponuses_customer'];
		} elseif(isset($module_info['cireviewpro_reviewcouponuses_customer'])) {
			$data['cireviewpro_reviewcouponuses_customer'] = $module_info['cireviewpro_reviewcouponuses_customer'];
		} else {
			$data['cireviewpro_reviewcouponuses_customer'] = 1;
		}
		/*coupon ends*/

		if (isset($this->request->post['cireviewpro_reviewmax'])) {
			$data['cireviewpro_reviewmax'] = $this->request->post['cireviewpro_reviewmax'];
		} elseif(isset($module_info['cireviewpro_reviewmax'])) {
			$data['cireviewpro_reviewmax'] = $module_info['cireviewpro_reviewmax'];
		} else {
			$data['cireviewpro_reviewmax'] = '';
		}
		
		if (isset($this->request->post['cireviewpro_reviewadmindir'])) {
			$data['cireviewpro_reviewadmindir'] = $this->request->post['cireviewpro_reviewadmindir'];
		} elseif(isset($module_info['cireviewpro_reviewadmindir'])) {
			$data['cireviewpro_reviewadmindir'] = $module_info['cireviewpro_reviewadmindir'];
		} else {
			$data['cireviewpro_reviewadmindir'] = 'admin';
		}
		
		if (isset($this->request->post['cireviewpro_status'])) {
			$data['cireviewpro_status'] = $this->request->post['cireviewpro_status'];
		} elseif(isset($module_info['cireviewpro_status'])) {
			$data['cireviewpro_status'] = $module_info['cireviewpro_status'];
		} else {
			$data['cireviewpro_status'] = '';
		}

	
		// Products
		$this->load->model('catalog/product');

		if (isset($this->request->post['cireviewpro_product'])) {
			$products = $this->request->post['cireviewpro_product'];
		} elseif(isset($module_info['cireviewpro_product'])) {
			$products = (array)$module_info['cireviewpro_product'];
		} else {
			$products = array();
		}

		$data['cireviewpro_products'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['cireviewpro_products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}
		
		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['cireviewpro_category'])) {
			$categories = $this->request->post['cireviewpro_category'];
		} elseif(isset($module_info['cireviewpro_category'])) {
			$categories = (array)$module_info['cireviewpro_category'];
		} else {
			$categories = array();
		}

		$data['cireviewpro_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['cireviewpro_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Manufacturers
		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['cireviewpro_manufacturer'])) {
			$manufacturers = $this->request->post['cireviewpro_manufacturer'];
		} elseif(isset($module_info['cireviewpro_manufacturer'])) {
			$manufacturers = (array)$module_info['cireviewpro_manufacturer'];
		} else {
			$manufacturers = array();
		}

		$data['cireviewpro_manufacturers'] = array();

		foreach ($manufacturers as $manufacturer_id) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

			if ($manufacturer_info) {
				$data['cireviewpro_manufacturers'][] = array(
					'manufacturer_id' => $manufacturer_info['manufacturer_id'],
					'name'        => $manufacturer_info['name']
				);
			}
		}

		// MailProducts
		$this->load->model('catalog/product');

		if (isset($this->request->post['cireviewpro_mailproduct'])) {
			$products = $this->request->post['cireviewpro_mailproduct'];
		} elseif(isset($module_info['cireviewpro_mailproduct'])) {
			$products = (array)$module_info['cireviewpro_mailproduct'];
		} else {
			$products = array();
		}

		$data['cireviewpro_mailproducts'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['cireviewpro_mailproducts'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}
		
		// MailCategories
		$this->load->model('catalog/category');

		if (isset($this->request->post['cireviewpro_mailcategory'])) {
			$categories = $this->request->post['cireviewpro_mailcategory'];
		} elseif(isset($module_info['cireviewpro_mailcategory'])) {
			$categories = (array)$module_info['cireviewpro_mailcategory'];
		} else {
			$categories = array();
		}

		$data['cireviewpro_mailcategories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['cireviewpro_mailcategories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// MailManufacturers
		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['cireviewpro_mailmanufacturer'])) {
			$manufacturers = $this->request->post['cireviewpro_mailmanufacturer'];
		} elseif(isset($module_info['cireviewpro_mailmanufacturer'])) {
			$manufacturers = (array)$module_info['cireviewpro_mailmanufacturer'];
		} else {
			$manufacturers = array();
		}

		$data['cireviewpro_mailmanufacturers'] = array();

		foreach ($manufacturers as $manufacturer_id) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

			if ($manufacturer_info) {
				$data['cireviewpro_mailmanufacturers'][] = array(
					'manufacturer_id' => $manufacturer_info['manufacturer_id'],
					'name'        => $manufacturer_info['name']
				);
			}
		}


		if (isset($this->request->post['cireviewpro_customcss'])) {
			$data['cireviewpro_customcss'] = $this->request->post['cireviewpro_customcss'];
		} elseif(isset($module_info['cireviewpro_customcss'])) {
			$data['cireviewpro_customcss'] = $module_info['cireviewpro_customcss'];
		} else {
			$data['cireviewpro_customcss'] = '';
		}

		if (isset($this->request->post['cireviewpro_customer'])) {
			$data['cireviewpro_customer'] = $this->request->post['cireviewpro_customer'];
		} elseif(isset($module_info['cireviewpro_customer'])) {
			$data['cireviewpro_customer'] = (array)$module_info['cireviewpro_customer'];
		} else {
			$data['cireviewpro_customer'] = array();
		}

	
		if (isset($this->request->post['cireviewpro_admin'])) {
			$data['cireviewpro_admin'] = $this->request->post['cireviewpro_admin'];
		} elseif(isset($module_info['cireviewpro_admin'])) {
			$data['cireviewpro_admin'] = (array)$module_info['cireviewpro_admin'];
		} else {
			$data['cireviewpro_admin'] = array();
		}

		if(VERSION <= '2.3.0.2') {
			if (isset($this->request->post['cireviewpro_reviewlistpage_keyword'])) {
				$data['cireviewpro_reviewlistpage_keyword'] = $this->request->post['cireviewpro_reviewlistpage_keyword'];
			} elseif(isset($module_info['cireviewpro_reviewlistpage_keyword'])) {
				$data['cireviewpro_reviewlistpage_keyword'] = $module_info['cireviewpro_reviewlistpage_keyword'];
			} else {
				$data['cireviewpro_reviewlistpage_keyword'] = '';
			}
		} else {
			if (isset($this->request->post['cireviewpro_reviewlistpage_keyword'])) {
				$data['cireviewpro_reviewlistpage_keyword'] = $this->request->post['cireviewpro_reviewlistpage_keyword'];
			} elseif(isset($module_info['cireviewpro_reviewlistpage_keyword'])) {
				$data['cireviewpro_reviewlistpage_keyword'] = (array)$module_info['cireviewpro_reviewlistpage_keyword'];
			} else {
				$data['cireviewpro_reviewlistpage_keyword'] = array();
			}
		}

		if (isset($this->request->post['cireviewpro_captcha'])) {
			$data['cireviewpro_captcha'] = $this->request->post['cireviewpro_captcha'];
		} elseif(isset($module_info['cireviewpro_captcha'])) {
			$data['cireviewpro_captcha'] = $module_info['cireviewpro_captcha'];
		} else {
			$data['cireviewpro_captcha'] = '';
		}

		if (isset($this->request->post['cireviewpro_adminsend'])) {
			$data['cireviewpro_adminsend'] = $this->request->post['cireviewpro_adminsend'];
		} elseif(isset($module_info['cireviewpro_adminsend'])) {
			$data['cireviewpro_adminsend'] = $module_info['cireviewpro_adminsend'];
		} else {
			$data['cireviewpro_adminsend'] = '';
		}

		
		if (isset($this->request->post['cireviewpro_adminmail'])) {
			$data['cireviewpro_adminmail'] = $this->request->post['cireviewpro_adminmail'];
		} elseif(isset($module_info['cireviewpro_adminmail'])) {
			$data['cireviewpro_adminmail'] = $module_info['cireviewpro_adminmail'];
		} else {
			$data['cireviewpro_adminmail'] = $this->config->get('config_email');
		}

		if (isset($this->request->post['cireviewpro_mailproductimagethumb_width'])) {
			$data['cireviewpro_mailproductimagethumb_width'] = $this->request->post['cireviewpro_mailproductimagethumb_width'];
		} elseif(isset($module_info['cireviewpro_mailproductimagethumb_width'])) {
			$data['cireviewpro_mailproductimagethumb_width'] = $module_info['cireviewpro_mailproductimagethumb_width'];
		} else {
			$data['cireviewpro_mailproductimagethumb_width'] = 200;
		}

		if (isset($this->request->post['cireviewpro_mailproductimagethumb_height'])) {
			$data['cireviewpro_mailproductimagethumb_height'] = $this->request->post['cireviewpro_mailproductimagethumb_height'];
		} elseif(isset($module_info['cireviewpro_mailproductimagethumb_height'])) {
			$data['cireviewpro_mailproductimagethumb_height'] = $module_info['cireviewpro_mailproductimagethumb_height'];
		} else {
			$data['cireviewpro_mailproductimagethumb_height'] = 200;
		}

		if (isset($this->request->post['cireviewpro_maillogoimagethumb_width'])) {
			$data['cireviewpro_maillogoimagethumb_width'] = $this->request->post['cireviewpro_maillogoimagethumb_width'];
		} elseif(isset($module_info['cireviewpro_maillogoimagethumb_width'])) {
			$data['cireviewpro_maillogoimagethumb_width'] = $module_info['cireviewpro_maillogoimagethumb_width'];
		} else {
			$data['cireviewpro_maillogoimagethumb_width'] = 100;
		}

		if (isset($this->request->post['cireviewpro_maillogoimagethumb_height'])) {
			$data['cireviewpro_maillogoimagethumb_height'] = $this->request->post['cireviewpro_maillogoimagethumb_height'];
		} elseif(isset($module_info['cireviewpro_maillogoimagethumb_height'])) {
			$data['cireviewpro_maillogoimagethumb_height'] = $module_info['cireviewpro_maillogoimagethumb_height'];
		} else {
			$data['cireviewpro_maillogoimagethumb_height'] = 100;
		}
		/*new updates end*/

		if (isset($this->request->post['cireviewpro_customersend'])) {
			$data['cireviewpro_customersend'] = $this->request->post['cireviewpro_customersend'];
		} elseif(isset($module_info['cireviewpro_customersend'])) {
			$data['cireviewpro_customersend'] = $module_info['cireviewpro_customersend'];
		} else {
			$data['cireviewpro_customersend'] = '';
		}

		$data['module_token'] = $this->module_token;
		$data['ci_token'] = $this->ci_token;
		$data['summernote'] = '';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(VERSION <= '2.3.0.2') {
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro.tpl', $data));
		} else {
			$file_variable = 'template_engine';
			$file_type = 'template';
			$this->config->set($file_variable, $file_type);		
			$this->response->setOutput($this->load->view('cireviewpro/cireviewpro', $data));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'cireviewpro/cireviewpro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// vote text validation
		/*foreach ($this->request->post['cireviewpro_reviewvote'] as $language_id => $value) {

			if ((utf8_strlen($value['before']) < 3) || (utf8_strlen($value['before']) > 255)) {
				$this->error['cireviewpro_reviewvote']['before'][$language_id] = $this->language->get('error_vote_before');
			}

			if ((utf8_strlen($value['yes']) < 3) || (utf8_strlen($value['yes']) > 255)) {
				$this->error['cireviewpro_reviewvote']['yes'][$language_id] = $this->language->get('error_vote_yes');
			}

			if ((utf8_strlen($value['no']) < 3) || (utf8_strlen($value['no']) > 255)) {
				$this->error['cireviewpro_reviewvote']['no'][$language_id] = $this->language->get('error_vote_no');
			}
			
			if ((utf8_strlen($value['outof']) < 3) || (utf8_strlen($value['outof']) > 255)) {
				$this->error['cireviewpro_reviewvote']['outof'][$language_id] = $this->language->get('error_vote_outof');
			} else {
				if(substr_count($value['outof'],"{VOTES}") < 1 && substr_count($value['outof'],"{TOTAL_VOTES}")) {
					$this->error['cireviewpro_reviewvote']['outof'][$language_id] = $this->language->get('error_reviewvoteoutofmissing');
				}

			}

			if ((utf8_strlen($value['percent']) < 3) || (utf8_strlen($value['percent']) > 255)) {
				$this->error['cireviewpro_reviewvote']['percent'][$language_id] = $this->language->get('error_vote_percent');
			} else {
				if(substr_count($value['percent'],"{PERCENTAGE}") < 1) {
					$this->error['cireviewpro_reviewvote']['percent'][$language_id] = $this->language->get('error_reviewvotepercentmissing');
				}
			}

		}*/


		// CiReviewPro List page validation
		foreach ($this->request->post['cireviewpro_reviewlistpage'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['cireviewpro_reviewlistpage']['title'][$language_id] = $this->language->get('error_title');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['cireviewpro_reviewlistpage']['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}
		
		// CiReviewPro policy page validation
		if($this->request->post['cireviewpro_reviewpolicy']) {
			foreach ($this->request->post['cireviewpro_reviewpolicypage'] as $language_id => $value) {
				if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
					$this->error['cireviewpro_reviewpolicypage']['title'][$language_id] = $this->language->get('error_title');
				}

				/*if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
					$this->error['cireviewpro_reviewpolicypage']['meta_title'][$language_id] = $this->language->get('error_meta_title');
				}*/
			}
		}
		foreach ($this->request->post['cireviewpro_reviewsuccessmsg'] as $language_id => $value) {
			if($this->request->post['cireviewpro_rewardsuccessalert'] == 'POPUP') {
				if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
					$this->error['reviewsuccessmsg']['title'][$language_id] = $this->language->get('error_reviewsuccessmsg_title');
				}
			}
			if($this->request->post['cireviewpro_reviewreward']) {
				if ((utf8_strlen($value['rewardpoints']) < 3)) {
					$this->error['reviewsuccessmsg']['rewardpoints'][$language_id] = $this->language->get('error_reviewsuccessmsg_rewardpoints');
				}
			}
			if($this->request->post['cireviewpro_reviewcoupon']) {
				if ((utf8_strlen($value['couponcode']) < 3)) {
					$this->error['reviewsuccessmsg']['couponcode'][$language_id] = $this->language->get('error_reviewsuccessmsg_couponcode');
				}
			}

			if ((utf8_strlen($value['message']) < 3)) {
				$this->error['reviewsuccessmsg']['message'][$language_id] = $this->language->get('error_reviewsuccessmsg');
			}
			if ((utf8_strlen($value['messagepending']) < 3)) {
				$this->error['reviewsuccessmsg']['messagepending'][$language_id] = $this->language->get('error_reviewsuccessmsg_pending');
			}
		}
		
		if(!isset($this->request->post['cireviewpro_verifypurchase_orderstatus'])) {
			$this->error['verifypurchase_orderstatus'] = $this->language->get('error_verifypurchase_orderstatus');
		}
		
		
		// customer email validation
		if($this->request->post['cireviewpro_customersend']) {
		
			foreach ($this->request->post['cireviewpro_customer'] as $language_id => $value) {
				if ((utf8_strlen($value['customertitle']) < 3) || (utf8_strlen($value['customertitle']) > 255)) {
					$this->error['customertitle'][$language_id] = $this->language->get('error_customertitle');
				}

				if ((utf8_strlen($value['customermessage']) < 3) ) {
					$this->error['customermessage'][$language_id] = $this->language->get('error_customermessage');
				}
			}
		}

		// admin email validation
		if($this->request->post['cireviewpro_adminsend']) {
			foreach ($this->request->post['cireviewpro_admin'] as $language_id => $value) {
				if ((utf8_strlen($value['admintitle']) < 3) || (utf8_strlen($value['admintitle']) > 255)) {
					$this->error['admintitle'][$language_id] = $this->language->get('error_admintitle');
				}

				if ((utf8_strlen($value['adminmessage']) < 3)) {
					$this->error['adminmessage'][$language_id] = $this->language->get('error_adminmessage');
				}
			}
		}
		
		
		if(VERSION <= '2.3.0.2') {
			// ask review List page seo keyword validation
			if (utf8_strlen($this->request->post['cireviewpro_reviewlistpage_keyword']) > 0) {
				$this->load->model('catalog/url_alias');

				$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['cireviewpro_reviewlistpage_keyword']);

				if (($url_alias_info && $url_alias_info['keyword'] != $this->request->post['cireviewpro_reviewlistpage_keyword']) || ($url_alias_info && $url_alias_info['query'] != 'cireviewpro/cireviews' ) ) {
					$this->error['cireviewpro_reviewlistpage_keyword'] = $this->language->get('error_keyword');
				}
			}
		} else {
			// ask review List page seo keyword validation
			if ($this->request->post['cireviewpro_reviewlistpage_keyword']) {
				$this->load->model('design/seo_url');

				foreach ($this->request->post['cireviewpro_reviewlistpage_keyword'] as $store_id => $language) {
					foreach ($language as $language_id => $keyword) {
						if (!empty($keyword)) {
							if (count(array_keys($language, $keyword)) > 1) {
								$this->error['cireviewpro_reviewlistpage_keyword'][$store_id][$language_id] = $this->language->get('error_unique');
							}						
							
							$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
							
							foreach ($seo_urls as $seo_url) {
								if (($seo_url['store_id'] == $store_id) && ( $keyword != $seo_url['keyword'] || ($seo_url['query'] != 'cireviewpro/cireviews'))) {
									$this->error['cireviewpro_reviewlistpage_keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
									
									break;
								}
							}
						}
					}
				}
			}
		}
		
		
		// is reward points then make sure reward points greater than 0
		if($this->request->post['cireviewpro_reviewreward']) {
			if($this->request->post['cireviewpro_rewardpoints'] <= 0) {
				$this->error['cireviewpro_rewardpoints'] = $this->language->get('error_rewardpoints');	
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			// $this->error['warning'] = $this->language->get('error_warning');
			// echo $this->error;
		    $this->error['warning'] = $this->error;

			// $this->error['warning'] = implode("|",$this->error);

		}

		return !$this->error;
	}
}