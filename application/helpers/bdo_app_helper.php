<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function titulo_aplicacion() {
    return "Sistema de Facturación y Cobranzas";
}

function icon($icon_name, $alt='', $ext='png') {
	return '<img src="' . base_url() . 'assets/style/img/icons/' . $icon_name . '.' . $ext . '" alt="' . $alt . '" />';

}


function formato_numero($numero= NULL) {
	global $CI;
	return number_format($numero, 2, '.', ',');	
}

function formato_fecha($unix_timestamp_date = NULL) {
	if ($unix_timestamp_date) {
		global $CI;		
		return date('d/m/Y', strtotime($unix_timestamp_date));
	}
	return '';
}

function formato_hora($unix_timestamp_date = NULL) {
	if ($unix_timestamp_date) {
		global $CI;
		return date('d/m/Y G:i', $unix_timestamp_date);
	}
	return '';
}


function standardize_date($date) {
	global $CI;
	if (strstr($date, '/')) {
		$delimiter = '/';
	}
	elseif (strstr($date, '-')) {
		$delimiter = '-';
	}
	elseif (strstr($date, '.')) {
		$delimiter = '.';
	}
	else {
		// do not standardize
		return $date;
	}
	$date_format = explode($delimiter, 'd/m/Y');
	$date = explode($delimiter, $date);
	foreach ($date_format as $key=>$value) {
		$standard_date[strtolower($value)] = $date[$key];
	}
	return $standard_date['m'] . '/' . $standard_date['d'] . '/' . $standard_date['y'];
}

function standardize_number($num) {
	global $CI;
	if (!$_POST or $CI->uri->segment(1) == 'mailer') {
		return $num;
	}
	$num_array = explode('.', $num);
	$num = str_replace(',', '', $num_array[0]);
	if (isset($num_array[1])) {
		$num .= '.' . $num_array[1];
	}
	return $num;
}

function uri_assoc($var, $segment = 3) {
	$CI =& get_instance();
	$uri_assoc = $CI->uri->uri_to_assoc($segment);
	if (isset($uri_assoc[$var])) {
		return $uri_assoc[$var];
	}else {
		return NULL;
	}
}

function url_base64_encode($str = "") {
    return strtr(
            base64_encode($str), array(
        '+' => '.',
        '=' => '-',
        '/' => '~'
            )
    );
}

function url_base64_decode($str = "") {
    return base64_decode(strtr(
            $str, array(
        '.' => '+',
        '-' => '=',
        '~' => '/'
            )
    ));
}

function array_url_encode($arr, $url_encode = FALSE) {
    $datos = array();
    foreach ($arr as $k => $v) {
        if ($v != '') {
            $reemp = str_replace(array('~', '-'), array('__DSPTS__', '__GUION__'), array($k, $v));
            $datos[] = $reemp[0] . '~' . $reemp[1];
        }
    }
    if ($url_encode) {
        return url_base64_encode(implode('-', $datos));
    }
    return implode('-', $datos);
}

function array_url_decode($str, $url_decode = FALSE) {
    $res = array();
    if ($url_decode) {
        $kv = explode('-', url_base64_decode($str));
    } else {
        $kv = explode('-', $str);
    }

    foreach ($kv as $f) {
        $r = explode('~', $f);
        if (isset($r[1])) {
            $reemp = str_replace(array('__DSPTS__', '__GUION__'), array('~', '-'), $r[1]);
            $res[$r[0]] = $reemp;
        }
    }
    return $res;
}

?>