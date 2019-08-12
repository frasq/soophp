<?php

/**
 *
 * @copyright  2012-2019 so-o.org
 * @version    2
 * @link       http://www.so-o.org
 */

namespace CalculatorHelper;

require_once 'So-o.php';

defclass('CalculatorHelper', null, 1, null, array('mem'), null, array('init', 'clr', 'sto', 'rcl'));

function i_init($self, $helper=false) {
	supersend('init', func_get_args());

	sendmsg($self, 'clr');

	return $self;
}

function i_clr($self) {
	return sendmsg($self, 'sto', 0.0);
}

function i_sto($self, $v) {
	return sendmsg($self, 'set', 'mem', $v);
}

function i_rcl($self) {
	return sendmsg($self, 'get', 'mem');
}

