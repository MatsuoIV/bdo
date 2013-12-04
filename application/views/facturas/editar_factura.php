<?php $this->load->view('panel/cabecera'); ?>
<?php $this->load->view('panel/jquery_date_picker'); ?>

<div class="grid_10" id="content_wrapper" style="position: relative">

    <div id="agregar" style="background-color: #FFFFFF; border: 2px solid #676767; border-radius: 5px 5px 5px 5px; left: 22px; padding: 20px; width: 892px; position: absolute; top: 62px; display: none">
        <h3>Agregar cuotas</h3>
        <dl>
            <dt><label>Servicio: </label></dt>
            <dd>
                <select name="servicio_id" id="servicio_id">
                    <option value=""></option>
                    <?php foreach ($servicios as $servicio) { ?>
                    <option value="<?php echo $servicio->servicio_id; ?>" <?php if ($servicio_id == $servicio->servicio_id) { ?>selected="selected"<?php } ?> data-monedasimbolo="<?php echo $servicio->moneda_simbolo?>">
                    <?php echo $servicio->servicio_codigo." > ".character_limiter($servicio->cliente_razonsocial,20)." > ".character_limiter($servicio->servicio_tipo,15); ?>                    
                    </option>
                    <?php } ?>
                </select>
            </dd>
        </dl>
        <dl>
            <dt><label>Cuota:</label></dt>
            <dd>
                <select id="cuota_id" name="cuota_id">

                </select>
            </dd>
        <dl>

        <a href="#" id="agregar_cuota">Agregar cuota</a> | <a href="#" id="cerrar_cuota_panel">Cerrar</a>
    </div>

    <div class="section_wrapper">
        <h3 class="title_black">Crear/Editar Facturas</h3>
			<?php $this->load->view('panel/mensajes_sistema'); ?>
        
        <div class="content toggle">

            <!--
            <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
            -->
            <form method="post" action="<?php echo site_url('facturas/save'); ?>">
                <dl>
                    <dt><label>Fecha: </label></dt>
                    <dd><input id="datepicker" type="text" name="factura_fecha_ingreso" value="<?php echo date('m/d/Y'); ?>" /></dd>
                </dl>
                <dl>
                    <dt><label>Compa&ntilde;ia</label></dt>
                    <dd>
                        <select name="compania_id" id="compania_id">
                            <?php foreach($companias as $compania){ ?>
                            <option value="<?php echo $compania->id ?>"><?php echo $compania->razonsocial?></option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label>Grupo de facturas: </label></dt>
                    <dd>
                        <select name="factura_grupo_id" id="factura_grupo_id">
                            <?php foreach ($factura_grupos as $factura_grupo) { ?>
                            <option class="grupo_factura grupo_factura_<?php echo $factura_grupo->compania_id?>" value="<?php echo $factura_grupo->id; ?>" <?php if (1 == $factura_grupo->id) { ?>selected="selected"<?php } ?>><?php echo $factura_grupo->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label>Moneda:</label></dt>
                    <dd>
                        <select id="moneda_id" name="moneda_id">
                            <?php foreach($monedas as $moneda){ ?>
                            <option value="<?php echo $moneda->id?>"><?php echo $moneda->denominacion?></option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt><label>Pago de cuotas: </label></dt>
                    <dd>
                        <table id="tabla_factura_cuota">
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Fecha cuota</th>
                                    <th>Monto c.</th>
                                    <th>Saldo c.</th>
                                    <th>A pagar</th>
                                    <th>Ver facturas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- -->
                            </tbody>
                        </table>

                        
                        <a href="" id="agregar_opener"><strong>Agregar una cuota</strong></a>

                    </dd>
                </dl>
                <hr>

                <div style="clear: both;">&nbsp;</div>
                    <input type="submit" id="btn_submit" name="btn_submit" value="Crear Factura" />
                    <input type="submit" id="btn_cancel" name="btn_cancel" value="Cancelar" />
            </form>
        </div>
    </div>
    <script>
    jQuery(document).ready(function(){
        jQuery('#compania_id').change(function(e){
            var compania_id = jQuery(this).val();
            if(compania_id){
                jQuery('.grupo_factura').hide();
                jQuery('.grupo_factura_'+compania_id).show();
                jQuery('#factura_grupo_id').val('');
            }
        }).trigger('change');

        jQuery('#agregar_opener').click(function(e){
            e.preventDefault();

            jQuery('#agregar').fadeIn();
        });

        jQuery('#cerrar_cuota_panel').click(function(e){
            e.preventDefault();
            jQuery('#agregar').fadeOut();
        });

        //funcion agregar cuota
        jQuery('#servicio_id').change(function(e){
            //return;
            var servicio_id = jQuery(this).val();

            $('#cuota_id').find('option').remove();

            jQuery.getJSON("<?php echo site_url('facturas/cuotas_de_servicio'); ?>/"+servicio_id, function(res){
                if(res.cuotas && res.cuotas.length){                    
                    var options = '', cuota;
                    for(var i=0; i< res.cuotas.length; i++){
                        cuota = res.cuotas[i];
                        options += '<option value="'+cuota.id+'" data-monto="'+cuota.monto+'" data-saldo="'+cuota.saldo+'" data-fecha="'+cuota.fecha+'">'+cuota.fecha+' - '+cuota.saldo+'</option>';
                    }
                    $('#cuota_id').append(options);
                } else{
                    $('#cuota_id').append('');
                    //alert("El servicio seleccionado no tiene cuotas asignadas");
                }
            });
        }).trigger('change');

        jQuery('#agregar_cuota').click(function(e){
            //var servicio_id = jQuery(this).val();
            var servicio_id = jQuery("#servicio_id").val();
            var cuota_id = jQuery("#cuota_id").val();

            jQuery.getJSON("<?php echo site_url('facturas/cuota_especifica'); ?>/"+servicio_id+"/"+cuota_id, function(data){

                if(data.cuotas && data.cuotas.length) {

                    cuota = data.cuotas[0];
                    //console.log(cuota);

                    // hardcoded
                    var td = "<tr>";
                    td += "<td>";
                    td += '<input type="hidden" name="cuotas[]" value="'+ cuota_id +'"/>';
                    td += cuota.codigo +"</td>";
                    td += "<td>"+ cuota.fecha_registro +"</td>";
                    td += "<td>"+ cuota.monto +"</td>";
                    td += "<td>"+ cuota.saldo +"</td>";
                    td += "<td>"+ cuota.monto +"</td>";
                    td += "<td>"+ "" +"</td>";
                    td += "</tr>";
                    jQuery("#tabla_factura_cuota").append(td);

                }// data
            });
            e.preventDefault();
        });
    });
    </script>
</div>
<?php $this->load->view('panel/pie'); ?>