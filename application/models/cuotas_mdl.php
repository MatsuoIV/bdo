<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Cuotas_mdl extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table_name = 'cuota';
		$this->select_fields = "SQL_CALC_FOUND_ROWS cuota.*, moneda.simbolo as moneda_simbolo";
		$this->primary_key = 'cuota.id';
		$this->joins = array(
			'moneda' => 'cuota.moneda_id = moneda.id');
	}

	//Devuelve listado de cuotas para un servicio
	
	public function get_cuotas($servicio_id) {
		$this->db->select('cuota.id AS cuota_id, cuota.monto, cuota.fecha, cuota.saldo, cuota.moneda_id, cuota.servicio_id, moneda.id, moneda.codigo, moneda.denominacion, moneda.simbolo');
		$this->db->where('servicio_id', $servicio_id);
		$this->db->join('moneda', 'cuota.moneda_id = moneda.id');
		//$this->db->join('servicio', 'cuota.servicio_id = servicio.id');	
		$this->db->order_by('cuota.fecha','asc');	
		return $this->db->get('cuota')->result();
	} 

	function dameCuotasDeServicio($servicio_id, $fields='*', $where_extra=''){
		$servicio_id = (int) $servicio_id;
		$sql = 'SELECT '.$fields.' FROM cuota as c JOIN servicios as s ON c.servicio_id = s.id WHERE c.servicio_id='.$servicio_id.' '.$where_extra;
		return $this->db->query($sql)->result_array();
	}

	//Devuelve el total programado para un servicio
	public function get_hprogramado($servicio_id) {
		$this->db->select('IFNULL(SUM(monto),0.00) as programado',FALSE);
		$this->db->where('servicio_id', $servicio_id);
		return $this->db->get('cuota')->row()->programado;
	}
	
	//Devuelve listado de monedas
	public function get_monedas() {
		return $this->db->get('moneda')->result();
	}	

	//Eliminar cuota
	function eliminar($cuota_id) {
		$this->db->where('id', $cuota_id);
		$this->db->delete('cuota');
		$this->session->set_flashdata('success_delete', TRUE);
		return TRUE;		
	}
	
	function agregar($array){
		$this->db->insert('cuota', $array);
		return $this->db->insert_id();
	}	

	// funcion autocompletar
	function autocompletar($buscar){
		$this->db->select('servicios.id, servicios.codigo');
		$this->db->select("CONCAT(servicios.codigo,' << ',cliente.razonsocial,' << ',tiposervicio.denominacion) AS value", FALSE); 		
		$this->db->join('cliente', 'servicios.Cliente_id = cliente.id');		
		$this->db->join('tiposervicio', 'servicios.TipoServicio_id = tiposervicio.id');	
		$this->db->where('servicios.Estado_id', 4);
		$this->db->like("CONCAT(servicios.codigo,' << ',cliente.razonsocial,' << ',tiposervicio.denominacion)", $buscar); 		
		$this->db->order_by('servicios.codigo','asc');	
		return $this->db->get('servicios');
	}

	function dameCuotasPendientes($fecha, $order_by=NULL, $order='DESC'){
		$sql = "SELECT c.*, s.codigo, s.cliente_id, cl.razonsocial, ge.denominacion FROM cuota AS c
			INNER JOIN servicios AS s ON s.id=c.servicio_id
			INNER JOIN cliente AS cl ON cl.id=s.cliente_id
			LEFT JOIN grupo AS ge ON ge.id=cl.Grupo_id
			WHERE saldo > 0 AND fecha<=?";
		if(is_null($order_by)){
			$order_by = 'cl.Grupo_id DESC, cl.id';
		}
		$sql .= ' ORDER BY '.$order_by.' '.$order;

		return $this->db->query($sql, array($fecha))->result_array();
	}

	/*
	function dameCuotasEnPago(){
		return $this->db->query("SELECT c.*, s.codigo, s.cliente_id, cl.razonsocial FROM cuota AS c
			INNER JOIN servicios AS s ON s.id=c.servicio_id
			INNER JOIN cliente AS cl ON cl.id=s.cliente_id
			WHERE monto > saldo AND saldo >0")->result_array();
	} */

}

?>