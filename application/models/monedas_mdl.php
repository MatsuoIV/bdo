<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Monedas_mdl extends MY_Model {
	public $monedas;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'moneda';
		$this->primary_key = 'moneda.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'id';
	}

	public function validate() {
		$this->form_validation->set_rules('codigo', "Codigo de la moneda", 'exact_length[3]');
		$this->form_validation->set_rules('denominacion', "Denominacion de la moneda", 'required');
		$this->form_validation->set_rules('simbolo', "Simbolo de la moneda", 'required');
		return parent::validate();
	}

}

?>