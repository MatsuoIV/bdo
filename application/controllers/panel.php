<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Panel extends BDO_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper(array('text', 'bdo_app'));
	}


	function index($params = '-') {
	
		//Codificar o no las url (para realizar debugging)
		$encripcion = TRUE;

		if(count($_POST)){
			$fecha = $this->input->post('fecha');
			$fecha = explode('/', $fecha);
			if(isset($fecha[1], $fecha[2])){
				$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
			} else{
				$fecha = ''; 
			}

			$params = array(
				'fecha' => $fecha,
				'order_by' => NULL,
				'order' => 'DESC'
			);
			redirect('panel/index/'.array_url_encode($params, $encripcion) );
		}

		if($params=='-'){
			$query = array(
				'fecha' => date('Y-m-d'),
				'order_by' => NULL,
				'order' => 'DESC'
			);
		} else {
			$query = array_url_decode($params, $encripcion);

			if(empty($query['fecha'])){ $query['fecha'] = date('Y-m-d'); }
			else{ $query['fecha'] = date('Y-m-d',strtotime($query['fecha'])); }

			if(!isset($query['order_by'])){ $query['order_by']=NULL; }
			elseif(!in_array($query['order_by'], array('fecha','denominacion','razonsocial','codigo','monto','saldo'))){
				$query['order_by']=NULL;
			}
			if(!isset($query['order'])){ $query['order']='DESC'; }
			elseif(!in_array($query['order'], array('ASC','DESC') )){ $query['order']='DESC'; }

		}

		$data = array();
		$data['encripcion'] = $encripcion;
		$data['query'] = $query;
		$data['params'] = $params;

		//	$data['open_invoices'] = $this->mdl_invoices->get_recent_open();
		//	$data['pending_invoices'] = $this->mdl_invoices->get_recent_pending();
		//	$data['closed_invoices'] = $this->mdl_invoices->get_recent_closed();
		//	$data['overdue_invoices'] = $this->mdl_invoices->get_recent_overdue();
		//	$data['prueba'] = "Prueba";
		//	$data['usuario'] = $this->ion_auth->get_user()->username;
		
		

		$this->load->model('cuotas_mdl');
		$data['cuotas_pendientes'] = $this->cuotas_mdl->dameCuotasPendientes($query['fecha'], $query['order_by'], $query['order'] );

		$this->load->view('panel/panel', $data);
	}    
}

?>