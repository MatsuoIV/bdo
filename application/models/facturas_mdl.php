<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Facturas_mdl extends MY_Model {

    /*
    public function __construct() {
        parent::__construct();
        $this->table_name = 'factura';
        $this->primary_key = 'factura.factura_id';
        //$this->order_by = 'factura.factura_fecha_ingreso DESC, factura.factura_id DESC';
        $this->order_by = 'factura.fecha_registro DESC, factura.id DESC';
        $this->select_fields = 
            "SQL_CALC_FOUND_ROWS
    		factura.*,
    		cliente.*,
            cliente.id as cliente_id,
    		moneda.simbolo as moneda_simbolo,
    		users.username,
    		tipocomprobante.codigo as tipocomprobante_codigo,
    		factura_estado.*";	

        $this->joins = array(
            'factura_estado' => array(
                //'factura_estado.factura_estado_id = factura.factura_estado_id',
                'factura_estado.id = factura.factura_estado_id',
                'left'
            ),
            'users' => array(
                'users.id= factura.personal_id',
                'left'
            ),			
            'cliente' => array(
                'cliente.id = factura.cliente_id',
                'left'
            ),
            //'cliente' => 'servicios.Cliente_id = cliente.id',
			'factura_grupo'	=>	'factura.factura_grupo_id = factura_grupo.id',
			'tipocomprobante'	=>	'factura.tipocomprobante_id = tipocomprobante.id',
			'moneda'	=>	'factura.moneda_id= moneda.id'	
        );
    }
    */

    public function __construct() {
        parent::__construct();
        $this->table_name = 'factura';
        //$this->primary_key = 'factura.id';
        $this->primary_key = 'factura.factura_id';
        //$this->order_by = 'factura.factura_fecha_ingreso DESC, factura.factura_id DESC';
        $this->order_by = 'factura.fecha_registro DESC, factura.id DESC';
        $this->select_fields = 
            "SQL_CALC_FOUND_ROWS
            factura.id as factura_id,
            cliente.id as cliente_id,
            factura.numero as factura_numero,
            factura.factura_grupo_id as factura_grupo_prefijo,
            factura_estado.denominacion as factura_estado_denominacion,
            factura.fecha_registro as factura_fecha_ingreso,

            tipocomprobante.codigo as tipocomprobante_codigo,
            cliente.razonsocial as cliente_razonsocial_fact,
            moneda.simbolo as moneda_simbolo,
            factura.monto_total as factura_montos_total
            ";

        $this->joins = array(
            'factura_estado' => array(
                //'factura_estado.factura_estado_id = factura.factura_estado_id',
                'factura_estado.id = factura.factura_estado_id',
                'left'
            ),
            'users' => array(
                'users.id= factura.personal_id',
                'left'
            ),          
            'cliente' => array(
                'cliente.id = factura.cliente_id',
                'left'
            ),
            //'cliente'=> array(
            //    'servicios.Cliente_id = cliente.id',
            //    'left'
            //),
            'factura_grupo'=> array(
                'factura.factura_grupo_id = factura_grupo.id',
                'left'
            ),
            'tipocomprobante' => array(
                'factura.tipocomprobante_id = tipocomprobante.id',
                'left'
            ),
            'moneda' => 'factura.moneda_id= moneda.id',
        );
    }    

    public function dameFacturasDeServicio($servicio_id){
        $r = $this->db->query("SELECT DISTINCT(factura_id) FROM cuota_factura
                INNER JOIN cuota ON cuota_factura.cuota_id=cuota.id
                WHERE cuota.servicio_id=".((int) $servicio_id))->result_array();
        $facturas_id = array();
        foreach($r as $row){
            $facturas_id[] = $row->factura_id;
        }

        if(count($facturas_id)){
            return $this->db->query("SELECT factura.*, factura_grupo.nombre AS factura_grupo_nombre, 
                cliente.razonsocial_fact AS cliente_razonsocial_fact, moneda.simbolo AS moneda_simbolo, 
                tipocomprobante.codigo as tipocomprobante_codigo, factura_estado.denominacion AS factura_estado_denominacion
                FROM factura
                LEFT JOIN cliente ON factura.cliente_id=cliente.id
                LEFT JOIN factura_grupo ON factura.factura_grupo_id = factura_grupo.factura_grupo_id
                LEFT JOIN factura_estado ON factura_estado.factura_estado_id = factura.factura_estado_id
                LEFT JOIN tipocomprobante ON factura.tipocomprobante_id = tipocomprobante.id
                LEFT JOIN moneda ON factura.moneda_id= moneda.id
                WHERE factura.id IN(".implode(',', $facturas_id ).")")->result();
        }
        return array();
    }

    public function validate_create() {
        $this->form_validation->set_rules('factura_fecha_ingreso', 'Fecha de la factura', 'required');
        $this->form_validation->set_rules('servicio_id', 'Codigo de servicio', 'required');
        $this->form_validation->set_rules('factura_grupo_id', 'Grupo de facturas', 'required');
        return parent::validate();
    }



    public function get($params = NULL) {
        $facturas = parent::get($params);
        if (is_array($facturas)) {
            foreach ($facturas as $factura) {
                $factura = $this->set_factura_adicional($factura, $params);
            }
        }else {
            $facturas = $this->set_factura_adicional($facturas, $params);
        }
        return $facturas;
    }


    public function get_recien_abiertas($limit = 10) {
        $params = array(
            'limit'	=>	10,
            'where'	=>	array(
                'factura_estado_id'	=>	1
            )
        );
        return $this->get($params);
    }


    public function save($servicio_id, $factura_fecha_ingreso, $strtotime = TRUE) {
        if ($strtotime) {
            $factura_fecha_ingreso = strtotime(standardize_date($factura_fecha_ingreso));
        }
        $db_array = array(
            'servicio_id'				=>	$servicio_id,
            'factura_fecha_ingreso'		=>	$factura_fecha_ingreso,
            'personal_id'				=>	$this->session->userdata('id'),
            'factura_estado_id'			=>	1,		
        );

        $this->db->insert($this->table_name, $db_array);
        $factura_id = $this->db->insert_id();

		$impuesto_id_defecto = 1;
        $db_array2 = array(
            'factura_id'        =>	$factura_id,
            'impuesto_id'       =>	$impuesto_id_defecto
        );

        $this->db->insert('factura_impuesto', $db_array2);
		
        $this->save_factura_log($factura_id, $this->session->userdata('id'), 'Factura creada.');
        return $factura_id;
    }
	

    public function save_factura_log($factura_id, $user_id, $factura_log_data) {
            $db_array = array(
                'factura_id'			=>	$factura_id,
                'personal_id'				=>	$user_id,
                'factura_log_fecha'	=>	time(),
                'factura_log_data'	=>	$factura_log_data
            );

            $this->db->insert('factura_log', $db_array);
    }



    public function set_factura_adicional($factura, $params = NULL) {
        if (isset($params['get_factura_pagos'])) {
            $factura->factura_pagos = $this->get_factura_pagos($factura->factura_id);
        }
        return $factura;
    }	

    public function get_factura_pagos($factura_id) {
        $this->load->model('pagos_mdl');
        $params = array(
            'where'	=>	array(
                'pago.factura_id'	=>	$factura_id
            )
        );
        return $this->pagos_mdl->get($params);
    }	
	

    public function get_factura_logs($factura_id) {
        $this->load->model('factura_logs_mdl');
        $params = array(
            'where'	=>	array(
                'factura_log.factura_id'	=>	$factura_id
            )
        );
        return $this->factura_logs_mdl->get($params);
    }


    public function get_factura_impuestos($factura_id) {
        $this->load->model('impuestos_mdl');
        return $this->impuestos_mdl->get_factura_impuestos($factura_id);
    }



    public function set_factura_descuento($factura_id, $factura_descuento) {
        $this->db->where('factura_id', $factura_id);
        $this->db->set('factura_descuento', $factura_descuento);
        $this->db->update('factura_montos');
        $this->factura_montos_mdl->ajuste($factura_id);
    }
		
	
   
}

?>