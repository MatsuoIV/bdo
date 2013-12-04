<?php $this->load->view('panel/cabecera'); ?>

<div class="grid_7" id="content_wrapper">
	<div class="section_wrapper">  
		<h3 class="title_black">Lista de Usuarios</h3>
			<div class="content toggle no_padding">

<div class='mainInfo'>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
	<table cellpadding=0 cellspacing=10>
		<tr>
			<th>Usuario</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>E-mail</th>
			<th>Grupo</th>
			<th>Estado</th>            
		</tr>

		<?php foreach ($users as $user):?>			
			<tr>
				<td><?php echo $user->username?></td>
				<td><?php echo $user->first_name?></td>
				<td><?php echo $user->last_name?></td>
				<td><?php echo $user->email?></td>
				<td><?php echo $user->groups[0]->description?></td>
				<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Activo') : anchor("auth/activate/". $user->id, 'Inactivo');?></td>
			</tr>
		<?php endforeach;?>
	</table>
	
	<p><a href="<?php echo site_url('auth/create_user');?>">Crear nuevo usuario</a></p>
	
</div>




	</div>

</div>

<?php $this->load->view('panel/lateral'); ?>

<?php $this->load->view('panel/pie'); ?>