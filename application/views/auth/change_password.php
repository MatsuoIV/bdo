<?php $this->load->view('panel/cabecera'); ?>

<div class="grid_7" id="content_wrapper">
	<div class="section_wrapper">  
		<h3 class="title_black">Cambio de contraseña</h3>
			<div class="content toggle no_padding">
				
                <div id="infoMessage"><?php echo $message;?></div>
				<?php echo form_open("auth/change_password");?>

                <p>Password actual:<br />
                <?php echo form_input($old_password);?>
                </p>
                
                <p>Nuevo password:<br />
                <?php echo form_input($new_password);?>
                </p>
                
                <p>Confirme nuevo password:<br />
                <?php echo form_input($new_password_confirm);?>
                </p>
                
                <?php echo form_input($user_id);?>
                <p><?php echo form_submit('submit', 'Cambiar');?></p>
      
				<?php echo form_close();?>

		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>