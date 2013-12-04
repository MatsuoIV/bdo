<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>


<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black">Grupos de factura <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar")); ?></h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first">ID</th>
					<th scope="col">Compania</th>
					<th scope="col">Nombre</th>
					<th scope="col">Prefijo</th>
					<th scope="col">Pr. Correlativo</th>
					<th scope="col">Ult. Correlativo</th>                   
					<th scope="col">Act. Correlativo</th>
					<th scope="col" class="last">Acciones</th>
				</tr>
                
				<?php $i=1; ?>                              				
				<?php foreach ($factura_grupos as $factura_grupo) { ?>
				<tr>
					<td class="first"><span title="<?php echo $factura_grupo->id; ?>"><?=$i++?></span></td>

					<td><?php echo $factura_grupo->codigo_compania; ?></td>
					<td><?php echo $factura_grupo->nombre; ?></td>
					<td><?php echo $factura_grupo->prefijo; ?></td>
					<td><?php echo $factura_grupo->minimo; ?></td>
					<td><?php echo $factura_grupo->maximo; ?></td>
					<td><?php echo $factura_grupo->actual; ?></td>

					<td class="last">
						<a href="<?php echo site_url('factura_grupos/edit/factura_grupo_id/'.$factura_grupo->id); ?>" title="Editar">
							<?php echo icon('edit'); ?>
						</a>                      
                        
						<a class="confirmar" href="<?php echo site_url('factura_grupos/delete/factura_grupo_id/'.$factura_grupo->id); ?>" title="Eliminar" >
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->factura_grupos_mdl->page_links) { ?>
			<div id="pagination">
				<?php echo $this->factura_grupos_mdl->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>