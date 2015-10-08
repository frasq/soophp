<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Y;

require_once 'So-o.php';

require_once 'Responder.php';

defclass('Y', $Responder, 1, null, null, null, array('clicked'));

function i_clicked($self, $sender) {
	echo 'Y received a click from ', sendmsg(sendmsg($sender, 'class'), 'name'), PHP_EOL;

	return true;
}

