<?php

class Companias_mdl extends MY_Model{
	
	//Principio K.I.S.S.
	function dameCompanias($fields='*'){
		return $this->db->query("SELECT $fields FROM compania")->result();
	}

}