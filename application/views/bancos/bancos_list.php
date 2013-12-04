<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Bancos <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first">ID</th>
					<th scope="col">Codigo</th>
					<th scope="col">Nombre del banco</th>
					<th scope="col">Tipo</th>
					<th scope="col" class="last">Acciones</th>
				</tr>
				<?php $i=1; ?>                
				<?php foreach ($bancos as $banco) { ?>
				<tr>
					<td class="first"><span title="<?php echo $banco->id; ?>"><?=$i++?></span></td>
					<td><?php echo $banco->codigo; ?></td>
					<td><?php echo $banco->nombre; ?></td>
					<td><?php echo $banco->tipo; ?></td>
					<td class="last">
						
						<a href=" //<?php echo site_url('cuentas/list_cuentas/banco_id'.$banco->id); ?> //" title="Ver cuentas">
							<?php echo icon('zoom'); ?>
						</a>
				
						<a href="<?php echo site_url('bancos/edit/banco_id/'.$banco->id); ?>" title="Editar">
							<?php echo icon('edit'); ?>
						</a>                      
                        
						<a class="confirmar" href="<?php echo site_url('bancos/delete/banco_id/'.$banco->id); ?>" title="Eliminar" >
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->bancos_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->bancos_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>