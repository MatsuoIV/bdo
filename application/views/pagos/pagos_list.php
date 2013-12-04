<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Pagos <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar pago")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">


<table style="width: 100%;">
    <tr>
		<?php if (isset($sort_links) AND $sort_links == TRUE) { ?>
			<th scope="col" class="first"><?php echo anchor('pagos/index/order_by/pago_id', 'ID'); ?></th>
			<th scope="col"><?php echo anchor('pagos/index/order_by/pago_fecha', 'Fecha'); ?></th>
			<th scope="col"><?php echo anchor('pagos/index/order_by/factura', 'Factura'); ?></th>
			<th scope="col"><?php echo anchor('pagos/index/order_by/cliente', 'Cliente'); ?></th>
			<th scope="col"><?php echo anchor('pagos/index/order_by/pago_monto', 'Monto'); ?></th>
			<th scope="col" class="last">Acciones</th>
		<?php } else { ?>
			<th scope="col" class="first">ID</th>
			<th scope="col">Fecha</th>
			<th scope="col">Factura</th>
			<th scope="col">Cliente</th>
			<th scope="col">Monto</th>            
			<th scope="col" class="last">Acciones</th>
		<?php } ?>
	</tr>
	<?php 
$i=1;
	foreach ($pagos as $pago) {
		if(!uri_assoc('pago_id') OR uri_assoc('pago_id') <> $pago->pago_id) { ?>
			<tr>
				<td class="first"><span title="<?php echo $pago->pago_id; ?>"><?=$i++?></span></td>
				<td><?php echo formato_fecha($pago->pago_fecha); ?></td>
				<td><?php echo anchor('clients/details/client_id/' . $pago->factura_id, $pago->tipocomprobante_codigo.".".$pago->factura_grupo_prefijo.".".$pago->factura_numero); ?></td>             
				<td><?php echo $pago->razonsocial; ?></td>                
				<td><?php echo $pago->simbolo.formato_numero($pago->pago_monto, true); ?></td>
				<td class="last">
					<a href="<?php echo site_url('pagos/edit/factura_id/'.$pago->factura_id.'/pago_id/'.$pago->pago_id); ?>" title="Editar">
						<?php echo icon('edit'); ?>
					</a>
                    
					<a href="<?php echo site_url('pagos/view/pago_id/'.$pago->pago_id); ?>" title="Ver detalle">
						<?php echo icon('zoom'); ?>
					</a>
                    
					<a class="confirmar"  href="<?php echo site_url('pagos/delete/factura_id/'.$pago->factura_id.'/pago_id/'.$pago->pago_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" >
						<?php echo icon('delete'); ?>
					</a>
				</td>
			</tr>
		<?php } ?>
	<?php } ?>

</table>








			<?php if ($this->pagos_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->pagos_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>