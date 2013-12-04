<script type="text/javascript">

    $(function() {

        $('#servicio_id').change(function() {

            servicio_id = $('#servicio_id').val();

            d_type = '<?php echo $this->uri->segment(3); ?>';

            if (!d_type) {

                d_type = 'factura';

            }

            $.get('<?php echo site_url('facturas/jquery_client_invoice_group'); ?>/' + servicio_id + '/' + d_type, {}, function(factura_grupo_id) {
                $('#factura_grupo_id').val(factura_grupo_id);
            });

        });

    });

</script>