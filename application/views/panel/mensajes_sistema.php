<?php if (validation_errors()) { ?>
<?php echo validation_errors(); ?>
<?php } ?>

<?php if ($this->session->flashdata('success_save')) { ?>
<div class="success">Este item ha sido guardado correctamente</div>
<?php } ?>

<?php if ($this->session->flashdata('success_delete')) { ?>
<div class="warning">El item ha sido eliminado exitosamente.</div>
<?php } ?>

<?php if ($this->session->flashdata('custom_warning')) { ?>
<div class="warning"><?php echo $this->session->flashdata('custom_warning'); ?></div>
<?php } ?>

<?php if ($this->session->flashdata('custom_error')) { ?>
<div class="error"><?php echo $this->session->flashdata('custom_error'); ?></div>
<?php } ?>

<?php if ($this->session->flashdata('custom_success')) { ?>
<div class="success"><?php echo $this->session->flashdata('custom_success'); ?></div>
<?php } ?>

<?php if (isset($static_error) and $static_error) { ?>
<div class="error"><?php echo $static_error; ?></div>
<?php } ?>