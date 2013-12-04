<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Factura_estados_mdl extends MY_Model {
	public $factura_estados;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'factura_estado';
		$this->primary_key = 'id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'id';
	}

	public function validate() {
		$this->form_validation->set_rules('denominacion', "Denominacion del estado", 'required');
		$this->form_validation->set_rules('descripcion', "Descripcion del estado", 'required');
		return parent::validate();
	}

}

?>