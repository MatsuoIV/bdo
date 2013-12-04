<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class BDO_Controller extends CI_Controller {

    protected $usuario;
	
    public function __construct() {
        parent::__construct();
		$this->load->helper('url'); 		
        if(!$this->ion_auth->logged_in()) {
            if(!$this->input->is_ajax_request()){
                redirect('/auth/login');
            } else{
                exit('{"error":"No conectado"}');
            }
        } else{
            $data = new stdClass;
            $data->usuario = $this->ion_auth_model->user();
            $this->usuario = $data->usuario;
            $this->load->vars($data);	
		}
        $this->load->library(array('form_validation', 'redir'));
		
    }

}


?>
