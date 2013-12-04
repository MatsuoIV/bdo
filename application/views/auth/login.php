<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=titulo_aplicacion()?></title>
    <link href="<?=base_url()?>assets/style/css/styles.css" rel="stylesheet" type="text/css" media="screen" />
    <link type="text/css" href="<?=base_url()?>assets/jquery/ui-themes/myclientbase1/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?=base_url()?>assets/jquery/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/jquery/jquery-ui-1.8.4.custom.min.js"></script>
</head>

<body>
	<div class="container_10" id="center_wrapper">
		<div class="grid_5 push_2" id="content_wrapper">
			<div class="section_wrapper">
				<h3 class="title_black"><?php echo titulo_aplicacion() . ' - Login'; ?></h3>
					<div class="content toggle">

	<p>Por favor ingrese su nombre de usuario y password:</p>
	<div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open("auth/login");?>	
      <p><label for="email">Nombre de usuario:</label>
	  <?php echo form_input($username);?></p>
      
      <p><label for="password">Password:</label>
      	<?php echo form_input($password);?></p>
      
      <p><label for="remember">Recordarme:</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?></p>
      
      <p><?php echo form_submit('submit', 'Ingresar');?></p>
    <?php echo form_close();?>

						<div style="clear: both;">&nbsp;</div>

					</div>

				</div>

			</div>
		</div>


	</body>
</html>










