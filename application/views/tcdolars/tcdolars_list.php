<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Items de tipo de cambio <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first">ID</th>
					<th scope="col">Compra</th>
					<th scope="col">Venta</th>                    
					<th scope="col">Fecha</th>                    
					<th scope="col" class="last">Acciones</th>
				</tr>
				
				<?php $i=1; ?>                              
				<?php foreach ($tcdolars as $tcdolar) { ?>
				<tr>
					<td class="first"><span title="<?php echo $tcdolar->id; ?>"><?=$i++?></span></td>
                    <td><?php echo $tcdolar->compra; ?></td>
					<td><?php echo $tcdolar->venta; ?></td>
					<td><?php echo $tcdolar->fecha; ?></td>

					<td class="last">
						<a href="<?php echo site_url('tcdolars/edit/id/'.$tcdolar->id); ?>" title="Editar">
							<?php echo icon('edit'); ?>
						</a>                      
                        
						<a class="confirmar" href="<?php echo site_url('tcdolars/delete/id/'.$tcdolar->id); ?>" title="Eliminar" >
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->tcdolars_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->tcdolars_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>