<?php $this->load->view('panel/cabecera'); ?>


<div class="container_10" id="center_wrapper">
	<div class="grid_7" id="content_wrapper">
		<div class="section_wrapper">
			<h3 class="title_black">Vista de pago</h3>

			<div class="content toggle">
<p><?php echo anchor('pagos/index', 'Volver al listado de pagos'); ?>

				<dl>
					<dt><label>ID del pago: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('pago_id')?></dd>
				</dl>
				<dl>
					<dt><label>Factura relacionada: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('tipocomprobante_codigo')?> <?=$this->pagos_mdl->form_value('factura_grupo_prefijo')?><?=$this->pagos_mdl->form_value('factura_numero')?></dd>
				</dl>
				<dl>
					<dt><label>Cliente: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('razonsocial')?> [<?=$this->pagos_mdl->form_value('servicio_codigo')?>]</dd>
				</dl>
				<dl>
					<dt><label>Monto del pago: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('simbolo')?> <?=formato_numero($this->pagos_mdl->form_value('pago_monto'))?></dd>
				</dl>
				<dl>
					<dt><label>Fecha del pago: </label></dt>
					<dd><?=formato_fecha($this->pagos_mdl->form_value('pago_fecha'))?></dd>
				</dl>
				<dl>
					<dt><label>Medio de pago: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('mediopago_nombre')?></dd>
				</dl>                       
				<dl>
					<dt><label>Documento de pago: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('pago_documento')?></dd>
				</dl>                       
				<dl>
					<dt><label>Banco: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('banco_nombre')?></dd>
				</dl>                       
				<dl>
					<dt><label>Observaciones: </label></dt>
					<dd><?=$this->pagos_mdl->form_value('pago_obs')?></dd>
				</dl>                                                                                                                

			</div>

		</div>

	</div>
</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>