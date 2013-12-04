<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Items extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('items_mdl');
		$this->load->helper(array('text', 'bdo_app'));		
	}

	function index() {
		$this->redir->set_last_index();
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	10,
			'page'		=>	uri_assoc('page')
		);
		$data = array(
			'items' =>	$this->items_mdl->get($params)
		);
		$this->load->view('facturas/items/items_list', $data);
	}

	function edit() {
		if (!$this->items_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('item_id')) {
				$this->items_mdl->prep_validation(uri_assoc('item_id'));
			}
			$this->load->view('facturas/items/items_edit');
		}else {
			$this->items_mdl->save($this->items_mdl->db_array(), uri_assoc('item_id'));
			$this->redir->redirect('items');
		}
	}

	function delete() {
		if (uri_assoc('item_id')) {
			$this->items_mdl->delete(array('id'=>uri_assoc('item_id')));
		}
		$this->redir->redirect('items');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('items/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('items/index');
		}
	}
}

?>