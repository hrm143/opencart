<?php 
class ControllerPaymentPayPalDirect extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/paypal_direct');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('paypal_direct', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('extension/payment'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_signature'] = $this->language->get('entry_signature');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['help_encryption'] = $this->language->get('help_encryption');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		$this->data['error_warning'] = @$this->error['warning'];
		$this->data['error_username'] = @$this->error['username'];
		$this->data['error_password'] = @$this->error['password'];
		$this->data['error_signature'] = @$this->error['signature'];

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('extension/payment'),
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('payment/paypal_direct'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->https('payment/paypal_direct');
		
		$this->data['cancel'] = $this->url->https('extension/payment');

		if (isset($this->request->post['paypal_direct_username'])) {
			$this->data['paypal_direct_username'] = $this->request->post['paypal_direct_username'];
		} else {
			$this->data['paypal_direct_username'] = $this->config->get('paypal_direct_username');
		}
		
		if (isset($this->request->post['paypal_direct_password'])) {
			$this->data['paypal_direct_password'] = $this->request->post['paypal_directe_password'];
		} else {
			$this->data['paypal_direct_password'] = $this->config->get('paypal_direct_password');
		}
		
		if (isset($this->request->post['paypal_direct_signature'])) {
			$this->data['paypal_direct_signature'] = $this->request->post['paypal_direct_signature'];
		} else {
			$this->data['paypal_direct_signature'] = $this->config->get('paypal_direct_signature');
		}
		
		if (isset($this->request->post['paypal_direct_test'])) {
			$this->data['paypal_direct_test'] = $this->request->post['paypal_direct_test'];
		} else {
			$this->data['paypal_direct_test'] = $this->config->get('paypal_direct_test');
		}
		
		if (isset($this->request->post['paypal_direct_method'])) {
			$this->data['paypal_direct_transaction'] = $this->request->post['paypal_direct_transaction'];
		} else {
			$this->data['paypal_direct_transaction'] = $this->config->get('paypal_direct_transaction');
		}
		
		if (isset($this->request->post['paypal_direct_order_status_id'])) {
			$this->data['paypal_direct_order_status_id'] = $this->request->post['paypal_direct_order_status_id'];
		} else {
			$this->data['paypal_direct_order_status_id'] = $this->config->get('paypal_direct_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['paypal_direct_geo_zone_id'])) {
			$this->data['paypal_direct_geo_zone_id'] = $this->request->post['paypal_direct_geo_zone_id'];
		} else {
			$this->data['paypal_direct_geo_zone_id'] = $this->config->get('paypal_direct_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['paypal_direct_status'])) {
			$this->data['paypal_direct_status'] = $this->request->post['paypal_direct_status'];
		} else {
			$this->data['paypal_direct_status'] = $this->config->get('paypal_direct_status');
		}
		
		if (isset($this->request->post['paypal_direct_sort_order'])) {
			$this->data['paypal_direct_sort_order'] = $this->request->post['paypal_direct_sort_order'];
		} else {
			$this->data['paypal_direct_sort_order'] = $this->config->get('paypal_direct_sort_order');
		}
		
		$this->id       = 'content';
		$this->template = 'payment/paypal_direct.tpl';
		$this->layout   = 'common/layout';
		
 		$this->render();
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/paypal_direct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!@$this->request->post['paypal_direct_username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!@$this->request->post['paypal_direct_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!@$this->request->post['paypal_direct_signature']) {
			$this->error['signature'] = $this->language->get('error_signature');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>