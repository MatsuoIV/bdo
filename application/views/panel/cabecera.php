<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=titulo_aplicacion()?></title>
    <link href="<?=base_url()?>assets/style/css/styles.css" rel="stylesheet" type="text/css" media="screen" />
    <link type="text/css" href="<?=base_url()?>assets/jquery/ui-themes/myclientbase1/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?=base_url()?>assets/jquery/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/jquery/jquery-ui-1.8.4.custom.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/livevalidation_standalone.compressed.js"></script>    
    <script src="<?=base_url()?>assets/jquery/jquery.maskedinput-1.2.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            if($('#navigation li.selected ul'))
            {
                $('#navigation li.selected ul').css('display', 'block');
            }

            $('#navigation li').hover(function() {
                $('#navigation li ul').css('display', 'none');
                $(this).find('ul').css('display', 'block');

            }, function() {
                $(this).find('ul').css('display', 'block');
            });
        });
    </script>
</head>

<body>
	<div id="header_wrapper">
		<div class="container_10" id="header_content"><h1><?=titulo_aplicacion()?></h1></div>
	</div>
	<div id="navigation_wrapper"> 
    
		<ul class="container_10" id="navigation">
			<li class="selected"><a href="<?=base_url()?>">Inicio</a></li>
			<li><a href="<?=base_url()?>index.php/clientes">Programación</a><ul>
                <li><a href="<?=base_url()?>index.php/clientes">Ver clientes</a></li>
                <li><a href="<?=base_url()?>index.php/cuotas">Ver cuotas</a></li>                
                <li><a href="<?=base_url()?>index.php/cuotas/report">Reportes de cuotas</a></li>
            </ul>
    </li>
	<li>
    <a href="<?=base_url()?>">Facturación</a><ul>
                <li><a href="<?=base_url()?>index.php/facturas">Ver facturas</a></li>
                <li><a href="<?=base_url()?>index.php/facturas/create">Crear factura</a></li>
                <li><a href="<?=base_url()?>index.php/facturas/search">Buscador de factura</a></li>
                <li><a href="<?=base_url()?>index.php/items">Items de factura</a></li>                
            </ul>
    </li>
	<li >
    <a href="<?=base_url()?>">Caja y Bancos</a><ul>
                <li><a href="<?=base_url()?>index.php/pagos">Ver pagos</a></li>
                <li><a href="<?=base_url()?>index.php/pagos/edit">Ingresar pagos</a></li>
                <li><a href="<?=base_url()?>index.php/bancos">Bancos</a></li>
                <li><a href="<?=base_url()?>index.php/mediopagos">Medio de pago</a></li>                                
            </ul>
    </li>
	<li >
    <a href="<?=base_url()?>">Configuracion</a>
    <ul>
            <li><a href="<?=base_url()?>index.php/impuestos">Tasas de impuesto</a></li>
            <li><a href="<?=base_url()?>index.php/factura_estados">Estado de factura</a></li>
            <li><a href="<?=base_url()?>index.php/factura_grupos">Grupos de factura</a></li>                
            <li><a href="<?=base_url()?>index.php/monedas">Tipo de moneda</a></li>                
            <li><a href="<?=base_url()?>index.php/tcdolars">Tipo de cambio</a></li>  
            <li><a href="<?=base_url()?>index.php/auth/change_password">Cambiar mi contraseña</a></li>  
            <li><a href="<?=base_url()?>index.php/auth/create_user">Crear usuario</a></li>                           
        </ul>
    </li>
    <li ><a href="<?=base_url()?>">Reportes</a></li> 
    <!-- <li>
       <a href="javascript:;">Enlaces</a>
        <ul>
            <li><?=anchor('clients/form', 'Nuevo Cliente')?></li>
            <li><?=anchor('invoices/create', 'Crear Factura')?></li>
            <li><?=anchor('payments/form', 'Ingresar Pago')?></li>
            <li><?=anchor('invoice_search', 'Buscador de facturas')?></li>
            <?php //if ($this->session->userdata('global_admin')) { ?>
                <li class="last"><?=anchor('settings', 'Configuracion del Sistema')?></li>
            <?php // } ?>
        </ul>
    </li>    -->
	<li ><a href="<?=base_url()?>index.php/auth/logout">Salir</a></li>
</ul>
</div>

<div class="container_10" id="center_wrapper">