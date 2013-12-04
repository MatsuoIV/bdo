<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>
<?php $this->load->view('facturas/jquery_escoger_servicio'); ?>

<div class="grid_7" id="content_wrapper">
    <div class="section_wrapper">
        <h3 class="title_black">Buscador de Cuotas</h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>
        
        <div class="content toggle">

            <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">                
                <dl>
                    <dt><label>Campana: </label></dt>
                    <dd>
                        <select name="campania_id" id="campania_id">
						<option>2012</option>
						<option>2013</option>
                        </select>
                    </dd>
                </dl>

                <div style="clear: both;">&nbsp;</div>
                    <input type="submit" id="btn_submit" name="btn_submit" value="Ver" />
				<div style="clear: both;">&nbsp;</div>
			</form>

			
			<table>
			<tr>
				<th>Grupo</th>
				<th>Cliente</th>				
				<th>Moneda</th>
				<th>Monto</th>
				<th>Saldo</th>				
			</tr>
			<?php foreach($facturas as $factura){ ?>
			<tr>
				<td><?php echo $factura['nombre']; ?></td>
				<td><?php echo $factura['razonsocial']; ?></td>
				<td><?php echo $factura['codigo']; ?></td>
				<td><?php echo $factura['monto_total']; ?></td>
				<td><?php echo $factura['monto_total']-$factura['monto_pagado']; ?></td>				
			</tr>
			<?php } ?>
			
			

			</table>
				
        </div>

    </div>

</div>


<?php $this->load->view('panel/lateral'); ?>
<?php $this->load->view('panel/pie'); ?>