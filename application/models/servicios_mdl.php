<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Servicios_mdl extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table_name = 'servicios';
		$this->select_fields = "SQL_CALC_FOUND_ROWS
			servicios.id as servicio_id, 
			servicios.codigo as servicio_codigo, 
			concat(personal.apellidos,', ',personal.nombres) as responsable, 
			tiposervicio.denominacion as servicio_tipo, 
			moneda.simbolo as moneda_simbolo, 
			moneda.denominacion as moneda_denominacion, 
			compania.razonsocial as compania_razonsocial,
			cliente.razonsocial as cliente_razonsocial,
			cliente.razonsocial_fact as cliente_razonsocial_fact,
			cliente.domiciliofiscal as cliente_domicilio, 
			cliente.ruc as cliente_ruc, 
			grupo.denominacion as grupo_denominacion, 
			estadoservicio.denominacion as servicio_estado_denominacion, 
			servicios.hpropuesto, 
			servicios.haceptado, 
			servicios.fecha_registro as servicio_fecha_registro, 
			servicios.obs as servicio_obs, 
			servicios.creador servicio_creador,
			industria.denominacion as industria_denominacion";

		$this->joins = array(
			'cliente'		=>	'servicios.Cliente_id = cliente.id',
			'tiposervicio'	=>	'servicios.TipoServicio_id = tiposervicio.id',
			'estadoservicio'	=>	'servicios.Estado_id = estadoservicio.id',
			'personal'	=>	'servicios.socio = personal.id',
			'moneda'	=>	'servicios.moneda_id = moneda.id',
			'compania'	=>	'servicios.Compania_id = compania.id',
			'grupo'		=>	'cliente.Grupo_id = grupo.id',
			'industria'		=>	'cliente.Industria_id = industria.id'			
		);
		$this->primary_key = 'servicios.id';
	}

    public function get($params = NULL) {
        $servicio = parent::get($params);
        return $servicio;
    }

    public function get_active($params = NULL) {
        if (!$params) {
            $params = array(
                'where'	=>	array(
                    'servicios.Estado_id >'	=>	1,
                    'servicios.Estado_id <'	=>	6
                )
            );
        }else {
            $params['where']['Estado_id'] = 1;
        }
        return $this->get($params);
    }

    function dameClienteDeServicio($servicio_id, $fields='cliente.*'){
    	return $this->db->query("SELECT $fields FROM servicios
    		INNER JOIN cliente ON servicios.Cliente_id=cliente.id
    		WHERE servicios.id=".$servicio_id)->row();
    }

}

?>