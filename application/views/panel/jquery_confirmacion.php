<script>
	$(function() {
		$(document).ready(function() {
			$("#dialog").dialog({
				autoOpen: false,
				modal: true
			});
		});
	
	$(".confirmar").click(function(e) {
    	e.preventDefault();
	    var targetUrl = $(this).attr("href");

		$( "#dialog" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Eliminar": function() {
    				window.location.href = targetUrl;
				},
				"Cancelar": function() {
					$( this ).dialog( "close" );
				}
			}
    });

    $("#dialog").dialog("open");
 		});		
	});
</script>

<div id="dialog" title="Eliminar registro?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>El registro se eliminara permanentemente. Esta seguro?</p>
</div>
