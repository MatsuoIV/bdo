<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Items_mdl extends MY_Model {
	public $items;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'item';
		$this->primary_key = 'item.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'id';
	}

	public function validate() {
		$this->form_validation->set_rules('nombre', "Nombre de item", 'required');
		$this->form_validation->set_rules('descripcion', "Descripcion de item", 'required');
		return parent::validate();
	}

}

?>