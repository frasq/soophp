<?php
namespace Z;

require_once 'So-o.php';

require_once('Y.php');

defclass('Z', $Y, 3, null, null, null, array('init', 'f'));

function i_init($self) {
	echo 'Z::init', PHP_EOL;

	supersend('init', func_get_args());

	return $self;
}

function i_f($self, $n) {
	supersend('f', func_get_args());

	return $self;
}

