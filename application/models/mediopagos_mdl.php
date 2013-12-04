<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mediopagos_mdl extends MY_Model {
	public $mediopagos;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'mediopago';
		$this->primary_key = 'mediopago.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'mediopago.id';
	}

	public function validate() {
		$this->form_validation->set_rules('nombre', "Nombre del medio de pago", 'required');
		return parent::validate();
	}

}

?>