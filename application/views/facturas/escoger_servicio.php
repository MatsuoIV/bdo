<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>
<?php $this->load->view('facturas/jquery_escoger_servicio'); ?>

<div class="grid_10" id="content_wrapper">
    <div class="section_wrapper">
        <h3 class="title_black">Crear Factura</h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>
        
        <div class="content toggle">

            <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
                <dl>
                    <dt><label>Fecha: </label></dt>
                    <dd><input id="datepicker" type="text" name="factura_fecha_ingreso" value="<?php echo date('m/d/Y'); ?>" /></dd>
                </dl>
                <dl>
                    <dt><label>Servicio: </label></dt>
                    <dd>
                        <select name="servicio_id" id="servicio_id">
                            <option value=""></option>
                            <?php foreach ($servicios as $servicio) { ?>
                            <option value="<?php echo $servicio->servicio_id; ?>" <?php if ($this->facturas_mdl->form_value('servicio_id') == $servicio->servicio_id) { ?>selected="selected"<?php } ?>>
							<?php echo $servicio->servicio_codigo." > ".character_limiter($servicio->cliente_razonsocial,20)." > ".character_limiter($servicio->servicio_tipo,15); ?>
                            
                            </option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label>Compa&ntilde;ia</label></dt>
                    <dd>
                        <select id="compania_id">
                            
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label>Grupo de facturas: </label></dt>
                    <dd>
                        <select name="factura_grupo_id" id="factura_grupo_id">
                            <?php foreach ($factura_grupos as $factura_grupo) { ?>
                            <option value="<?php echo $factura_grupo->id; ?>" <?php if (1 == $factura_grupo->id) { ?>selected="selected"<?php } ?>><?php echo $factura_grupo->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>

                <div style="clear: both;">&nbsp;</div>
                    <input type="submit" id="btn_submit" name="btn_submit" value="Crear Factura" />
                    <input type="submit" id="btn_cancel" name="btn_cancel" value="Cancelar" />
            </form>
        </div>

    </div>

</div>
<?php $this->load->view('panel/pie'); ?>