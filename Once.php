<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Once;

require_once 'So-o.php';

defclass('Once', null, 1, array('instance'), null, array('new'), null);

function c_new($self) {
	$i=sendmsg($self, 'get', 'instance');

	if (!$i) {
		$i=supersend('new', func_get_args());
		sendmsg($self, 'set', 'instance', $i);
	}

	return $i;
}
