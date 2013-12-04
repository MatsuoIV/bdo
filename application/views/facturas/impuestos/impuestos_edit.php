<?php $this->load->view('panel/cabecera'); ?>


<div class="container_10" id="center_wrapper">
	<div class="grid_7" id="content_wrapper">
		<div class="section_wrapper">
			<h3 class="title_black">Formulario de Items de impuestos</h3>
            			<?php $this->load->view('panel/mensajes_sistema'); ?>

			<div class="content toggle">
				<?=form_open(site_url($this->uri->uri_string()))?>
				<dl>                
					<dt><label>Nombre: </label></dt>
						<dd><?=form_input('nombre', $this->impuestos_mdl->form_value('nombre'))?></dd>
				</dl>

				<dl>
					<dt><label>Porcentaje: </label></dt>
					<dd><?=form_input('porcentaje', $this->impuestos_mdl->form_value('porcentaje'))?></dd>
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