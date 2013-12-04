<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Items de factura <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first">ID</th>
					<th scope="col">Nombre del item</th>
					<th scope="col">Descripcion</th>
					<th scope="col" class="last">Acciones</th>
				</tr>
				
				<?php $i=1; ?>                              
				<?php foreach ($items as $item) { ?>
				<tr>
					<td class="first"><span title="<?php echo $item->id; ?>"><?=$i++?></span></td>                    
					<td><?php echo $item->nombre; ?></td>
					<td><?php echo $item->descripcion; ?></td>
					<td class="last">
						<a href="<?php echo site_url('items/edit/item_id/'.$item->id); ?>" title="Editar">
							<?php echo icon('edit'); ?>
						</a>                      
                        
						<a class="confirmar" href="<?php echo site_url('items/delete/item_id/'.$item->id); ?>" title="Eliminar" >
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->items_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->items_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>