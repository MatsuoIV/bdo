<?php
class Factura_logs_mdl extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table_name = 'factura_log';
		$this->primary_key = 'factura_log.factura_log_id';
		$this->order_by = 'factura_log_fecha DESC';
		$this->select = 'factura_log.*, users.username, factura.factura_numero';
		$this->joins = array(
			'users'		=>	'users.id = factura_log.personal_id',
			'factura'	=>	'factura.factura_id = factura_log.factura_id'
		);
	}

	function clear_history($factura_id = NULL) {
		if ($factura_id) {
			$this->db->where('factura_id', $factura_id);
		}
		else {
			$this->db->where('factura_id >', 0);
		}
		$this->db->delete($this->table_name);
	}

}

?>