<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Factura_montos_mdl extends CI_Model {

	function ajuste($factura_id = NULL) {
		if ($factura_id) {
			/* Adjust a single invoice */
			$this->_ajuste($factura_id);
		}else {
			/* Adjust all invoices */
			$this->db->select('factura_id, servicio_id');
			$facturas = $this->db->get('factura')->result();
			foreach ($facturas as $factura) {
				$this->_adjust($factura->factura_id);
			}
		}
	}

	function _ajuste($factura_id) {
		$this->_update_factura_montos($factura_id);
//		$this->_update_factura_estado($factura_id);
	}

	function _update_factura_montos($factura_id) {
		$this->db->select(
			'IFNULL(SUM(pago_monto),0.00) AS factura_monto_pagado',
			FALSE
		);
		$this->db->where('factura_id', $factura_id);
		$monto_factura = $this->db->get('pago')->row();
		
			$db_array = array(
				'factura_montos_pagado'		=>	$monto_factura->factura_monto_pagado
			);
			
			if ($this->db->get('pago')->num_rows()) {
				$this->db->where('factura_id', $factura_id);
				$this->db->update('factura_montos', $db_array);
			}else {
				$this->db->insert('factura_montos', $db_array);
			}
	}



}

?>