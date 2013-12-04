<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Cuotas extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('cuotas_mdl');
		$this->load->helper(array('text', 'bdo_app'));
	}

	// Seleccionar servicio
	function index() {
        $data['accion'] = site_url('cuotas/por_servicio/');
        if ($this->input->post('btn_cancel')) {
            redirect('clientes');
        }
		$this->load->view('cuotas/seleccionar_servicio', $data);
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
		
		$this->load->view('cuotas/cuotas_por_servicio',$data);
	}

	//reporte de cuotas: alertas
	function report(){
		$this->load->view('cuotas/cuotas_pendientes');
	}

	function eliminar($servicio_id,$cuota_id) {
		if($cuota_id) {
			$this->cuotas_mdl->eliminar($cuota_id);
		}
		$this->redir->redirect('cuotas/por_servicio/'.$servicio_id);	
	}	

	function agregar($servicio_id) {		
		$cuota = array('servicio_id' => $servicio_id,
						'moneda_id' => $this->input->post('cuota_moneda'),
						'monto' => $this->input->post('cuota_monto'),						
						'fecha' => date("Y-m-d",strtotime(standardize_date($this->input->post('cuota_fecha')))));
		if($servicio_id) {
			$this->cuotas_mdl->agregar($cuota);
		}
		$this->redir->redirect('cuotas/por_servicio/'.$servicio_id);	
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


}

?>