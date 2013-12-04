<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>

<div class="container_10" id="center_wrapper">
	<div class="grid_7" id="content_wrapper">
		<div class="section_wrapper">
			<h3 class="title_black">Formulario de Items de tipo de cambio</h3>
            			<?php $this->load->view('panel/mensajes_sistema'); ?>

			<div class="content toggle">

				<?=form_open(site_url($this->uri->uri_string()))?>
				<dl>
					<dt><label>Compra: </label></dt>
					<dd><?=form_input('compra', $this->tcdolars_mdl->form_value('compra'))?></dd>
				</dl>
                

				<dl>
					<dt><label>Venta: </label></dt>
					<dd><?=form_input('venta', $this->tcdolars_mdl->form_value('venta'))?></dd>
				
				</dl>
				
				<dl>
					<dt><label>Fecha: </label></td>
					<dd class="first">
						<input  id="datepicker"  name="fecha" type="text"  value="<?php echo date_format(date_create($this->tcdolars_mdl->form_value('fecha')),'d/m/Y'); ?>" />
					</dd>
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