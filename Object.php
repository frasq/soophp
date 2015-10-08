<?php

/**
 *
 * @copyright  2012-2015 so-o.org
 * @version    2
 * @link       http://www.so-o.org
 */

namespace Object;

use \InvalidArgumentException as InvalidArgumentException;

// imports

require_once 'OL.php';

// errors

define(__NAMESPACE__ . '\InvalidClassProperty', '%s::%s Invalid class property');
define(__NAMESPACE__ . '\InvalidClassMessage', '%s::%s Invalid class message');
define(__NAMESPACE__ . '\InvalidInstanceProperty', '%s::%s Invalid instance property');
define(__NAMESPACE__ . '\InvalidInstanceMessage', '%s::%s Invalid instance message');

define(__NAMESPACE__ . '\NotImplemented', '%s::%s Not implemented');
define(__NAMESPACE__ . '\SubclassResponsibility', '%s::%s Subclass responsibility');

// interface

defclass('Object',
		// superclass
		null,
		// revision
		1,
		// class properties
		null,
		// instance properties
		null,
		// class messages
		array('get', 'set', 'make', 'new', 'initialize', 'free', 'class', 'name', 'superclass', 'classMessages', 'instanceMessages', 'classProperties', 'instanceProperties', 'classMethodFor', 'instanceMethodFor', 'perform', 'read', 'write', 'error', 'doesNotContain', 'doesNotRecognize', 'notImplemented', 'subclassResponsibility', 'revision', 'addInstanceMessage', 'removeInstanceMessage', 'addClassMessage', 'removeClassMessage', 'addInstanceProperty', 'removeInstanceProperty', 'addClassProperty', 'removeClassProperty', 'check'),
		// instance messages
		array('get', 'set', 'init', 'free', 'class', 'superclass', 'perform', 'delegate', 'setDelegate', 'respondsTo', 'methodFor', 'isKindOf', 'copy', 'read', 'write', 'assume', 'toString', 'print', 'error', 'doesNotContain', 'doesNotRecognize', 'notImplemented', 'subclassResponsibility', 'messages', 'properties')
		);

// class methods

function c_free($self) {
}

function c_initialize ($self) {
	return $self;
}

function c_class($self) {
	return $self;
}

function c_name($self) {
	return \OL\class_name($self);
}

function c_revision($self) {
	return \OL\class_revision($self);
}

function c_superclass($self) {
	return \OL\class_superclass($self);
}

function c_get($self, $attribute) {
	return \OL\class_get($self, $attribute);
}

function c_set($self, $attribute, $value) {
	return \OL\class_set($self, $attribute, $value);
}

function c_make($self) {
	return \OL\class_make($self);
}

function c_new($self) {
	return \OL\object_send_message(\OL\class_send_message($self, 'make'), 'init', array_slice(func_get_args(), 1));
}

function c_perform($self, $message, $args=false) {
	return \OL\class_send_message($self, $message, $args);
}

function c_read($self, $data) {
	$properties=\OL\class_send_message($self, 'classProperties', array(true));

	if (!$properties) {
		return $self;
	}

	$data=unserialize($data);
	if (!is_array($data)) {
		throw new InvalidArgumentException();
	}

	$attributes=array();
	foreach ($properties as $prop) {
		if (isset($data[$prop])) {
			$attributes[$prop]=$data[$prop];
		}
	}

	return \OL\class_set_attributes($self, $attributes);
}

function c_write($self) {
	return serialize(\OL\class_attributes($self));
}

function c_classMessages($self, $inherit=true) {
	$messages=\OL\class_class_messages($self);

	if ($messages) {
		$messages=array_keys($messages);
	}

	if ($inherit) {
		$superclass=\OL\class_superclass($self);

		if ($superclass) {
			$inherited_messages=\OL\class_send_message($superclass, 'classMessages', array(true));

			if ($inherited_messages) {
				$messages=$messages ? array_unique(array_merge($messages, $inherited_messages)) : $inherited_messages;
			}
		}
	}

	return $messages;
}

function c_instanceMessages($self, $inherit=true) {
	$messages=\OL\class_instance_messages($self);

	if ($messages) {
		$messages=array_keys($messages);
	}

	if ($inherit) {
		$superclass=\OL\class_superclass($self);

		if ($superclass) {
			$inherited_messages=\OL\class_send_message($superclass, 'instanceMessages', array(true));

			if ($inherited_messages) {
				$messages=$messages ? array_unique(array_merge($messages, $inherited_messages)) : $inherited_messages;
			}
		}
	}

	return $messages;
}

function c_classMethodFor($self, $message) {
	return \OL\class_find_class_method($self, $message);
}

function c_instanceMethodFor($self, $message) {
	return \OL\class_find_instance_method($self, $message);
}

function c_addClassMessage($self, $message) {
	return \OL\class_add_class_message($self, $message);
}

function c_removeClassMessage($self, $message) {
	return \OL\class_remove_class_message($self, $message);
}

function c_addInstanceMessage($self, $message) {
	return \OL\class_add_instance_message($self, $message);
}

function c_removeInstanceMessage($self, $message) {
	return \OL\class_remove_instance_message($self, $message);
}

function c_classProperties($self, $inherit=true) {
	$properties=\OL\class_class_properties($self);

	if ($properties) {
		$properties=array_keys($properties);
	}

	if ($inherit) {
		$superclass=\OL\class_superclass($self);

		if ($superclass) {
			$inherited_properties=\OL\class_send_message($superclass, 'classProperties', array(true));

			if ($inherited_properties) {
				$properties=$properties ? array_unique(array_merge($properties, $inherited_properties)) : $inherited_properties;
			}
		}
	}

	return $properties;
}

