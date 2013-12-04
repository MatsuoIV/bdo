<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function add_option($msg, $value, $approved) {
	$selected = '';
	if ( $approved == $value ) {
		$selected = ' selected';
	}

	$result = '<option value="' . $value . '"' . $selected .'>' . $msg . '</option>';
	return $result;
}