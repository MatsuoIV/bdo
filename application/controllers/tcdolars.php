<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class tcdolars extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('tcdolars_mdl');
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
			'tcdolars' =>	$this->tcdolars_mdl->get($params)
		);
		$this->load->view('tcdolars/tcdolars_list', $data);
	}

	function edit() {
		if (!$this->tcdolars_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('id')) {
				$this->tcdolars_mdl->prep_validation(uri_assoc('id'));
			}
			$this->load->view('tcdolars/tcdolars_edit');
		}else {

			$fields = $this->tcdolars_mdl->db_array();

			$fecha = explode('/', $fields['fecha']);
			if(!isset($fecha[1], $fecha[2]) || !checkdate($fecha[1], $fecha[0], $fecha[2]) ){

			} else{
				$fields['fecha'] = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
				$this->tcdolars_mdl->save($fields, uri_assoc('id'));
			}			
			$this->redir->redirect('tcdolars');
		}
	}

	function delete() {
		if (uri_assoc('id')) {
			$this->tcdolars_mdl->delete(array('id'=>uri_assoc('id')));
		}
		$this->redir->redirect('tcdolars');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('tcdolars/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('tcdolars/index');
		}
	}
}

?>