<?php
$fecha = $query['fecha'];

$this->load->view('panel/cabecera');
$fecha = date('d/m/Y',strtotime($fecha));

$monto_por_facturar = 0;
$monto_cobrado = 0;

$cols = array(
    'fecha' => array('Fecha',''),
    'denominacion' => array('Grupo',''),
    'razonsocial' => array('Cliente','cliente'),
    'codigo' => array('Servicio','col_amount'),
    'monto' => array('Monto','col_amount'),
    'saldo' => array('Saldo','')
);

?><div class="grid_7" id="content_wrapper">
    <!--Mensajes de sistema-->
 <!--    <div class="warning">Mensaje del sistema</div>-->
    <div class="section_wrapper">

		<h3 class="title_black">Cuotas pendientes por facturar (al <?php echo $fecha?>)</h3>
			<div class="content toggle no_padding">
                <center>
                    <form method="post" action="#" style="display: inline;">
                        <input type="text" class="datepicker" name="fecha" id="fecha" value="<?php echo $fecha?>" style="text-align:center;font-weight: bold; margin-top: 18px">
                        <input type="submit" name="btn_email_reminders" value="Cambiar" />
                    </form>
                </center>
                <br />
				<table style="width: 100%;">
                    <tr>
                        <?php foreach($cols as $k => $col){

                            $col_search = $query;

                            if($k == $query['order_by']){
                                $col_search['order'] = ($col_search['order']=='DESC')? 'ASC': 'DESC';
                            } else{
                                $col_search['order'] = 'ASC';
                            }
                            $col_search['order_by'] = $k;
                            $col_url = 'panel/index/'.array_url_encode($col_search,$encripcion);
                            ?>
                        <th scope="col" class="<?php echo $col[1]?>">
                            <?php echo anchor($col_url, $col[0])?></th>
                        <?php } ?>
                        <th scope="col" class="last">Acciones</th>
                    </tr>
                    <?php foreach($cuotas_pendientes as $cuota){
                        $monto_por_facturar += $cuota['monto'];
                        ?>
    				<tr>
                        <td class="first invoice_"><?php echo date('Y/m/d', strtotime($cuota['fecha']))?></td>
                        <td class="col_amount"><?php echo $cuota['denominacion']?></td>
                        <td class="client"><?=anchor('client_id/' . $cuota['cliente_id'], character_limiter($cuota['razonsocial'], 25))?></td>
                        <td class="client"><?=anchor('servicio_id/' . $cuota['servicio_id'], $cuota['codigo'].'<br>')?></td>
                        <td class="col_amount"><?php echo $cuota['monto']?></td>
                        <td class="col_amount"><?php echo $cuota['saldo']?></td>
                        <td class="last">
                            <?php if($cuota['saldo'] == $cuota['monto']){ ?>
                            <?=anchor('facturas/create/servicio_id/'.$cuota['servicio_id'],icon('generate_invoice'), array('class'=>'output_link','title'=>'Generar Factura'))?>
                            <?php } else { ?>                           
                            <a href="javascript:void(0)" data-id="<?php echo $cuota['id']?>" title="Ver Factura"><?=icon('generate_receipt')?></a>
                            <?php } ?> 
                        </td>
    				</tr>
                    <?php } ?>
				</table> 
	        </div>
   	</div>

<?php $this->load->view('panel/jquery_date_picker'); ?>
<?php $this->load->view('panel/lateral'); ?>
<?php $this->load->view('panel/pie'); ?>