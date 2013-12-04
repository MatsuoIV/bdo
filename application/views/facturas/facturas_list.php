<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>

<div class="grid_10" id="content_wrapper">
	<div class="section_wrapper">
		<h3 class="title_black">Facturas <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar factura")); ?></h3>
		<div class="content toggle no_padding">
			<?php $this->load->view('panel/mensajes_sistema'); ?>
			<?php $this->load->view('factura_table'); ?>
		</div>
	</div>
</div>

<?php $this->load->view('panel/pie'); ?>