<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class impuestos_mdl extends MY_Model {
	
	public $impuestos;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'impuesto';
		$this->primary_key = 'impuesto.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *";
		$this->order_by = 'id,nombre';
	}

	public function validate() {
		$this->form_validation->set_rules('nombre', "Nombre de impuesto", 'required');
		$this->form_validation->set_rules('porcentaje', "Porcentaje de impuesto", 'decimal');
		return parent::validate();
	}
	
/*
	public function delete($tax_rate_id) {

		$this->db->where('tax_rate_id', $tax_rate_id);
		$query = $this->db->get('mcb_invoice_tax_rates');
		if ($query->num_rows()) {
			$this->session->set_flashdata('custom_error', $this->lang->line('cannot_delete_tax_rate'));
			return FALSE;
		}
		elseif ($this->mdl_mcb_data->setting('default_tax_rate_id') == $tax_rate_id) {
			$this->session->set_flashdata('custom_error', $this->lang->line('cannot_delete_default_tax_rate'));
			return FALSE;
		}
		else {
			$this->db->where('tax_rate_id', $tax_rate_id);
			$this->db->delete('mcb_tax_rates');
			$this->session->set_flashdata('success_delete', TRUE);
			return TRUE;
		}
	
	}*/

	public function get_factura_impuestos($factura_id) {
		$this->db->join('impuesto', 'impuesto.impuesto_id = factura_impuesto.impuesto_id');
		$this->db->where('factura_id', $factura_id);
		$this->db->order_by('factura_impuesto.factura_impuesto_id');
		return $this->db->get('factura_impuesto')->result();
	}









}

?>