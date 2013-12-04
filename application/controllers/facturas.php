<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Facturas extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('facturas_mdl');
		$this->load->helper(array('text', 'bdo_app', 'form'));
        $this->output->enable_profiler(); //Profiler
	}

    // GET /facturas

    function index() {
        $this->_post_handler();
        $this->redir->set_last_index();
        $orden = uri_assoc('order_by');
        $servicio_id = uri_assoc('servicio_id');
        $estado = uri_assoc('estado');
        $params = array(
            'paginate'		=>	TRUE,
            'limit'			=>	15,
            'page'			=>	uri_assoc('page'),
            'where'			=>	array()
        );
        if ($servicio_id) {
            $params['where']['factura.servicio_id'] = $servicio_id;
        }
        if ($estado) {
            $params['where']['factura_estado.factura_estado_id'] = $estado;
        }
        switch ($orden) {
            case 'factura_id':
                $params['order_by'] = 'factura.factura_id DESC';
                break;
            case 'factura':
                $params['order_by'] = 'factura.factura_numero DESC';
                break;
            case 'factura_estado':
                $params['order_by'] = 'factura_estado.factura_estado_denominacion ASC';
                break;
            case 'factura_fecha':
                $params['order_by'] = 'factura.factura_fecha_ingreso DESC';
                break;
            case 'servicio_codigo':
                $params['order_by'] = 'servicios.codigo ASC';
                break;
            case 'cliente_razonsocial':
                $params['order_by'] = 'cliente.razonsocial ASC';
                break;
            case 'factura_montos_total':
                $params['order_by'] = 'factura_montos.factura_montos_total DESC';
                break;
            default:
                $params['order_by'] = 'factura.fecha_registro DESC, factura.id DESC';
        }
        $facturas = $this->facturas_mdl->get($params);

        $data = array(
            'facturas'		=>	$facturas,
            'sort_links'	=>	FALSE, // NO ACTIVAR! No hay coherencia con los filtros.
        );
        $this->load->view('facturas/facturas_list', $data);
    }

    function cuotas_de_servicio($servicio_id=0){
        $this->output->enable_profiler(FALSE);
        $this->load->model('cuotas_mdl');
        $data = array();
        $data['cuotas'] = $this->cuotas_mdl->dameCuotasDeServicio($servicio_id, 'c.id, c.fecha, c.monto, c.saldo, s.codigo', 'AND c.saldo > 0');
        //echo $data['cuotas'];return;
        echo json_encode($data);
    }

    function cuota_especifica($servicio_id = 0, $cuota_id = 0){
        $this->output->enable_profiler(FALSE);
        $this->load->model('cuotas_mdl');
        $data = array();
        $data['cuotas'] = $this->cuotas_mdl->dameCuotasDeServicio($servicio_id, '*', 'AND c.id = '.$cuota_id);
        echo json_encode($data);
    }

    // GET /facturas/create
    function create(){

        $servicio_id = (int) uri_assoc('servicio_id');

        if(count($_POST)){
            if ($this->input->post('btn_cancel')) {
                redirect('facturas');
            }
        }

        $this->load->model(
            array(
                'clientes_mdl',
                'servicios_mdl',
                'monedas_mdl',
                'tipocomprobante_mdl',
                'companias_mdl',
                'factura_grupos_mdl'
            )
        );

        $data = array();

        include_once APPPATH.'libraries/EmptyObject.php';

        if($servicio_id){
            $cliente = $this->servicios_mdl->dameClienteDeServicio($servicio_id, 'cliente.razonsocial_fact');
        } else {
            $cliente = array('razonsocial_fact'=>'');
        }

        $data['cliente'] = $cliente;

        //TODO: agregar el tipo del cambio del dia a la página??

        $data['clientes'] = $this->clientes_mdl->get_clientes();
        $data['servicio_id'] = $servicio_id;
        $data['monedas'] = $this->monedas_mdl->get();
        $data['companias'] = $this->companias_mdl->dameCompanias('id,razonsocial');
        $data['factura_grupos'] = $this->factura_grupos_mdl->get();
        $data['servicios'] = $this->servicios_mdl->get_active();
        $data['tipos_comprobante'] = $this->tipocomprobante_mdl->dameTiposFactura();

        $this->load->view('facturas/editar_factura', $data);
    }

    // POST /facturas/save
    function save() {
        if (!count($_POST)) {
            redirect('facturas');
        }

        $this->load->helper('date');

        $this->form_validation->set_rules('factura_fecha_ingreso', 'Fecha de la factura', 'required');
        $this->form_validation->set_rules('compania_id', 'Codigo de Compañia', 'required');
        $this->form_validation->set_rules('factura_grupo_id', 'Grupo de facturas', 'required');
        $this->form_validation->set_rules('moneda_id', 'Codigo de servicio', 'required');
        $this->form_validation->set_rules('moneda_id', 'Codigo de servicio', 'required');

        if ($this->form_validation->run() == TRUE) {

            // Note: Faltan mas campos por guardar y generar montos.
            $data = array();
            $factura_fecha_ingreso = $this->input->post('factura_fecha_ingreso');

            $data['fecha_registro'] = date('Y-m-d H:i:s', strtotime($factura_fecha_ingreso));
            $data['fecha_emision'] = date('Y-m-d H:i:s', strtotime($factura_fecha_ingreso));
            // fecha_vencimiento ?
            // montos
            $data['factura_estado_id'] = 1; //factura_estado_id
            // item_id ?
            $data['factura_grupo_id'] = $this->input->post('factura_grupo_id');
            $data['tipocomprobante_id'] = 1; // Mira la tabla: tipocomprobante
            $data['personal_id'] = $this->session->userdata('id');
            $data['moneda_id'] = $this->input->post('moneda_id');
            $data['cliente_id'] = $this->input->post('compania_id');

            $change = $this->db->insert('factura', $data);
            $factura_id = $this->db->insert_id();

            if ($change) {
                $this->load->model('cuotas_mdl');

                $cuotas_array = $this->input->post('cuotas');

                $monto_subtotal = 0;

                foreach ($cuotas_array as $cuota_id) {
                    $couta = $this->db->get_where('cuota', array('id' => $cuota_id) )->row();

                    $data = array(
                        'factura_id'=> $factura_id,
                        'cuota_id'  => $couta->id,
                        'moneda_id' => $couta->moneda_id,
                        'monto'     => $couta->monto
                    );

                    $insert = $this->db->insert('cuota_factura', $data);
                    $monto_subtotal += $couta->monto;
                }

                $igv = $this->db->get_where('impuesto', array('nombre' => 'IGV') )->row();

                $monto_impuesto = $monto_subtotal * ($igv->porcentaje);
                $monto_total = $monto_subtotal + $monto_impuesto;

                $data = array(
                    'monto_subtotal' => $monto_subtotal,
                    'monto_impuesto' => $monto_impuesto,
                    // 'monto_pagado' => 0,
                    'monto_total' => $monto_total,
                );

                $update = $this->db->update('factura', $data, array('id' => $factura_id));

                $this->session->set_flashdata('success_save', "Información actualizada correctamente");

            } else {
                $this->session->set_flashdata('custom_warning', "Ocurrió un error al actualizar los datos ");
            }
            //redirect('facturas');

        } else {
            $this->session->set_flashdata('custom_error', "La Información no fue actualizada");
            //$this->load->view('facturas/editar_factura', $data);
        }
    }

    /*
    function create() {
        if ($this->input->post('btn_cancel')) {
            redirect('facturas');
        }

        $this->load->model(
            array(
                'servicios_mdl',
                'companias_mdl',
                'factura_grupos_mdl',
                'tipocomprobante_mdl'
            )
        );

        if (!$this->facturas_mdl->validate_create()) {

            if (uri_assoc('servicio_id') and !$_POST) {
                $this->facturas_mdl->set_form_value('servicio_id', uri_assoc('servicio_id'));
            }
            elseif (uri_assoc('servicio_id', 4) and !$_POST) {
                $this->facturas_mdl->set_form_value('servicio_id', uri_assoc('servicio_id', 4));
            }
            $this->load->helper('text');
            $data = array(
                'servicios'			=>	$this->servicios_mdl->get_active(),
                'factura_grupos'	=>	$this->factura_grupos_mdl->get(),
                'tipos_comprobante' => $this->tipocomprobante_mdl->dameTiposFactura()
            );
            $this->output->enable_profiler();
            $this->load->view('facturas/escoger_servicio', $data);
        }else {
            $this->load->model('factura_api');
		
            $package = array(
                'servicio_id'			=>	$this->input->post('servicio_id'),
                'factura_fecha_ingreso'	=>	$this->input->post('factura_fecha_ingreso'),
                'factura_grupo_id'		=>	$this->input->post('factura_grupo_id')
            );
            $factura_id = $this->factura_api->crear_factura($package);
            redirect('facturas/edit/factura_id/'.$factura_id);
        }
    }
    */

    function edit() {
        $tab_index = ($this->session->flashdata('tab_index')) ? $this->session->flashdata('tab_index') : 0;
        $this->_post_handler();
        $this->redir->set_last_index();
        $this->load->model(
            array(
                'servicios_mdl',
                'pagos_mdl',
                'impuestos_mdl',
                'factura_estados_mdl',
                'tipocomprobante_mdl'
            )
        );
        $this->load->helper('text');
        $params = array(
            'where'	=>	array(
                //'factura.factura_id'	=>	uri_assoc('factura_id')
                'factura.id'    =>  uri_assoc('factura_id')
            )
        );
        $factura= $this->facturas_mdl->get($params);      
		
        if (!$factura) {
	        $this->load->view('panel/registro_noencontrado');
			
        }
        $servicio_params = array(
            'select' =>  'servicios.id, servicios.codigo'
        );

        $data = array(
            'factura'		=>	$factura,
            'pagos'          =>  $this->facturas_mdl->get_factura_pagos(uri_assoc('factura_id')),
            'logs'           =>  $this->facturas_mdl->get_factura_logs(uri_assoc('factura_id')),
            'factura_impuestos' =>  $this->facturas_mdl->get_factura_impuestos(uri_assoc('factura_id')),
            'servicios'			=>	$this->servicios_mdl->get_active($servicio_params),
            'impuestos'			=>	$this->impuestos_mdl->get(),
            'factura_estados'	=>	$this->factura_estados_mdl->get(),
            'tab_index'			=>	$tab_index,
            'tipos_comprobante' => $this->tipocomprobante_mdl->dameTiposFactura()
        );
        $this->load->view('factura_edit', $data);
    } 	
	
	function seleccionar_servicio() {
        $data['accion'] = site_url('facturas/editar/');
		$data['factura_grupos'] = $this->facturas_mdl->get_grupo(NULL);
		
        if ($this->input->post('btn_cancel')) {
            redirect('facturas');
        }
		$this->load->view('facturas/seleccionar_servicio', $data);
	}
	

	function editar($servicio_id) {
		$this->load->model('servicios_mdl');			
		$this->load->model('pagos_mdl');			

		$data['accion'] = site_url('facturas/crear/');
		$data['factura_grupo'] = $this->facturas_mdl->get_grupo(1);

		$data['prueba'] = $this->input->post('factura_grupo_id');


		$usuario= $this->ion_auth->get_user();
		$data['usuario'] = $usuario->username;
		$data['factura_fecha'] = $this->input->post('factura_fecha');
		$data['factura_estados'] = $this->facturas_mdl->get_factura_estado(NULL);
		$data['impuestos'] = $this->facturas_mdl->get_impuesto(NULL);
		$data['items'] = $this->facturas_mdl->get_item(NULL);
		$data['historiales'] = $this->facturas_mdl->get_historial(NULL);
		$data['tab_index']	= 0;

		$pago_params = array('where' =>	array('factura.servicio_id'=>	$servicio_id));
		$servicio_params = array('where' =>	array('servicios.id'=>	$servicio_id));
		$data['servicio'] = $this->servicios_mdl->get($servicio_params);
		$data['pagos'] = $this->pagos_mdl->get($pago_params);



        if ($this->input->post('btn_cancel')) {
            redirect('facturas');
        }
		$this->load->view('facturas/factura_edit', $data);

	}

	
	// mostrar cuotas por servicio
	function por_servicio($servicio_id) {
        $data['accion_agregar'] = site_url('cuotas/agregar/');
		$this->load->model('servicios_mdl');

		$servicio_params = array('where' =>	array('servicios.id'=>	$servicio_id));

		$data['servicio'] = $this->servicios_mdl->get($servicio_params);
		$data['hprogramado'] = $this->cuotas_mdl->get_hprogramado($servicio_id);		
		$data['cuotas'] = $this->cuotas_mdl->get_cuotas($servicio_id);
		$data['monedas'] = $this->cuotas_mdl->get_monedas();		
		
		$this->load->view('cuotas_por_servicio',$data);
	}

	function eliminar($servicio_id,$cuota_id) {
		if($cuota_id) {
			$this->cuotas_mdl->eliminar($cuota_id);
		}
		$this->redir->redirect('cuotas/por_servicio/'.$servicio_id);	
	}	

	function agregar($servicio_id) {
		$cuota = array('servicios_id' => $servicio_id,
						'moneda_id' => $this->input->post('cuota_moneda'),
						'cuota_monto' => $this->input->post('cuota_monto'),						
						'cuota_fecha' => strtotime(standardize_date($this->input->post('cuota_fecha'))));								
		if($servicio_id) {
			$this->cuotas_mdl->agregar($cuota);
		}
		$this->redir->redirect('cuotas/por_servicio/'.$servicio_id);	
	}	

	function form() {
		if (!$this->cuotas_mdl->validate()) {
			$this->load->helper('form');
			if (!$_POST AND uri_assoc('cuota_id')) {
				$this->cuotas_mdl->prep_validation(uri_assoc('cuota_id'));
			}
			$this->load->view('form');
		}else {
			$this->cuotas_mdl->save($this->cuotas_mdl->db_array(), uri_assoc('cuota_id'));
			$this->redir->redirect('cuota_id');
		}
	}	
		
	//AJAX para funcion autocompletar
	function ajax(){
		if($buscar = $this->input->get('term')){
			$query= $this->cuotas_mdl->autocompletar($buscar);
			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$result[]= $row;
				}
			}
			echo json_encode($result);
		}
	}






    function _post_handler() {
        if ($this->input->post('btn_add_new_item')) {
            redirect('facturas/items/form/factura_id/' . uri_assoc('factura_id'));
        }
        elseif ($this->input->post('btn_add_payment')) {
            redirect('payments/form/factura_id/' . uri_assoc('factura_id'));
        }
        elseif ($this->input->post('btn_add')) {
            redirect('facturas/create');
        }
        elseif ($this->input->post('btn_add_quote')) {
            redirect('facturas/create/quote');
        }
        elseif ($this->input->post('btn_cancel')) {
            redirect('facturas/index');
        }
        elseif ($this->input->post('btn_submit_options_general') or $this->input->post('btn_submit_options_tax') or $this->input->post('btn_submit_notes')) {
            if ($this->input->post('btn_submit_options_general')) {
                $this->session->set_flashdata('tab_index', 0);
            }
            elseif ($this->input->post('btn_submit_options_tax')) {
                $this->session->set_flashdata('tab_index', 3);
            }
            elseif ($this->input->post('btn_submit_notes')) {
                $this->session->set_flashdata('tab_index', 4);
            }
            $this->mdl_facturas->save_factura_options($this->mdl_fields->get_object_fields(1));
            $this->load->model('mdl_factura_amounts');
            $this->mdl_factura_amounts->adjust(uri_assoc('factura_id'));
            redirect('facturas/edit/factura_id/' . uri_assoc('factura_id'));
        }
        elseif ($this->input->post('btn_quote_to_factura')) {
            redirect('facturas/quote_to_factura/factura_id/' . uri_assoc('factura_id'));
        }
    }

    // ANY /facturas/delete/factura_id/$factura_id
    function delete() {
        if (uri_assoc('factura_id')) {
            $factura_id = intval(uri_assoc('factura_id'));
            $this->facturas_mdl->delete( array('id'=> $factura_id) );
            $this->db->delete('cuota_factura', array('factura_id' => $factura_id) );
        }
        $this->redir->redirect('facturas');
    }

}

?>