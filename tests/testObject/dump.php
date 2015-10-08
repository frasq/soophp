<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

function dump($var, $label=null) {
	ob_start();
	var_dump($var);
	$output = ob_get_clean();

	// remove newlines and tabs
	$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);

	// fix label
	$label = $label ? rtrim($label) . '=' : '';

	echo $label, $output;
}

