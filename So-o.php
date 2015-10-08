<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

// imports

require_once 'OL.php';
require_once 'Object.php';

// public

function defclass($name, $superclass, $revision, $class_properties, $instance_properties, $class_messages, $instance_messages) {
	$class=new \OL\Definition($name, $superclass, $revision, $class_properties, $instance_properties, $class_messages, $instance_messages);

	$GLOBALS[$name]=$class;

	if ('Object' != $name) {
		\OL\class_send_message($class, 'initialize');
	}

	return $class;
}

function sendmsg($receiver, $msg) {
	return $receiver->sendself($msg, array_slice(func_get_args(), 2));
}

function supersend($msg, $args) {
	$receiver=array_shift($args);

	return $receiver->sendsuper($msg, $args);
}
