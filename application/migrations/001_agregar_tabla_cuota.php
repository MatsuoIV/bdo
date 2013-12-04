<?php

class Migration_Agregar_tabla_cuota extends CI_Migration{

	function up(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `cuota` (
			 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			 `monto` decimal(10,2) NOT NULL,
			 `fecha` date NOT NULL,
			 `saldo` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
			 `moneda_id` int(10) unsigned NOT NULL,
			 `servicios_id` int(10) unsigned NOT NULL,
			 PRIMARY KEY (`cuota_id`),
			 KEY `servicios_id` (`servicios_id`),
			 KEY `moneda_id` (`moneda_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}

	function down(){
		$this->db->query("DROP TABLE IF EXISTS cuota");
	}

}