<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace X;

require_once 'So-o.php';

defclass('X', null, 1, null, array('value'), null, array('value'));

function i_value($self) {
	return sendmsg($self, 'get', 'value');
}
