<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Z;

require_once 'So-o.php';

require_once 'Responder.php';

defclass('Z', $Responder, 1, null, null, null, array('clicked'));

function i_clicked($self, $sender) {
	echo 'Z received a click from ', sendmsg(sendmsg($sender, 'class'), 'name'), PHP_EOL;

	return true;
}

