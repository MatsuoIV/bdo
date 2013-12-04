<?php (defined('BASEPATH')) OR exit('No direct script access allowed');


class Pagos_mdl extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table_name = 'pago';
		$this->primary_key = 'pago.pago_id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *, servicios.codigo as servicio_codigo, tipocomprobante.codigo as tipocomprobante_codigo, moneda.simbolo as moneda_simbolo";
		$this->order_by = 'pago.pago_fecha DESC';
		$this->joins = array(
			'factura' => 'pago.factura_id = factura.factura_id',
			'servicios' => 'factura.servicio_id = servicios.id',
			'cliente' => 'servicios.Cliente_id = cliente.id',
			'moneda' => 'pago.moneda_id = moneda.id',
			'banco' => 'pago.banco_id = banco.banco_id',
			'mediopago' => 'pago.mediopago_id = mediopago.mediopago_id',
			'tipocomprobante' => 'factura.tipocomprobante_id = tipocomprobante.id',
			'factura_grupo' => 'factura.factura_grupo_id = factura_grupo.factura_grupo_id',
			'factura_montos' => 'factura.factura_id = factura_montos.factura_id');
	}

	public function validate() {
		if (!uri_assoc('factura_id')) {
			$this->form_validation->set_rules('factura_id', 'Factura', 'required');
		}
		$this->form_validation->set_rules('moneda_id', 'Moneda', 'required');
		$this->form_validation->set_rules('pago_monto', 'Monto', 'required|callback_monto_validado');
		$this->form_validation->set_rules('pago_fecha', 'Fecha', 'required');
		$this->form_validation->set_rules('mediopago_id', 'Medio de pago', 'required');
		$this->form_validation->set_rules('banco_id', 'Banco', 'required');
		$this->form_validation->set_rules('pago_documento', 'Documento de referencia', 'required');
		$this->form_validation->set_rules('pago_obs', 'Observaciones');
		return parent::validate($this);
	}

	public function monto_validado($pago_monto) {
		if (uri_assoc('factura_id')) {
			$factura_id = uri_assoc('factura_id');
		}
		elseif($this->input->post('factura_id')) {
			$factura_id = $this->input->post('factura_id');
		}
		$this->db->select('factura_montos_balance');
		$this->db->where('factura_id', $factura_id);
		$factura_balance = $this->db->get('factura_montos')->row()->factura_montos_balance;
		if (!uri_assoc('pago_id')) {
			if ($pago_monto > $factura_balance) {
				$this->form_validation->set_message('monto_validado', "El monto de pago no puede exceder del balance de la factura.");
				return FALSE;
			}
		}
		elseif (uri_assoc('pago_id')) {
			$params = array(
				'where'	=>	array(
					'pago.pago_id'	=>	uri_assoc('pago_id')
				)
			);
			$monto_original = parent::get($params)->pago_monto;
			if ($pago_monto > ($factura_balance + $monto_original)) {
				$this->form_validation->set_message('monto_validado',"El monto de pago no puede exceder del balance de la factura.");
				return FALSE;
			}
		}
		return TRUE;
	}


	public function set_date() {
		$this->set_form_value('pago_fecha_registro', formato_fecha(time()));
	}

	public function db_array() {
		$db_array = parent::db_array();
		if (uri_assoc('factura_id')) {
			$db_array['factura_id'] = uri_assoc('factura_id');
		}elseif ($this->input->post('factura_id')) {
			$db_array['factura_id'] = $this->input->post('factura_id');
		}
		$db_array['pago_fecha'] = strtotime(standardize_date($db_array['pago_fecha']));
		$db_array['pago_monto'] = standardize_number($db_array['pago_monto']);
		return $db_array;
	}

	public function save() {
		$db_array = $this->db_array();
		parent::save($db_array, uri_assoc('pago_id'));
	}

	public function prep_validation($key) {
		parent::prep_validation($key);
		if (!$_POST) {
			$this->set_form_value('pago_fecha', formato_fecha($this->form_value('pago_fecha')));
		}
	}

	public function get_factura_id($pago_id) {
		$this->db->select('factura_id');
		$this->db->where('pago_id', $pago_id);
		return $this->db->get('pago')->row()->factura_id;
	}

    public function get_total_pagado($params = NULL) {
        $params = ($params) ? $params : array();
        $params['select'] = 'IFNULL(SUM(pago_monto), 0) AS total_factura_pagado';
        $result = parent::get($params);
        return $result[0]->total_factura_pagado;

    }




}

?>