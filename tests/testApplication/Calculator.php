<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Calculator;

require_once 'So-o.php';

defclass('Calculator', null, 1, null, array('accu', 'delegate'), null, array('init', 'value', 'clear', 'add', 'sub', 'mul', 'div', 'sqrt', 'clr', 'sto', 'rcl'));

function i_init($self, $delegate=false) {
	supersend('init', func_get_args());

	sendmsg($self, 'clear');

	if ($delegate) {
		sendmsg($self, 'setDelegate', $delegate);
	}

	return $self;
}

function i_value($self) {
	return sendmsg($self, 'get', 'accu');
}

function i_clear($self) {
	return sendmsg($self, 'set', 'accu', 0.0);
}

function i_add($self, $val) {
	return sendmsg($self, 'set', 'accu', sendmsg($self, 'get', 'accu') + $val);
}

function i_sub($self, $val) {
	return sendmsg($self, 'set', 'accu', sendmsg($self, 'get', 'accu') - $val);
}

function i_mul($self, $val) {
	return sendmsg($self, 'set', 'accu', sendmsg($self, 'get', 'accu') * $val);
}

function i_div($self, $val) {
	return sendmsg($self, 'set', 'accu', sendmsg($self, 'get', 'accu') / $val);
}

function i_sqrt($self) {
	return sendmsg($self, 'set', 'accu', sqrt(sendmsg($self, 'get', 'accu')));
}

function i_clr($self) {
	return sendmsg($self, 'delegate', 'clr');
}

function i_sto($self) {
	return sendmsg($self, 'delegate', 'sto', sendmsg($self, 'get', 'accu'));
}

function i_rcl($self) {
	$v=sendmsg($self, 'delegate', 'rcl');

	return $v !== false ? sendmsg($self, 'set', 'accu', $v) : false;
}

