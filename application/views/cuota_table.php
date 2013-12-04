<table style="width: 100%;">
	<tr>
		<th scope="col" class="first">ID</th>
		<th scope="col">Fecha</th>        
		<th scope="col">Monto</th>
		<th scope="col">Saldo</th>
		<th scope="col" class="last">Acciones</th>
	</tr>
	<?php foreach ($cuotas as $cuota) { ?>
    <tr>
		<td class="first"><?php echo $cuota['id']?></td>
		<td nowrap="nowrap"><?php echo $cuota['fecha']?></td>
		<td><?php echo $moneda_simbolo,' ',$cuota['monto']?></td>
		<td><?php echo $moneda_simbolo,' ',$cuota['saldo']?></td>
		<td class="last">
			<a href="<?=site_url('cuotas/detalle/cuota_id/'.$cuota['id'])?>" title="Ver Factura">
				<?=icon('zoom')?>
			</a>
		</td>
	</tr>
	<?php } ?>
    
</table>