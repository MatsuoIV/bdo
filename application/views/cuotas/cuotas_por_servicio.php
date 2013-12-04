<?php $this->load->view('panel/cabecera'); ?>

<?php $this->load->view('panel/jquery_date_picker'); ?>

<?php $this->load->view('panel/jquery_confirmacion'); ?>

<div class="grid_7" id="content_wrapper">
<div class="section_wrapper">  

<h3 class="title_black">Listado de Cuotas de:<form method="post" action="#" style="display: inline;">
<input type="submit" name="btn_email_reminders" style="float: right; margin-top: 10px; margin-right: 10px;" value="Agregar Cuotas" />
</form></h3>
<div class="content toggle no_padding">
  <dl><h4><?=$servicio->servicio_codigo?> << <?=$servicio->cliente_razonsocial?> << <?=$servicio->servicio_tipo?></h4></dl>            
                         
                       
<table>
<tr class="segundo">
    <th scope="col" class="first">Honorario Propuesto</th>
    <th scope="col" >Honorario Aceptado</th>
    <th scope="col" >Honorario Programado</th>
    <th scope="col" class="last">Honorario Facturado</th>
</tr>

<tr>
    <td class="first"><?=$servicio->moneda_simbolo?> <?=formato_numero($servicio->hpropuesto)?></td>
    <td nowrap="nowrap"><?=$servicio->moneda_simbolo?> <?=formato_numero($servicio->haceptado)?></td>
    <td><?=$servicio->moneda_simbolo?> <?=formato_numero($hprogramado)?></td>
    <td class="last"><?=$servicio->moneda_simbolo?> <?=formato_numero($servicio->hpropuesto)?></td>
</tr>
</table>

<table>
<tr>
    <th scope="col" class="first">Fecha</th>
    <th scope="col" >Moneda</th>
    <th scope="col" >Monto</th>
    <th scope="col" >Monto en soles</th>
    <th scope="col" class="last">Acciones</th>
</tr>

<?php foreach ($cuotas as $cuota) { ?>
<tr>
    <td class="first">
        <?=formato_fecha($cuota->fecha)?>        
    </td>
    <td nowrap="nowrap"><?=$cuota->denominacion?></td>
    <td><?=formato_numero($cuota->monto)?></td>
    <td class="last">
		<a href="<?=site_url('cuotas/eliminar/cuota_id/'.$cuota->id)?>" title="Editar"><?=icon('edit')?></a>
		<a class="confirmar" href="<?php echo site_url('cuotas/eliminar/'.$servicio->servicio_id."/".$cuota->cuota_id); ?>" title="Eliminar" >
    <?php echo icon('delete'); ?>
</a>
    </td>
</tr>      
<?php } ?>




<?php if($servicio->haceptado > $hprogramado) { ?>
<tr>
<form name="agregar cuota" method="post" action="<?=$accion_agregar."/".$servicio->servicio_id?>">
<td class="first">
<input  id="datepicker"  name="cuota_fecha" type="text"  value="<?php echo date('d/m/Y'); ?>" /></td>
<td nowrap="nowrap">
<select name="cuota_moneda">
    <?php foreach ($monedas as $moneda) { ?>
    <option value="<?php echo $moneda->id; ?>"><?php echo $moneda->denominacion; ?></option>
    <?php } ?>
</select>   
</td>
<td><input id="cuota_monto" name="cuota_monto" type="text" /></td>
<td class="last"><input type="submit" value="Agregar" /></td>
</form>
</tr>  
<?php }?>



</table>


</div>

</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>

<script>
var cuota_monto = new LiveValidation('cuota_monto');
cuota_monto.add( Validate.Presence );
cuota_monto.add( Validate.Numericality, { minimum: 5, maximum: <?=($servicio->haceptado-$hprogramado)?> } );

</script>