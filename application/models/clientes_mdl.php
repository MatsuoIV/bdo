<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Clientes_mdl extends MY_Model {
	public function __construct() {
		parent::__construct();
		$this->table_name = 'cliente';	
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS
cliente.*,
cliente.Grupo_id as join_cliente_id,
cliente.Industria_id as join_industria_id,
(SELECT denominacion FROM grupo WHERE id = join_cliente_id) AS cliente_grupo,
(SELECT codigo FROM industria WHERE id = join_industria_id) AS cliente_industria
";
		$this->primary_key = 'cliente.id';
		$this->order_by = 'cliente_grupo, razonsocial';
//		$this->custom_fields = $this->mdl_fields->get_object_fields(3);
	}

/*	public function listadoservicios($id_cliente){
		$table_name2 = 'servicios';	
		$this->db->select('servicios.id, concat(servicios.codigo,servicios.id) as codigo, tiposervicio.denominacion');
		$this->db->join('tiposervicio', 'servicios.TipoServicio_id= tiposervicio.id');
		$this->db->where('servicios.Cliente_id', $id_cliente);
		$this->db->order_by('codigo','asc');
		return $this->db->get($table_name2)->result();
	}
*/

	/* Facturacion de cuotas de un servicio */
	public function dameBalanceServicio($servicio_id){
		$servicio_id = (int) $servicio_id;
		$sql = "SELECT SUM(cuota_factura.monto) AS balance
				FROM cuota 
				LEFT JOIN 
					(SELECT SUM(monto) AS monto, cuota_id FROM cuota_factura
				GROUP BY cuota_id) AS cuota_factura
		ON cuota_factura.cuota_id= cuota.id
		WHERE cuota.servicio_id=".$servicio_id." GROUP BY servicio_id";
		$r = $this->db->query($sql)->row();
		return isset($r->balance)? $r->balance : '0.00';
	}

	public function listadoservicios($id_cliente, $anio=NULL){

		$table_name2 = 'servicios';	

		$this->db->select('servicios.id, servicios.codigo as codigo, tiposervicio.denominacion, servicios.moneda_id, moneda.simbolo');
		$this->db->join('tiposervicio', 'servicios.TipoServicio_id= tiposervicio.id');
		$this->db->join('moneda', 'servicios.moneda_id=moneda.id');
		$this->db->where('servicios.Cliente_id', $id_cliente);
		if(!is_null($anio)){
			$this->db->where('SUBSTRING(servicios.codigo,6,4)', $anio);
		}
		$this->db->order_by('servicios.codigo','asc');
		$servicios = $this->db->get($table_name2)->result();

		foreach($servicios as $servicio){
			$servicio->balance = $this->dameBalanceServicio($servicio->id);
		}
		return $servicios;
	}

	function get_clientes($select='codigo,razonsocial_fact'){
		$this->db->select($select);									
		$this->db->order_by('razonsocial_fact','asc');
		return $this->db->get('cliente')->result();		
	}

}

?>