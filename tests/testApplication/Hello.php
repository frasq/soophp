<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Hello;

require_once 'So-o.php';

defclass('Hello', null, 1, null, null, null, array('hello'));

function i_hello($self) {
	echo 'Hello from So-o!', PHP_EOL;

	return $self;
}
