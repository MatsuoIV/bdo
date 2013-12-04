<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Tipocambio extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('impuestos_mdl');
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
			'impuestos' =>	$this->impuestos_mdl->get($params)
		);
		$this->load->view('facturas/impuestos/impuestos_list', $data);
	}

	function edit() {
		if (!$this->impuestos_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('impuesto_id')) {
				$this->impuestos_mdl->prep_validation(uri_assoc('impuesto_id'));
			}
			$this->load->view('facturas/impuestos/impuestos_edit');
		}else {
			$this->impuestos_mdl->save($this->impuestos_mdl->db_array(), uri_assoc('impuesto_id'));
			$this->redir->redirect('impuestos');
		}
	}

	function delete() {
		if (uri_assoc('impuesto_id')) {
			$this->impuestos_mdl->delete(array('impuesto_id'=>uri_assoc('impuesto_id')));
		}
		$this->redir->redirect('impuestos');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('impuestos/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('impuestos/index');
		}
	}
}

?>