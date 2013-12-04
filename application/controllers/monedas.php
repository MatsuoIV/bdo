<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Monedas extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('monedas_mdl');
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
			'monedas' =>	$this->monedas_mdl->get($params)
		);
		$this->load->view('monedas/monedas_list', $data);
	}

	function edit() {
		if (!$this->monedas_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('id')) {
				$this->monedas_mdl->prep_validation(uri_assoc('id'));
			}
			$this->load->view('monedas/monedas_edit');
		}else {
			$this->monedas_mdl->save($this->monedas_mdl->db_array(), uri_assoc('id'));
			$this->redir->redirect('monedas');
		}
	}

	function delete() {
		if (uri_assoc('id')) {
			$this->monedas_mdl->delete(array('id'=>uri_assoc('id')));
		}
		$this->redir->redirect('monedas');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('monedas/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('monedas/index');
		}
	}
}

?>