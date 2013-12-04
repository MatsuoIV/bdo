<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Factura_estados extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('factura_estados_mdl');
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
			'factura_estados' =>	$this->factura_estados_mdl->get($params)
		);
		$this->load->view('facturas/factura_estados/factura_estados_list', $data);
	}

	function edit() {
		if (!$this->factura_estados_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('factura_estado_id')) {
				$this->factura_estados_mdl->prep_validation(uri_assoc('factura_estado_id'));
			}
			$this->load->view('facturas/factura_estados/factura_estados_edit');
		}else {
			$this->factura_estados_mdl->save($this->factura_estados_mdl->db_array(), uri_assoc('factura_estado_id'));
			$this->redir->redirect('factura_estados');
		}
	}
 
	function delete() {
		if (uri_assoc('factura_estado_id')) {
			$this->factura_estados_mdl->delete(array('id'=>uri_assoc('factura_estado_id')));
		}
		$this->redir->redirect('factura_estados');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('factura_estados/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('factura_estados/index');
		}
	}
}

?>