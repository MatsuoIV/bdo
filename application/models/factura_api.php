<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Factura_api extends MY_Model {
	function __construct() {
		parent::__construct();
	}

	function display_create_invoice() {
		$this->load->model('servicios_mdl');
		$this->load->model('factura_grupos_mdl');
		$data = array(
			'servicios'			=>	$this->servicios_mdl->get(),
			'factura_grupos'	=>	$this->factura_grupos_mdl->get()
		);
		$this->load->view('facturas/escoger_servicio', $data);
	}

	function crear_factura($package) {
		if (!is_array($package)) {
			return FALSE;
		}
		$required_elements = array(
			'servicio_id',
			'factura_fecha_ingreso',
			'factura_grupo_id'
		);
		foreach ($required_elements as $req_el) {
			if (!isset($package[$req_el])) {
				return FALSE;
			}
		}

		extract($package);

		$this->load->model('facturas_mdl');
		$factura_id = $this->facturas_mdl->save($servicio_id, $factura_fecha_ingreso);

		if (isset($invoice_discount)) {
			$this->facturas_mdl->set_invoice_discount($invoice_id, $invoice_discount);
		}

		$this->ajuste_factura_monto($factura_id);
		$this->load->model('factura_grupos_mdl');
		$this->factura_grupos_mdl->ajuste_factura_numero($factura_id, $factura_grupo_id);
		return $factura_id;
	}

	function add_invoice_item($package) {
		if (!is_array($package)) {
			return FALSE;
		}
		extract($package);
		$required_elements = array(
			'invoice_id',
			'item_name',
			'item_description',
			'item_qty',
			'item_price'
		);
		foreach ($required_elements as $req_el) {
			if (!isset($package[$req_el])) {
				return FALSE;
			}
		}
		$this->load->model('invoices/mdl_invoices');

		$tax_rate_id = (isset($tax_rate_id) ? $tax_rate_id : 0);

		$invoice_item_id = $this->mdl_invoices->add_invoice_item($invoice_id, $item_name, $item_description, $item_qty, $item_price, $tax_rate_id);

		return $invoice_item_id;

	}

	function add_invoice_discount($invoice_id, $invoice_discount) {

		$this->mdl_invoices->set_invoice_discount($invoice_id, $invoice_discount);

	}


	function ajuste_factura_monto($factura_id) {
		$this->load->model('factura_montos_mdl');
		$this->factura_montos_mdl->ajuste($factura_id);
	}

}

?>