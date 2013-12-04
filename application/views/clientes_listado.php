<?php $this->load->view('panel/cabecera'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        <?php foreach($clientes as $cliente) { ?>           
            $("#ShowHide<?=$cliente->id?>").html("<a href='#'>Mostrar_servicios</a>");
            $("#HiddenRows<?=$cliente->id?>").hide();
            $("#ShowHide<?=$cliente->id?>").click( function() {
                $("#HiddenRows<?=$cliente->id?>").toggle();
            });
        <?php } ?>
    });
</script>


<div class="grid_10" id="content_wrapper">
<div class="section_wrapper">  
<form method="post" action="#" style="display: inline;">
<h3 class="title_black">
    <div style="float: left">Clientes:</div>

<SELECT NAME="campania" SIZE=1 style="float: left; margin-top: 14px; margin-left: 10px;"> 
<OPTION VALUE="">Todas la campa&ntilde;as</OPTION>
    <?php
    $y = date('Y');
    for ($i = 2010; $i <= $y; $i++ ){ ?>
    <OPTION VALUE="<?php echo $i?>" <?php if($i==$anio){ echo 'selected="selected"'; } ?>><?php echo $i?></OPTION>
    <?php } ?>
</SELECT>
<input type="submit" name="btn_email_reminders" style="float: left; margin-top: 13px; margin-left: 10px;" value="Ver" />
</h3></form>
<div class="content toggle no_padding">

<table style="width: 100%">
<tr>
    <th scope="col" class="first">Grupo</th>
    <th scope="col" >Codigo</th>
    <th scope="col" >Razon Social / Nombre</th>
    <th scope="col" >Balance Soles</th>
    <th scope="col" >Balance D&oacute;lares</th>                   
    <th scope="col" class="last">Acciones</th>
</tr>

<?php foreach ($clientes as $cliente) { ?>
<tr>
    <td class="first"><?=$cliente->cliente_grupo?></td>
    <td nowrap="nowrap"><?=$cliente->codigo?></td>
    <td><?=$cliente->razonsocial?></td>
    <td>S/. <?=($cliente->balance_cliente_soles)?$cliente->balance_cliente_soles:'0.00'?></td>
    <td>$ <?=($cliente->balance_cliente_dolares)?$cliente->balance_cliente_dolares:'0.00'?></td>
    <td class="last">
        <div id="ShowHide<?=$cliente->id?>"></div>
    </td>
</tr>

<tbody id="HiddenRows<?=$cliente->id?>">
    <?php $cont=1;
    foreach ($this->clientes_mdl->listadoservicios($cliente->id, $anio) as $servicio) { ?>
    <tr class="expandir"><td><?=$cont++?></td><td><?=$servicio->codigo?></td>
        <td><?=$servicio->denominacion?></td>
        <td><?php if($servicio->moneda_id==1){ ?>S/. <?php echo $servicio->balance; }?></td>
        <td><?php if($servicio->moneda_id==2){ ?>$ <?php echo $servicio->balance; }?></td>
        <td>
            <a href="<?=site_url('clientes/detalle/servicio_id/'.$servicio->id)?>" title="Ver"><?=icon('zoom')?></a>
        </td>
    </tr>
    <?php } ?>
</tbody>
<?php } ?>
</table>

<?php 
    if ($this->clientes_mdl->page_links)
        echo '<div id="pagination">'.$this->clientes_mdl->page_links;
?>

</div>

</div>

</div>