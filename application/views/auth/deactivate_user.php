<?php $this->load->view('panel/cabecera'); ?>

<div class="grid_7" id="content_wrapper">
	<div class="section_wrapper">  
		<h3 class="title_black">Desactivar Usuario</h3>
			<div class="content toggle no_padding">


<div class='mainInfo'>

    <div class="pageTitleBorder"></div>
	<p>Confirma que desea desactivar al usuario '<?php echo $user['username']; ?>'</p>
	
    <?php echo form_open("auth/deactivate/".$user['id']);?>
    	
      <p>
      	<label for="confirm">Si:</label>
		<input type="radio" name="confirm" value="yes" checked="checked" />
      	<label for="confirm">No:</label>
		<input type="radio" name="confirm" value="no" />
      </p>
      
      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(array('id'=>$user['id'])); ?>
      
      <p><?php echo form_submit('submit', 'Confirmar');?></p>

    <?php echo form_close();?>

</div>





	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>