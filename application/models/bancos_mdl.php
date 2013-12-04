<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class bancos_mdl extends MY_Model {
	public $bancos;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'banco';
		$this->primary_key = 'banco.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'nombre';
	}

	public function validate() {
		$this->form_validation->set_rules('codigo', "Codigo de banco", 'required');
		$this->form_validation->set_rules('nombre', "Nombre de banco", 'required');
		$this->form_validation->set_rules('tipo', "Nombre de banco", 'required');
		return parent::validate();
	}

}

?>