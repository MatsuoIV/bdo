<?php $this->load->view('panel/cabecera'); ?>


<div class="container_10" id="center_wrapper">
	<div class="grid_7" id="content_wrapper">
		<div class="section_wrapper">
			<h3 class="title_black">Formulario de Items de grupo de factura</h3>
            			<?php $this->load->view('panel/mensajes_sistema'); ?>

			<div class="content toggle">
				<?=form_open(site_url($this->uri->uri_string()))?>
				<dl>                
					<dt><label>Compania: </label></dt>
						<dd><?=form_dropdown('Compania_id', $this->factura_grupos_mdl->companias, $this->factura_grupos_mdl->form_value('Compania_id'))?></dd>
				</dl>

				<dl>
					<dt><label>Nombre del grupo: </label></dt>
					<dd><?=form_input('nombre', $this->factura_grupos_mdl->form_value('nombre'))?></dd>
				</dl>
                                
				<dl>
					<dt><label>Prefijo del grupo: </label></dt>
					<dd><?=form_input('prefijo', $this->factura_grupos_mdl->form_value('prefijo'))?></dd>                    
				</dl>                

				<dl>
					<dt><label>Primer Correlativo: </label></dt>
					<dd><?=form_input('minimo', $this->factura_grupos_mdl->form_value('minimo'))?></dd>                        
				</dl>    
				
				<dl>
					<dt><label>Ultimo Correlativo: </label></dt>
					<dd><?=form_input('maximo', $this->factura_grupos_mdl->form_value('maximo'))?></dd>                        
				</dl> 
				
				<dl>
					<dt><label>Actual Correlativo: </label></dt>
					<dd><?=form_input('actual', $this->factura_grupos_mdl->form_value('actual'))?></dd>                        
				</dl> 
                
				<input type="submit" id="btn_submit" name="btn_submit" value="Guardar" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="Cancelar" />

				<?=form_close()?>

			</div>

		</div>

	</div>
</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>