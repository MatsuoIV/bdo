<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Factura_grupos_mdl extends MY_Model {
	public $factura_grupos;

	public function __construct() {
		parent::__construct();
		$this->table_name = 'factura_grupo';
		$this->primary_key = 'factura_grupo.id';
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS *,
		factura_grupo.Compania_id as join_compania_id,	
		(SELECT codigo FROM compania WHERE id = join_compania_id) AS codigo_compania	
		";
		$this->order_by = 'factura_grupo.id';

	$array_companias = array();
	foreach ($this->db->get('compania')->result_array() as $compania) {
	  $array_companias[$compania['id']] = $compania['codigo'];
	}
	$this->companias = $array_companias;

		
		
}

	public function validate() {
		$this->form_validation->set_rules('Compania_id', "Compania", 'required');
		$this->form_validation->set_rules('nombre', "Nombre del grupo", 'required');
		$this->form_validation->set_rules('prefijo', "Prefijo del grupo", 'required');
		$this->form_validation->set_rules('minimo', "Primer correlativo", 'is_natural_no_zero');
		$this->form_validation->set_rules('maximo', "Ultimo correlativo", 'is_natural_no_zero');
		$this->form_validation->set_rules('actual', "Actual correlativo", 'is_natural_no_zero');		
		return parent::validate();
	}
	
	
	
	

	public function ajuste_factura_numero($factura_id, $factura_grupo_id) {
//		$factura = $this->facturas_mdl->get_by_id($factura_id);
	$factura = $this->db->get_where('factura', array('factura_id' => $factura_id))->row();		
				
		if ($factura->factura_grupo_id <> $factura_grupo_id) {
		
			$grupo = parent::get_by_id($factura_grupo_id);
			$factura_numero = '';	
			$factura_numero .= $grupo->factura_grupo_prefijo.'-'.str_pad($grupo->factura_grupo_siguiente, 5, '0', STR_PAD_LEFT);
			/* Update the invoice group record with the incremented next invoice id */
			$this->db->set('factura_grupo_siguiente', $grupo->factura_grupo_siguiente+ 1);
			$this->db->where('factura_grupo_id', $grupo->factura_grupo_id);
			$this->db->update('factura_grupo');
			/* Assign the invoice number to the invoice */
			$this->db->set('factura_numero', $factura_numero);
			$this->db->set('factura_grupo_id', $factura_grupo_id);
			$this->db->where('factura_id', $factura_id);
			$this->db->update('factura');
		}

	}	
	

	
	
	
	
	
	
	
	
	
	
}

?>