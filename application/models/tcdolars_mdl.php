<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class tcdolars_mdl extends MY_Model {
	public $tcdolars;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'tcdolar';
		$this->primary_key = 'tcdolar.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'tcdolar.fecha desc';
	}

	public function validate() {
		$this->form_validation->set_rules('compra', "Valor de compra", 'required');
		$this->form_validation->set_rules('venta', "Valor de venta", 'required');
		$this->form_validation->set_rules('fecha', "Fecha del registro", 'required');
		return parent::validate();
	}

	public function get_tipocambio() {
		$this->db->select_max('id');
		return $this->db->get('');
	}

}

?>