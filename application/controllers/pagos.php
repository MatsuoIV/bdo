<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Pagos extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('pagos_mdl');
		$this->load->helper(array('text', 'bdo_app'));		
	}

	function index() {
		$this->redir->set_last_index();
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	10,
			'page'		=>	uri_assoc('page')
		);
		
        $orden = uri_assoc('order_by');
        switch ($orden) {
            case 'pago_id':
                $params['order_by'] = 'pago.pago_id DESC';
                break;
            case 'pago_fecha':
                $params['order_by'] = 'pago_fecha DESC';
                break;
            case 'factura':
                $params['order_by'] = 'pago.factura_id';
                break;
            case 'cliente':
                $params['order_by'] = 'cliente.razonsocial ASC';
                break;
            case 'mediopago':
                $params['order_by'] = 'mediopago.mediopago_nombre ASC';
                break;				
            case 'pago_monto':
                $params['order_by'] = 'pago_monto DESC';
                break;
            default:
                $params['order_by'] = 'pago_fecha DESC';
        }		
	
        $data = array(
            'pagos'		=>  $this->pagos_mdl->get($params),
            'sort_links'	=>	TRUE);			
			
		$this->load->view('pagos/pagos_list', $data);
	
    }
	
	function view() {
		$this->pagos_mdl->prep_validation(uri_assoc('pago_id'));
		$this->load->view('pagos/pagos_view');
	}

    function edit() {
        $this->load->model('facturas_mdl');
		$this->load->model('mediopagos_mdl');
		$this->load->model('monedas_mdl');		
		$this->load->model('bancos_mdl');				
		
        $pago_id = uri_assoc('pago_id');
        $factura_id = uri_assoc('factura_id');
        if (!$this->pagos_mdl->validate()) {
            $data = array(
                'mediopagos'	=>	$this->mediopagos_mdl->get(),
                'monedas'	=>	$this->monedas_mdl->get(),
                'bancos'	=>	$this->bancos_mdl->get()								
            );
            if (!$_POST) {
                if ($pago_id) {
                    $this->pagos_mdl->prep_validation($pago_id);
                }else {
                    $this->pagos_mdl->set_date();
                }
            }
            if ($factura_id) {
                $params = array(
                    'select'	=>	'*',
                    'where'	=>	array(
                        'factura.factura_id'	=>	$factura_id
                    )
                );
                $data['factura'] = $this->facturas_mdl->get($params);
                $this->load->view('pagos/pagos_edit', $data);
            }else {
                $params = array(
                    'where'	=>	array(
                        'factura_montos_balance >'	=>	0
                    )
                );
                $facturas = $this->facturas_mdl->get($params);
                if ($facturas) {
                    $data['facturas'] = $facturas;
                    $this->load->view('pagos/pagos_edit', $data);
                }else {
                    $this->load->view('pagos/form_no_facturas');
                }
            }
        }else {
            $this->pagos_mdl->save();
            $this->load->model('factura_montos_mdl');
            if ($factura_id) {
                $this->factura_montos_mdl->ajuste($factura_id);
            }elseif ($this->input->post('factura_id')) {
                $this->factura_montos_mdl->ajuste($this->input->post('factura_id'));
            }
            $this->session->set_flashdata('tab_index', 2);
            $this->redir->redirect(array('pagos', 'facturas'));
        }
    }

	function delete() {
		if (uri_assoc('pago_id')) {
			$this->pagos_mdl->delete(array('pago_id'=>uri_assoc('pago_id')));
		}
		$this->redir->redirect('pagos');
	}

	function _post_handler() {
		if ($this->input->post('btn_add')) {
			redirect('pagos/edit');
		}elseif ($this->input->post('btn_cancel')) {
			redirect('pagos/index');
		}elseif ($this->input->post('btn_back')) {
			redirect('pagos/index');
		}		
	}
}

?>