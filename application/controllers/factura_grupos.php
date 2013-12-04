<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Factura_grupos extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('factura_grupos_mdl');
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
			'factura_grupos' =>	$this->factura_grupos_mdl->get($params)
		);
		$this->load->view('facturas/factura_grupos/factura_grupos_list', $data);
	}

	function edit() {
		if (!$this->factura_grupos_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('factura_grupo_id')) {
				$this->factura_grupos_mdl->prep_validation(uri_assoc('factura_grupo_id'));
			}
			$this->load->view('facturas/factura_grupos/factura_grupos_edit');
		}else {
			$this->factura_grupos_mdl->save($this->factura_grupos_mdl->db_array(), uri_assoc('factura_grupo_id'));
			$this->redir->redirect('factura_grupos');
		}
	}

	function delete() {
		if (uri_assoc('factura_grupo_id')) {
			$this->factura_grupos_mdl->delete(array('id'=>uri_assoc('factura_grupo_id')));
		}
		$this->redir->redirect('factura_grupos');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('factura_grupos/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('factura_grupos/index');
		}
	}
}

?>