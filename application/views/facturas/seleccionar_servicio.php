<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>

<!--/*Jquery autocompletar AJAX*/-->
<script type="text/javascript">
$(document).ready(function(){
	$('#autocomplete').autocomplete({
		source:'<?php echo site_url('cuotas/ajax'); ?>',
		minLength: 3,
		select: function(event, ui) {
			document.formulario.action ="<?=$accion?>/"+ui.item.id;		
		}
	});
});
</script>

<div class="grid_7" id="content_wrapper">
	<div class="section_wrapper">
		<h3 class="title_black">Crear factura (PASO 1):</h3>
        <div class="content toggle">
<form name="formulario" method="get">


<label>Seleccione un grupo de facturas disponible: </label>
<p>
<select name="factura_grupo_id">
    <?php foreach ($factura_grupos as $factura_grupo) { ?>
    <option value="<?php echo $factura_grupo->factura_grupo_id; ?>"><?php echo $factura_grupo->factura_grupo_nombre; ?></option>
    <?php } ?>
</select>   
</p>

<label>Seleccione la fecha de la factura: </label>
<p><input  id="datepicker"  name="factura_fecha" type="text"  value="<?php echo date('d/m/Y'); ?>" /></p>

<label>Escriba la razon social del cliente, cod. o tipo de servicio: </label>
<p><input id="autocomplete" style="width:100%;" type="text" 
        name="autocomplete" 
        onblur="this.value = this.value || this.defaultValue;"
		onfocus="this.value = '';" value="(Escriba 3 letras como minimo)" /></p>
          
<input type="submit" id="btn_submit" name="btn_submit" value="Generar factura" />
<input type="submit" id="btn_cancel" name="btn_cancel" value="Cancelar" />
</form>
        
        </div>
	
    </div>
</div>

<?php $this->load->view('panel/lateral'); ?>
<?php $this->load->view('panel/pie'); ?>