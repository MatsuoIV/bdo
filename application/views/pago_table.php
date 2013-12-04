<table style="width: 100%;">
	<tr>
		<th scope="col" class="first">ID</th>
		<th scope="col">Factura</th>
		<th scope="col">Fecha</th>
		<th scope="col">Medio de pago</th>        
		<th scope="col">Monto</th>              
		<th scope="col" class="last">Acciones</th>
	</tr>
    
	<?php foreach ($pagos as $pago) { ?>
	<tr>
		<td class="first"><?=$pago->pago_id?></td>
		<td><?=$pago->tipocomprobante_codigo?> <?=$pago->factura_numero?></td>
		<td><?=formato_fecha($pago->pago_fecha)?></td>
   		<td><?=$pago->mediopago_nombre?></td>        
   		<td><?=$pago->moneda_simbolo?> <?=$pago->pago_monto?></td>                

		<td class="last">
			<a href="<?=site_url('pago/detalle/pago_id/'.$pago->pago_id)?>" title="Ver Pago">
				<?=icon('zoom')?>
			</a>
			<a href="<?=site_url('pago/form/pago_id/'.$pago->pago_id)?>" title="Editar Pago">
				<?=icon('edit')?>
			</a>
			<a href="<?=site_url('pago/eliminar/pago_id/'.$pago->pago_id)?>" title="Eliminar Pago" onclick="javascript:if(!confirm('Seguro?')) return false">
				<?=icon('delete')?>
			</a>
		</td>
	</tr>
	<?php } ?>
    
    
    
</table>