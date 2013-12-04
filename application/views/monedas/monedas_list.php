<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Items de tipo de moneda <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first">ID</th>
					<th scope="col">Codigo</th>
					<th scope="col">Simbolo</th>                    
					<th scope="col">Denominacion</th>                    
					<th scope="col" class="last">Acciones</th>
				</tr>
				
				<?php $i=1; ?>                              
				<?php foreach ($monedas as $moneda) { ?>
				<tr>
					<td class="first"><span title="<?php echo $moneda->id; ?>"><?=$i++?></span></td>
                    <td><?php echo $moneda->codigo; ?></td>
					<td><?php echo $moneda->simbolo; ?></td>
					<td><?php echo $moneda->denominacion; ?></td>

					<td class="last">
						<a href="<?php echo site_url('monedas/edit/id/'.$moneda->id); ?>" title="Editar">
							<?php echo icon('edit'); ?>
						</a>                      
                        
						<a class="confirmar" href="<?php echo site_url('monedas/delete/id/'.$moneda->id); ?>" title="Eliminar" >
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->monedas_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->monedas_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>