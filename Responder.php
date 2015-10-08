<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Responder;

require_once 'So-o.php';

defclass('Responder', null, 1, null, array('nextResponders'), null, array('respondTo', 'nextResponders', 'setNextResponders', 'addNextResponder', 'removeNextResponder'));

function i_nextResponders($self) {
	return sendmsg($self, 'get', 'nextResponders');
}

function i_setNextResponders($self, $responders) {
	return sendmsg($self, 'set', 'nextResponders', $responders);
}

function i_addNextResponder($self, $r) {
	$responders=sendmsg($self, 'get', 'nextResponders');

	if ($responders)  {
		if (!in_array($r, $responders)) {
			$responders[]=$r;
			sendmsg($self, 'set', 'nextResponders', $responders);
		}
	}
	else {
		$responders=array($r);
		sendmsg($self, 'set', 'nextResponders', $responders);
	}

	return $self;
}

function i_removeNextResponder($self, $r) {
	$responders=sendmsg($self, 'get', 'nextResponders');

	if ($responders) {
		$i=array_search($r, $responders);

		if ($i !== false) {
			unset($responders[$i]);
			sendmsg($self, 'set', 'nextResponders', $responders);
		}
	}

	return $self;
}

function i_respondTo($self, $msg) {
	if (sendmsg($self, 'respondsTo', $msg) and sendmsg($self, 'perform', $msg, array_slice(func_get_args(), 2))) {
		return $self;
	}

	$responders=sendmsg($self, 'get', 'nextResponders');

	if ($responders) {
		foreach ($responders as $r) {
			sendmsg($r, 'perform', 'respondTo', array_slice(func_get_args(), 1));
		}
	}

	return $self;
}

