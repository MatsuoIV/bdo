<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Bancos extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('bancos_mdl');
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
			'bancos' =>	$this->bancos_mdl->get($params)
		);
		$this->load->view('bancos/bancos_list', $data);
	}
	
		
	
	function edit() {
		if (!$this->bancos_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('banco_id')) {
				$this->bancos_mdl->prep_validation(uri_assoc('banco_id'));
			}
			$this->load->view('bancos/bancos_edit');
		}else {
			$this->bancos_mdl->save($this->bancos_mdl->db_array(), uri_assoc('banco_id'));
			$this->redir->redirect('bancos');
		}
	}

	function delete() {
		if (uri_assoc('banco_id')) {
			$this->bancos_mdl->delete(array('id'=>uri_assoc('banco_id')));
		}
		$this->redir->redirect('bancos');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('bancos/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('bancos/index');
		}
	}
}

?>