function c_instanceProperties($self, $inherit=true) {
	$properties=\OL\class_instance_properties($self);

	if ($properties) {
		$properties=array_keys($properties);
	}

	if ($inherit) {
		$superclass=\OL\class_superclass($self);

		if ($superclass) {
			$inherited_properties=\OL\class_send_message($superclass, 'instanceProperties', array(true));

			if ($inherited_properties) {
				$properties=$properties ? array_unique(array_merge($properties, $inherited_properties)) : $inherited_properties;
			}
		}
	}

	return $properties;
}

function c_addClassProperty($self, $property) {
	return \OL\class_add_class_property($self, $property);
}

function c_removeClassProperty($self, $property) {
	return \OL\class_remove_class_property($self, $property);
}

function c_addInstanceProperty($self, $property) {
	return \OL\class_add_instance_property($self, $property);
}

function c_removeInstanceProperty($self, $property) {
	return \OL\class_remove_instance_property($self, $property);
}

function c_error ($self, $err) {
	$errmsg=call_user_func_array('sprintf', array_merge(array($err), array_slice(func_get_args(), 2)));

	return trigger_error($errmsg, E_USER_ERROR);
}

function c_doesNotContain($self, $property) {
	return \OL\class_send_message($self, 'error', array(InvalidClassProperty, \OL\class_name($self), $property));
}

function c_doesNotRecognize($self, $message) {
	return \OL\class_send_message($self, 'error', array(InvalidClassMessage, \OL\class_name($self), $message));
}

function c_notImplemented($self, $message) {
	return \OL\class_send_message($self, 'error', array(NotImplemented, \OL\class_name($self), $message));
}

function c_subclassResponsibility($self, $message) {
	return \OL\class_send_message($self, 'error', array(SubclassResponsibility, \OL\class_name($self), $message));
}

function c_check($self) {
	return \OL\class_check($self);
}

// instance methods

function i_class($self) {
	return \OL\object_class($self);
}

function i_superclass($self) {
	return \OL\class_superclass(\OL\object_class($self));
}

function i_messages($self, $inherit=true) {
	return \OL\class_send_message(\OL\object_class($self), 'instanceMessages', array($inherit));
}

function i_properties($self, $inherit=true) {
	return \OL\class_send_message(\OL\object_class($self), 'instanceProperties', array($inherit));
}

function i_isKindOf($self, $class) {
	return \OL\class_is_kind_of(\OL\object_class($self), $class);
}

function i_methodFor($self, $message) {
	return \OL\class_find_instance_method(\OL\object_class($self), $message);
}

function i_respondsTo($self, $message) {
	return \OL\class_find_instance_method(\OL\object_class($self), $message) ? true : false;
}

function i_assume($self, $class) {
	return \OL\object_assume($self, $class);
}

function i_free($self) {
}

function i_init($self) {
	return $self;
}

function i_copy ($self) {
	return \OL\object_copy($self);
}

function i_toString($self) {
	return '';
}

function i_print($self, $eol=false) {
	echo \OL\object_send_message($self, 'toString');

	if ($eol) {
		echo PHP_EOL;
	}

	return $self;
}

function i_get($self, $property) {
	return \OL\object_get($self, $property);
}

function i_set($self, $property, $value) {
	return \OL\object_set($self, $property, $value);
}

function i_perform($self, $message, $args=false) {
	return \OL\object_send_message($self, $message, $args);
}

function i_read($self, $data) {
	$properties=\OL\class_send_message(\OL\object_class($self), 'instanceProperties', array(true));

	if (!$properties) {
		return $self;
	}

	$data=unserialize($data);
	if (!is_array($data)) {
		throw new InvalidArgumentException();
	}

	$attributes=array();
	foreach ($properties as $prop) {
		if (isset($data[$prop])) {
			$attributes[$prop]=$data[$prop];
		}
	}

	return \OL\object_set_attributes($self, $attributes);
}

function i_write($self) {
	return serialize(\OL\object_attributes($self));
}

function i_delegate($self, $msg=false) {
	$delegate=\OL\object_get($self, 'delegate');

	if (!$msg) {
		return $delegate;
	}

	if (!$delegate) {
		return false;
	}

	if (!\OL\object_send_message($delegate, 'respondsTo', array($msg))) {
		return false;
	}

	return \OL\object_send_message($delegate, $msg, array_slice(func_get_args(), 2));
}

function i_setDelegate($self, $delegate) {
	if (!(is_null($delegate) or is_object($delegate))) {
		throw new InvalidArgumentException();
	}

	return \OL\object_set($self, 'delegate', $delegate);
}

function i_error ($self, $err) {
	$errmsg=call_user_func_array('sprintf', array_merge(array($err), array_slice(func_get_args(), 2)));

	return trigger_error($errmsg, E_USER_ERROR);
}

function i_doesNotContain($self, $property) {
	return \OL\object_send_message($self, 'error', array(InvalidInstanceProperty, \OL\class_name(\OL\object_class($self)), $property));
}

function i_doesNotRecognize($self, $message) {
	return \OL\object_send_message($self, 'error', array(InvalidInstanceMessage, \OL\class_name(\OL\object_class($self)), $message));
}

function i_notImplemented($self, $message) {
	return \OL\object_send_message($self, 'error', array(NotImplemented, \OL\class_name(\OL\object_class($self)), $message));
}

function i_subclassResponsibility($self, $message) {
	return \OL\object_send_message($self, 'error', array(SubclassResponsibility, \OL\class_name(\OL\object_class($self)), $message));
}
