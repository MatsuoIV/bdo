<?php

class Tipocomprobante_mdl extends MY_Model{

	public function __construct() {
		parent::__construct();
		$this->table_name = 'tipocomprobante';
		$this->select_fields = "SQL_CALC_FOUND_ROWS tipocomprobante.*";
		$this->primary_key = 'tipocomprobante.id';
		$this->joins = array();
	}

	public function dameTiposFactura(){
		return $this->db->query("SELECT id, denominacion FROM tipocomprobante WHERE id<3")->result();
	}
}