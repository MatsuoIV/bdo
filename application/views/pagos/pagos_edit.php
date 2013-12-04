<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>

<div class="container_10" id="center_wrapper">
	<div class="grid_7" id="content_wrapper">
		<div class="section_wrapper">
			<h3 class="title_black">Formulario de pagos</h3>         
				<?php $this->load->view('panel/mensajes_sistema'); ?>
			<div class="content toggle">
            
		<form method="post" action="<?=site_url($this->uri->uri_string()); ?>">
			<dl>
				<dt><label>Factura: </label></dt>
				<dd>
					<?php if (!uri_assoc('factura_id')) { ?>
                        <select name="factura_id" id="factura_id">
                            <option value="">Seleccione una factura</option>
                            <? foreach ($facturas as $factura) { ?>
                                <option value="<?=$factura->factura_id; ?>" <? if ($factura->factura_id == $this->pagos_mdl->form_value('factura_id')) { ?>selected="selected"<? } ?>><?=$factura->tipocomprobante_codigo.'.'.$factura->factura_grupo_prefijo.'.'.$factura->factura_numero.' ['.$factura->factura_montos_balance.'] de '.character_limiter($factura->razonsocial, 45)?></option>
                            <? } ?>
                        </select>
					<?php } else { ?>
						<?=$factura->tipocomprobante_codigo.'.'.$factura->factura_grupo_prefijo.'.'.$factura->factura_numero.' ['.$factura->factura_montos_balance.'] de '.character_limiter($factura->razonsocial, 45); ?>
					<?php } ?>
				</dd>
			</dl>

			<dl>
				<dt><label>Monto: </label></dt>
				<dd><input type="text" name="pago_monto" value="<?=formato_numero($this->pagos_mdl->form_value('pago_monto')); ?>" /></dd>
			</dl>

			<dl>
				<dt><label>Fecha: </label></dt>
				<dd><input type="text" name="pago_fecha" class="datepicker" value="<?=$this->pagos_mdl->form_value('pago_fecha'); ?>" /></dd>
			</dl>

			<dl>
				<dt><label>Medio de pago: </label></dt>
				<dd>
                    <select name="mediopago_id">
                        <option <? if (!$this->pagos_mdl->form_value('mediopago_id')) { ?>selected="selected"<? } ?>></option>  
                        <? foreach ($mediopagos as $mediopago) { ?>
                        <option value="<?=$mediopago->mediopago_id; ?>" <? if ($this->pagos_mdl->form_value('mediopago_id') == $mediopago->mediopago_id) { ?>selected="selected"<? } ?>><?=$mediopago->mediopago_nombre; ?></option>
                        <? } ?>
                    </select>
				</dd>
			</dl>

			<dl>
				<dt><label>Moneda: </label></dt>
				<dd>
                    <select name="moneda_id">
                        <option <? if (!$this->pagos_mdl->form_value('moneda_id')) { ?>selected="selected"<? } ?>></option>
                        <? foreach ($monedas as $moneda) { ?>
                        <option value="<?=$moneda->id; ?>" <? if ($this->pagos_mdl->form_value('moneda_id') == $moneda->id) { ?>selected="selected"<? } ?>><?=$moneda->denominacion; ?></option>
                        <? } ?>
                    </select>
				</dd>
			</dl>



			<dl>
				<dt><label>Banco: </label></dt>
				<dd>
                    <select name="banco_id">
                        <option <? if (!$this->pagos_mdl->form_value('banco_id')) { ?>selected="selected"<? } ?>></option>
                        <? foreach ($bancos as $banco) { ?>
                        <option value="<?=$banco->banco_id; ?>" <? if ($this->pagos_mdl->form_value('banco_id') == $banco->banco_id) { ?>selected="selected"<? } ?>><?=$banco->banco_nombre; ?></option>
                        <? } ?>
                    </select>
				</dd>
			</dl>

			<dl>
				<dt><label>Documento de referencia: </label></dt>
				<dd><input type="text" name="pago_documento" value="<?=$this->pagos_mdl->form_value('pago_documento'); ?>" /></dd>
			</dl>

			<dl>
				<dt><label>Observaciones: </label></dt>
				<dd><textarea name="pago_obs" rows="5" cols="40"><?=$this->pagos_mdl->form_value('pago_obs'); ?></textarea></dd>
			</dl>

			<input type="submit" id="btn_submit" name="btn_submit_single_payment" value="Ingresar Pago" />
			<input type="submit" id="btn_cancel" name="btn_cancel" value="Cancelar" />

		</div>

		</div>

	</div>
</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>