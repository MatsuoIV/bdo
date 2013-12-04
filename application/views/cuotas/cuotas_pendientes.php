<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>
<?php $this->load->view('facturas/jquery_escoger_servicio'); ?>

<div class="grid_7" id="content_wrapper">
    <div class="section_wrapper">
        <h3 class="title_black">Cuotas pendientes de facturar</h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>
        
        <div class="content toggle">

            <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
                <dl>
                    <dt><label>Fecha: </label></dt>
                    <dd><input id="datepicker" type="text" name="cuota_fecha_pendiente" value="<?php echo date('m/d/Y'); ?>" /></dd>
                </dl>
                <dl>
                    <dt><label>Campana: </label></dt>
                    <dd>
                        <select name="campania_id" id="campania_id">
						<option>Todas</option>
						<option>2010</option>
						<option>2011</option>
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
			<th>Grupo</th>
			<th>Cliente</th>
			<th>Servicio</th>
			<th>Cuota</th>
			<th>Moneda</th>
			<th>Monto</th>
			<th>Saldo</th>
			<th>Acciones</th>
			<tr>
				<td>Alvarez</td>
				<td>Clinica San Pablo</td>
				<td>Auditoria 2011</td>
				<td>2da cuota/4</td>
				<td>S/.</td>
				<td>1200</td>
				<td>1200</td>
				<td>1200</td>
			</tr>
			<tr>
				<td>Alvarez</td>
				<td>Clinica San Pablo</td>
				<td>Auditoria 2012</td>
				<td>1ra cuota/4</td>
				<td>S/.</td>
				<td>1200</td>
				<td>200</td>
				<td>1200</td>

			</tr>
			

			</table>
				
        </div>

    </div>

</div>


<?php $this->load->view('panel/lateral'); ?>
<?php $this->load->view('panel/pie'); ?>