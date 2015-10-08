<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace X;

require_once 'So-o.php';

require_once 'Responder.php';

defclass('X', $Responder, 1, null, null, null, array('click', 'clicked'));

function i_click($self) {
	echo 'X clicked', PHP_EOL;
	sendmsg($self, 'respondTo', 'clicked', $self);
}

function i_clicked($self, $sender) {
	echo 'X received a click from ', sendmsg(sendmsg($sender, 'class'), 'name'), PHP_EOL;

	return false;
}
