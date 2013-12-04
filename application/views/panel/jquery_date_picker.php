<script type="text/javascript">
	$(function() {
		$("#datepicker").datepicker({ changeYear: true, changeMonth: true, dateFormat: 'dd/mm/yy' });
		$(".datepicker").datepicker({ changeYear: true, changeMonth: true, dateFormat: 'dd/mm/yy' });
		$("#datepicker").mask("99/99/9999");
		$(".datepicker").mask("99/99/9999");
	});
</script>