<table style="width: 100%;">
    <tr>
		<?php if (isset($sort_links) AND $sort_links == TRUE) { ?>
<th scope="col" class="first"><?php echo anchor('facturas/index/order_by/factura_id', 'ID'); ?></th>
<th scope="col"><?php echo anchor('facturas/index/order_by/factura_estado', 'Estado'); ?></th>
<th scope="col"><?php echo anchor('facturas/index/order_by/factura', 'Factura'); ?></th>
<th scope="col"><?php echo anchor('facturas/index/order_by/factura_fecha', 'Fecha'); ?></th>
<th scope="col"><?php echo anchor('facturas/index/order_by/servicio_codigo', 'Codigo'); ?></th>
<th scope="col"><?php echo anchor('facturas/index/order_by/cliente_razonsocial', 'Cliente'); ?></th>
<th scope="col"><?php echo anchor('facturas/index/order_by/factura_montos_total', 'Monto'); ?></th>

<th scope="col" class="last">Acciones</th>
		<?php } else { ?>
			<th scope="col" class="first">ID</th>
			<th scope="col">Estado</th>
			<th scope="col">Factura</th>
			<th scope="col">Fecha</th>
			<!--<th scope="col">Codigo</th>-->
			<th scope="col">Cliente</th>            
			<th scope="col">Monto</th>                        
			<th scope="col" class="last">Acciones</th>
		<?php } ?>
	</tr>

	<?php 

	$i=1;
	foreach ($facturas as $factura) { ?>
	<tr>
		<td class="first"><span title="<?php echo $factura->factura_id; ?>"><?=$i++?></span></td>
		<td><?php echo $factura->factura_estado_denominacion; ?></td>
		<td><?php echo $factura->tipocomprobante_codigo.".".$factura->factura_grupo_prefijo.".".$factura->factura_numero; ?></td>
		<td><?php echo formato_fecha($factura->factura_fecha_ingreso); ?></td>
		<!--<td><?php echo $factura->servicio_codigo; ?></td>-->
		<td><?php echo anchor('clientes/details/cliente_id/'.$factura->cliente_id,$factura->cliente_razonsocial_fact); ?></td>
		<td><?php echo $factura->moneda_simbolo." ".formato_numero($factura->factura_montos_total); ?></td>
		<td class="last">
			<a href="<?php echo site_url('facturas/edit/factura_id/'.$factura->factura_id); ?>" title="Editar">
				<?php echo icon('edit'); ?>
			</a>    
			<a href="<?php echo site_url('facturas/view/factura_id/'.$factura->factura_id); ?>" title="Ver detalle">
				<?php echo icon('zoom'); ?>
			</a>
			<a class="confirmar"  href="<?php echo site_url('facturas/delete/factura_id/'.$factura->factura_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" >
				<?php echo icon('delete'); ?>
			</a>
		</td>
	</tr>
	<?php } ?>
</table>

<?php if ($this->facturas_mdl->page_links) { ?>
<div id="pagination">
<?php echo $this->facturas_mdl->page_links; ?>
</div>
<?php } ?>