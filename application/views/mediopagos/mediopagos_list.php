<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Medios de pago <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first">ID</th>
					<th scope="col">Nombre del mediopago</th>
					<th scope="col" class="last">Acciones</th>
				</tr>
				<?php $i=1; ?>                
				<?php foreach ($mediopagos as $mediopago) { ?>
				<tr>
					<td class="first"><span title="<?php echo $mediopago->id; ?>"><?=$i++?></span></td>
					<td><?php echo $mediopago->nombre; ?></td>
					<td class="last">
						<a href="<?php echo site_url('mediopagos/edit/mediopago_id/'.$mediopago->id); ?>" title="Editar">
							<?php echo icon('edit'); ?>
						</a>                      
                        
						<a class="confirmar" href="<?php echo site_url('mediopagos/delete/mediopago_id/'.$mediopago->id); ?>" title="Eliminar" >
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mediopagos_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mediopagos_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>