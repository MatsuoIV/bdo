<?php $this->load->view('panel/cabecera')?>

<script type="text/javascript">
	$(function(){
		$('#tabs').tabs({ selected: <?=$tab_index?> });
	});
</script>

<div class="container_10" id="center_wrapper">
	<div class="grid_10" id="content_wrapper">
		<div class="section_wrapper">

<h3 class="title_black">


Servicio: <?=$servicio->servicio_codigo?>
<form method="post" action="<?=site_url($this->uri->uri_string())?>" style="display: inline;">
<!--<input type="submit" name="btn_add_contact" style="float: right; margin-top: 10px; margin-right: 10px;" value="Agregar XX" />
<input type="submit" name="btn_edit_client" style="float: right; margin-top: 10px; margin-right: 10px;" value="Agregar YY" />
-->
</form>
</h3>

<div class="content toggle">
    <div id="tabs">
        <ul>
            <li><a href="#tab_servicio">Servicio</a></li>
            <li><a href="#tab_cuotas">Cuotas</a></li>
            <li><a href="#tab_facturas">Facturas</a></li>
        </ul>

        <div id="tab_servicio">
            <div class="left_box">
                <dl><h4>Datos del Servicio</h4></dl>            
                <dl>
                    <dt>Codigo de servicio: </dt>
                    <dd><?php echo $servicio->servicio_codigo?></dd>
                </dl>
                <dl>
                    <dt>Compania BDO: </dt>
                    <dd><?=$servicio->compania_razonsocial?></dd>
                </dl>
                <dl>
                    <dt>Tipo de servicio: </dt>
                    <dd><?=$servicio->servicio_tipo?></dd>
                </dl>
                <dl>
                    <dt>Estado: </dt>
                    <dd><?=$servicio->servicio_estado_denominacion?></dd>
                </dl>
                <dl>
                    <dt>Socio a cargo: </dt>
                    <dd><?=$servicio->responsable?></dd>
                </dl>
                <dl>
                    <dt>Usuario de creacion: </dt>
                    <dd><?=$servicio->servicio_creador?>, el <?=formato_hora(strtotime($servicio->servicio_fecha_registro))?></dd>
                </dl>
                <dl><h4>Datos del Cliente</h4></dl>
                <dl>
                    <dt>Cliente: </dt>
                    <dd><?=$servicio->cliente_razonsocial?></dd>
				</dl>
                <dl>
                    <dt>Razon social de facturaci&oacute;n</dt>
                    <dd><?=$servicio->cliente_razonsocial_fact?></dd>
                </dl>
                <dl>
                    <dt>RUC del cliente: </dt>
                    <dd><?=$servicio->cliente_ruc?></dd>
                </dl>
                <dl>
                    <dt>Domicilio Fiscal: </dt>
                    <dd><?=$servicio->cliente_domicilio?></dd>
                </dl>
                <dl>
                    <dt>Grupo de empresas: </dt>
                    <dd><?=$servicio->grupo_denominacion?></dd>
                </dl>                
                <dl>
                    <dt>Tipo de Industria: </dt>
                    <dd><?=$servicio->industria_denominacion?></dd>
				</dl>                
            </div>

            <div class="right_box">
                <dl><h4>Resumen de honorarios:</h4></dl>           
                <dl>
                    <dt>Honorario Aceptado: </dt>
					<dd><?php echo $servicio->moneda_simbolo,' ',number_format($servicio->haceptado, 2)?></dd>
                </dl>
                <dl>
                    <dt>Honorario Facturado: </dt>
                    <dd><?php echo $servicio->moneda_simbolo,' ',$servicio->balance?></dd>
                </dl>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>

        <div id="tab_cuotas">
            <?php $this->load->view('cuota_table', array('cuotas'=>$cuotas, 'moneda_simbolo'=>$servicio->moneda_simbolo))?>
        </div>
        <div id="tab_facturas">
            <?php $this->load->view('factura_table', array('facturas'=>$facturas))?>
        </div>

    </div>
</div>

</div>
</div>
</div>
<?php $this->load->view('panel/pie')?>