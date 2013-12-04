<?php $this->load->view('panel/cabecera'); ?>

<div class="grid_7" id="content_wrapper">
	<div class="section_wrapper">  
		<h3 class="title_black">Crear usuario</h3>
			<div class="content toggle no_padding">

            <div class='mainInfo'>
                <p>Por favor ingrese la informacion del usuario.</p>
                
                <div id="infoMessage"><?php echo $message;?></div>
                
                <?php echo form_open("auth/create_user");?>
                <p>Nombres:<br />
                <?php echo form_input($first_name);?>
                </p>
                
                <p>Apellidos:<br />
                <?php echo form_input($last_name);?>
                </p>
                
                <p>Compania BDO:<br />             
				<?php echo form_dropdown('company', $companias, 'AUD');?>
                </p>
                
                <p>Correo electronico:<br />
                <?php echo form_input($email);?>
                </p>

                <p>Password:<br />
                <?php echo form_input($password);?>
                </p>
                
                <p>Confirmar Password:<br />
                <?php echo form_input($password_confirm);?>
                </p>
                  
                  
                <p><?php echo form_submit('submit', 'Crear usuario');?></p>
                 
                <?php echo form_close();?>
            
            </div>


		</div>

	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>