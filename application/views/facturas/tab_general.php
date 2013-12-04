<div class="left_box">

    <dl>
        <dt><label>Numero de factura: </label></dt>
        <dd><input type="text" name="factura_numero" value="<?php echo $factura->factura_numero; ?>" /></dd>
    </dl>

	<dl>
		<dt><label>Cliente y Servicio: </label></dt>
		<dd>
			<?php if ($factura->servicio_estado=4) { ?>
			<select name="servicio_id">
				<?php foreach ($servicios as $servicio) { ?>
				<option value="<?php echo $servicio->servicio; ?>" <?php if($factura->servicio_id == $servicio->servicio_id) { ?>selected="selected"<?php } ?>><?php echo character_limiter($servicio->servicio_codigo, 25); ?></option>
					<?php } ?>
			</select>
			<?php } else { ?>
			<?php echo $factura->razonsocial; ?>
			<?php } ?>
		</dd>
	</dl>

	<dl>
		<dt><label>Usuario: </label></dt>
		<dd>
			<?php echo $factura->username; ?>
        </dd>
	</dl>

	<dl>
		<dt><label>Estado de la factura: </label></dt>
		<dd>
			<select name="factura_estado_id">
				<?php foreach ($factura_estados as $factura_estado) { ?>
				<option value="<?php echo $factura_estado->factura_estado_id; ?>" <?php if($factura_estado->factura_estado_id == $factura->factura_estado_id) { ?>selected="selected"<?php } ?>><?php echo $factura_estado->factura_estado_denominacion; ?></option>
				<?php } ?>
			</select>
		</dd>
	</dl>

	<dl>
		<dt><label>Fecha: </label></dt>
		<dd><input class="datepicker" type="text" name="factura_fecha_ingreso" value="<?php echo format_date($factura->factura_fecha_ingreso); ?>" /></dd>
	</dl>

<!--	<dl>
		<dt><label>Generar: </label></dt>
		<dd>
			<a href="javascript:void(0)" class="output_link" id="<?php echo $invoice->invoice_id . ':' . $invoice->client_id . ':' . $invoice->invoice_is_quote; ?>"><?php echo $this->lang->line('generate'); ?></a>
		</dd>
	</dl>-->

    <div style="clear: both;">&nbsp;</div>

	<input type="submit" id="btn_submit" name="btn_submit_options_general" value="Guardar" />

</div>

<div class="right_box">

	<dl>
		<dt><label>Subtotal: </label></dt>
		<dd><?php echo invoice_item_subtotal($invoice); ?></dd>
	</dl>

	<dl>
		<dt><label>Impuestos: </label></dt>
		<dd><?php echo invoice_tax_total($invoice); ?></dd>
	</dl>

	<?php if ($invoice->invoice_discount > 0) { ?>
	<dl>
		<dt><label>Descuentos: </label></dt>
		<dd><?php echo invoice_discount($invoice); ?></dd>
	</dl>
	<?php } ?>

	<dl>
		<dt><label>Gran Total: </label></dt>
		<dd><?php echo invoice_total($invoice); ?></dd>
	</dl>

	<?php if (!$invoice->invoice_is_quote) { ?>
	<dl>
		<dt><label>Pagado: </label></dt>
		<dd><?php echo invoice_paid($invoice); ?></dd>
	</dl>

	<dl>
		<dt><label>Balance: </label></dt>
		<dd><?php echo invoice_balance($invoice); ?></dd>
	</dl>
	<?php } ?>

</div>

<div style="clear: both;">&nbsp;</div>