<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Application;

use \InvalidArgumentException as InvalidArgumentException;

require_once 'So-o.php';

require_once 'Once.php';

defclass('Application', $Once, 1, null, array('appName', 'app'), null, array('init', 'appName', 'doesNotRecognize'));

function i_init($self, $appName=null, $app=null) {
	if (!(is_null($appName) or is_string($appName))) {
		throw new InvalidArgumentException();
	}

	if (!(is_null($app) or is_object($app))) {
		throw new InvalidArgumentException();
	}

	supersend('init', func_get_args());

	if ($appName) {
		sendmsg($self, 'set', 'appName', $appName);
		if ($app) {
			sendmsg($self, 'set', 'app', $app);
		}
	}

	return $self;
}

function i_appName($self) {
	return sendmsg($self, 'get', 'appName');
}

function i_doesNotRecognize($self, $msg) {
	$app=sendmsg($self, 'get', 'app');

	if (!$app) {
		return supersend('doesNotRecognize', func_get_args());
	}

	return sendmsg($app, 'perform', $msg, array_slice(func_get_args(), 2));
}
