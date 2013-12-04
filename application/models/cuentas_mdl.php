<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class cuentas_mdl extends MY_Model {
	public $cuentas;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'cuenta';
		$this->primary_key = 'cuenta.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'banco_id';
	}

	public list_cuentas(){
		$this->select_fields
	}
	
	public function validate() {
		$this->form_validation->set_rules('numero', "numero de la cuenta", 'required');
		$this->form_validation->set_rules('moneda', "Moneda", 'required');
		return parent::validate();
	}

}

?>