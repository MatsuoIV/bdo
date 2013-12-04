<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Clientes extends BDO_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('clientes_mdl');
	}

	function index() {
		$this->load->helper(array('text', 'bdo_app'));

		if(count($_POST)){
			$anio = (int) $this->input->post('campania');
			redirect('/clientes/index/anio/'.$anio);
		}

		$anio = uri_assoc('anio');
		if(!empty($anio)){
			$servicios_where = 'AND SUBSTRING(s.codigo,6,4)='.((int)$anio);
		} else {
			$servicios_where = '';
		}

		$this->redir->set_last_index();
		$parametros= array(
			'select' => 'SQL_CALC_FOUND_ROWS
		cliente.*,
		cliente.Grupo_id as join_cliente_id,
		cliente.Industria_id as join_industria_id,
		(SELECT SUM(monto_total) FROM factura WHERE cliente_id=cliente.id AND moneda_id=1 GROUP BY cliente_id) AS balance_cliente_soles,
		(SELECT SUM(monto_total) FROM factura WHERE cliente_id=cliente.id AND moneda_id=2 GROUP BY cliente_id) AS balance_cliente_dolares,
		(SELECT denominacion FROM grupo WHERE id = join_cliente_id) AS cliente_grupo,
		(SELECT codigo FROM industria WHERE id = join_industria_id) AS cliente_industria,
		(SELECT COUNT(*) FROM servicios AS s WHERE s.Cliente_id=cliente.id '.$servicios_where.') AS conteo_servicios',
			'having' => 'conteo_servicios > 1',
			'paginate'	=>	TRUE,
			'limit'		=>	15,
			'page'		=>	uri_assoc('page'),
			'order_by'  =>	'cliente_grupo, razonsocial'
		);

		$data = array(
			'clientes'	=> $this->clientes_mdl->get($parametros),
			'anio' => $anio
		);

		//$this->output->enable_profiler();
		$this->load->view('clientes_listado', $data);
	}
	

	function detalle() {
		$this->load->helper(array('text', 'bdo_app'));
		$this->redir->set_last_index();
        $this->load->helper('text');
		$this->load->model(
		array(
			'servicios_mdl',		
			'facturas_mdl',
			'cuotas_mdl',
			'clientes_mdl'		
			)
		);

		$servicio_id = uri_assoc('servicio_id');

		$servicio_params = array(
			'where'	=>	array(
				'servicios.id' => $servicio_id
			)
		);

		$servicio = $this->servicios_mdl->get($servicio_params);
		//terrible place to store the method
		$servicio->balance = $this->clientes_mdl->dameBalanceServicio($servicio_id);

		$cuotas = $this->cuotas_mdl->dameCuotasDeServicio($servicio_id);

		$facturas = $this->facturas_mdl->dameFacturasDeServicio($servicio_id);

		$tab_index = 0;

		$data = array(
			'servicio'	=>	$servicio,
			'facturas'	=>	$facturas,
			'cuotas'	=>	$cuotas,			
			'tab_index'	=>	$tab_index
		);
		$this->load->view('servicioview', $data);
	}

}
?>