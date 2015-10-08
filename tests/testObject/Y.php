<?php
namespace Y;

require_once 'So-o.php';

require_once('X.php');

defclass('Y', $X, 2, null, null, null, array('init', 'echo', 'f'));

function i_init($self) {
	echo 'Y::init', PHP_EOL;

	supersend('init', func_get_args());

	return $self;
}

function i_f($self, $n) {
	echo $n*2, PHP_EOL;

	supersend('f', func_get_args());

	return $self;
}

function i_g($self) {
	echo 'Y::g', PHP_EOL;

	return $self;
}

function i_echo($self) {
	if (func_num_args() > 1) {
		foreach (array_slice(func_get_args(), 1) as $arg) {
			echo $arg;
		}
		echo PHP_EOL;
	}

	return $self;
}

function c_supercount($self) {
	return supersend('count', func_get_args());
}

