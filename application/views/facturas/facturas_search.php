<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_confirmacion'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>

<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">
		<h3 class="title_black"> Búsqueda </h3>
		<div class="content toggle no_padding">
			<center>
				<form method="get" action="<?php echo site_url($this->uri->uri_string()); ?>" style="display: inline;">
	        	Cliente:
	        	<select name="cliente_id" id="compania_id">
	        		<option value="">Todos</option>
	        		<?php foreach($clientes as $cliente){ ?>
	        			<?php $name = $cliente->codigo . " - " . $cliente->razonsocial; ?>
	        			<?php echo add_option($name, $cliente->id, $cliente_id); ?>
	        		<?php } ?>
				</select>
				<br />
				<input type="text" class="datepicker" name="fecha" id="fecha" value="<?php echo $fecha?>" style="text-align:center;font-weight: bold; margin-top: 18px">
	            <input type="submit" name="op" value="Buscar" />
	        </form>
	    	</center>
	    </div>
    </div>

    <div class="section_wrapper">
		<h3 class="title_black">Facturas <?php $this->load->view('panel/btn_add', array('btn_value'=>"Agregar factura")); ?></h3>
		<div class="content toggle no_padding">
			<?php $this->load->view('panel/mensajes_sistema'); ?>
			<?php $this->load->view('factura_table'); ?>
		</div>
	</div>
</div>

<?php $this->load->view('panel/pie'); ?>