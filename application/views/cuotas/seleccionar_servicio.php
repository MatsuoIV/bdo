<?php $this->load->view('panel/cabecera'); ?>

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
		<h3 class="title_black">Seleccionar codigo de servicio:</h3>
        <div class="content toggle">
	        <form name="formulario" method="get" onsubmit="return onsubmitform();">
	        	<label>Escriba la razon social del cliente, cod. o tipo de servicio: </label>
	        	<p><input id="autocomplete" style="width:100%;" type="text" name="autocomplete" onblur="this.value = this.value || this.defaultValue;" onfocus="this.value = '';" value="(Escriba 3 letras como minimo)" /></p>
				<input type="submit" id="btn_submit" name="btn_submit" value="Asinar cuotas" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="Cancelar" />
	        </form>        
        </div>	
    </div>
</div>

<?php $this->load->view('panel/lateral'); ?>
<?php $this->load->view('panel/pie'); ?>