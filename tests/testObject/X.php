<?php
namespace X;

require_once 'So-o.php';

defclass('X', null, 1, array('count'), array('value'), array('initialize', 'new', 'incr', 'decr', 'count'), array('free', 'init', 'f', 'g'));

function c_initialize($self) {
	return sendmsg($self, 'set', 'count', 0);
}

function c_new($self) {
	$i=supersend('new', func_get_args());

	sendmsg($self, 'incr');

	return $i;
}

function c_count($self) {
	return sendmsg($self, 'get', 'count');
}

function c_incr($self) {
	return sendmsg($self, 'set', 'count', sendmsg($self, 'get', 'count') + 1);
}

function c_decr($self) {
	return sendmsg($self, 'set', 'count', sendmsg($self, 'get', 'count') - 1);
}

function i_free($self) {
	sendmsg(sendmsg($self, 'class'), 'decr');

	supersend('free', func_get_args());
}

function i_init($self) {
	echo 'X::init', PHP_EOL;

	supersend('init', func_get_args());

	sendmsg($self, 'set', 'value', 0);

	return $self;
}

function i_f($self, $n) {
	echo $n, PHP_EOL;

	if ($n > 0) {
		sendmsg($self, 'f', $n-1);
	}

	return $self;
}

function i_g($self) {
	echo 'X::g', PHP_EOL;

	return $self;
}

