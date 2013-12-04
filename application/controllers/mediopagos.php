<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mediopagos extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('mediopagos_mdl');
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
			'mediopagos' =>	$this->mediopagos_mdl->get($params)
		);
		$this->load->view('mediopagos/mediopagos_list', $data);
	}

	function edit() {
		if (!$this->mediopagos_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('mediopago_id')) {
				$this->mediopagos_mdl->prep_validation(uri_assoc('mediopago_id'));
			}
			$this->load->view('mediopagos/mediopagos_edit');
		}else {
			$this->mediopagos_mdl->save($this->mediopagos_mdl->db_array(), uri_assoc('mediopago_id'));
			$this->redir->redirect('mediopagos');
		}
	}

	function delete() {
		if (uri_assoc('mediopago_id')) {
			$this->mediopagos_mdl->delete(array('id'=>uri_assoc('mediopago_id')));
		}
		$this->redir->redirect('mediopagos');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('mediopagos/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('mediopagos/index');
		}
	}
}

?>