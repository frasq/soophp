<?php

/**
 *
 * @copyright  2012-2015 so-o.org
 * @revision   2
 * @link       http://www.so-o.org
 */

namespace OL;

use \InvalidArgumentException as InvalidArgumentException;
use \LogicException as LogicException;

// containers

class Definition {
	public $name;
	public $revision;
	public $superclass;

	public $c_properties;
	public $i_properties;
	public $c_messages;
	public $i_messages;
	public $attributes;

	function __construct($cname, $sc, $rev, $c_props, $i_props, $c_msgs, $i_msgs) {
		static $varname='/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

		if (!(is_string($cname) and preg_match($varname, $cname))) {
			throw new InvalidArgumentException();
		}

		if (!(is_null($sc) or (is_object($sc) and __NAMESPACE__ . '\Definition' == get_class($sc)))) {
			throw new InvalidArgumentException();
		}

		if (!(is_int($rev) and $rev > 0)) {
			throw new InvalidArgumentException();
		}

		foreach (array($c_props, $i_props, $c_msgs, $i_msgs) as $arr) {
			if (is_null($arr)) {
				continue;
			}
			if (is_array($arr)) {
				foreach ($arr as $s) {
					if (!(is_string($s) and preg_match($varname, $s))) {
						throw new InvalidArgumentException();
					}
				}
				continue;
			}
			throw new InvalidArgumentException();
		}

		$this->name=$cname;
		$this->revision=$rev;
		$this->superclass='Object' != $cname ? ($sc ? $sc : $GLOBALS['Object']) : null;

		$this->c_properties=$c_props ? array_fill_keys($c_props, 0) : null;
		$this->i_properties=$i_props ? array_fill_keys($i_props, 0) : null;
		$this->c_messages=$c_msgs ? array_fill_keys($c_msgs, 0) : null;
		$this->i_messages=$i_msgs ? array_fill_keys($i_msgs, 0) : null;

		$this->attributes=array();
	}

	function __destruct() {
		return class_send_message($this, 'free');
	}

	function __toString() {
		return 'class(' . $this->name . ')';
	}

	function sendself($msg, $args=false) {
		return class_send_message($this, $msg, $args);
	}

	function sendsuper($msg, $args=false) {
		$backtrace=debug_backtrace(false);

		$fromfunc=count($backtrace) > 2 ? $backtrace[2]['function'] : false;
		$pos=$fromfunc ? strpos($fromfunc, '\\c_') : false;
		$fromclassname=$pos ? substr($fromfunc, 0, $pos) : false;
		$fromclass=($fromclassname and isset($GLOBALS[$fromclassname])) ? $GLOBALS[$fromclassname] : false;

		if (!$fromclass) {
			throw new LogicException();
		}

		return class_super_send_message($fromclass, $this, $msg, $args);
	}
}

class Instance {
	public $class;
	public $attributes;

	function __construct($c) {
		if (!(is_object($c) and __NAMESPACE__ . '\Definition' == get_class($c))) {
			throw new InvalidArgumentException();
		}

		$this->class=$c;

		$this->attributes=array();
	}

	function __destruct() {
		return object_send_message($this, 'free');
	}

	function __toString() {
		return 'object(' . $this->class->name . ')';
	}

	function sendself($msg, $args=false) {
		return object_send_message($this, $msg, $args);
	}

	function sendsuper($msg, $args=false) {
		$backtrace=debug_backtrace(false);

		$fromfunc=count($backtrace) > 2 ? $backtrace[2]['function'] : false;
		$pos=$fromfunc ? strpos($fromfunc, '\\i_') : false;
		$fromclassname=$pos ? substr($fromfunc, 0, $pos) : false;
		$fromclass=($fromclassname and isset($GLOBALS[$fromclassname])) ? $GLOBALS[$fromclassname] : false;

		if (!$fromclass) {
			throw new LogicException();
		}

		return object_super_send_message($fromclass, $this, $msg, $args);
	}
}

// engine

function class_class_method_symbol($class, $message) {
	return '\\' . class_name($class) . '\\' . 'c_' . $message;
}

function class_instance_method_symbol($class, $message) {
	return '\\' . class_name($class) . '\\' . 'i_' . $message;
}

//

function class_name($class) {
	return $class->name;
}

function class_revision($class) {
	return $class->revision;
}

function class_superclass($class) {
	return $class->superclass;
}

function &class_class_properties($class) {
	return $class->c_properties;
}

function &class_instance_properties($class) {
	return $class->i_properties;
}

function &class_class_messages($class) {
	return $class->c_messages;
}

function &class_instance_messages($class) {
	return $class->i_messages;
}

function class_set_class_properties($class, $properties) {
	$class->c_properties=$properties;

	return $class;
}

function class_set_instance_properties($class, $properties) {
	$class->i_properties=$properties;

	return $class;
}

function class_set_class_messages($class, $messages) {
	$class->c_messages=$messages;

	return $class;
}

function class_set_instance_messages($class, $messages) {
	$class->i_messages=$messages;

	return $class;
}

function class_add_class_message($class, $message) {
	$messages=&class_class_messages($class);

	if (is_null($messages)) {
		return class_set_class_messages($class, array($message => 0));
	}

	$messages[$message]=0;

	return $class;
}

function class_remove_class_message($class, $message) {
	$messages=&class_class_messages($class);

	if (!is_null($messages)) {
		unset($messages[$message]);
	}

	return $class;
}

function class_add_instance_message($class, $message) {
	$messages=&class_instance_messages($class);

	if (is_null($messages)) {
		return class_set_instance_messages($class, array($message => 0));
	}

	$messages[$message]=0;

	return $class;
}

function class_remove_instance_message($class, $message) {
	$messages=&class_instance_messages($class);

	if (!is_null($messages)) {
		unset($messages[$message]);
	}

	return $class;
}

function class_add_class_property($class, $property) {
	$properties=&class_class_properties($class);

	if (is_null($properties)) {
		return class_set_class_properties($class, array($property => 0));
	}

	$properties[$property]=0;

	return $class;
}

function class_remove_class_property($class, $property) {
	$properties=&class_class_properties($class);

	if (!is_null($properties)) {
		unset($properties[$property]);
	}

	return $class;
}

function class_add_instance_property($class, $property) {
	$properties=&class_instance_properties($class);

	if (is_null($properties)) {
		return class_set_instance_properties($class, array($property => 0));
	}

	$properties[$property]=0;

	return $class;
}

function class_remove_instance_property(&$class, $property) {
	$properties=&class_instance_properties($class);

	if (!is_null($properties)) {
		unset($properties[$property]);
	}

	return $class;
}

function &class_attributes($class) {
	return $class->attributes;
}

function class_set_attributes($class, $data) {
	$class->attributes=$data;

	return $class;
}

function class_is_kind_of($class, $aclass) {
	if ($class === $aclass) {
		return true;
	}

	$superclass=class_superclass($class);

	return $superclass ? class_is_kind_of($superclass, $aclass) : false;
}

//

function class_get($class, $attribute) {
	if (!class_find_class_property($class, $attribute)) {
		return class_send_message($class, 'doesNotContain', array($attribute));
	}

	$attributes=class_attributes($class);

	return isset($attributes[$attribute]) ? $attributes[$attribute] : false;
}

function class_set($class, $attribute, $value) {
	if (!class_find_class_property($class, $attribute)) {
		return class_send_message($class, 'doesNotContain', array($attribute));
	}

	$attributes=&class_attributes($class);

	$attributes[$attribute]=$value;

	return $class;
}

//

function class_make($class) {
	return new Instance($class);
}

//

function class_check($class) {
	$errs=array(array(), array(), array(), array());

	$defined_functions=get_defined_functions();

	$class_name=class_name($class);

	$prefix=strtolower($class_name) . '\\' . 'c_';
	$len=strlen($prefix);

	$class_messages=class_class_messages($class);
	if ($class_messages) {
		$class_messages=array_map('strtolower', array_keys($class_messages));
	}

	$class_functions=array_filter($defined_functions['user'], create_function('$fname', "return strncmp(\$fname, '$prefix', $len) == 0; return false;"));

	if ($class_messages) {
		foreach ($class_messages as $msg) {
			if (!function_exists($prefix . $msg)) {
				$errs[0][]=$msg;
			}
		}
	}

	foreach ($class_functions as $f) {
		$msg=substr($f, $len);
		if (is_null($class_messages) or !isset($class_messages[$msg])) {
			$errs[1][]=$msg;
		}
	}

	$prefix=strtolower($class_name) . '\\' . 'i_';
	$len=strlen($prefix);

	$instance_messages=class_instance_messages($class);
	if ($instance_messages) {
		$instance_messages=array_map('strtolower', array_keys($instance_messages));
	}

	$instance_functions=array_filter($defined_functions['user'], create_function('$fname', "return strncmp(\$fname, '$prefix', $len) == 0;"));

	if ($instance_messages) {
		foreach ($instance_messages as $msg) {
			if (!function_exists($prefix . $msg)) {
				$errs[2][]=$msg;
			}
		}
	}

	foreach ($instance_functions as $f) {
		$msg=substr($f, $len);
		if (is_null($instance_messages) or !isset($instance_messages[$msg])) {
			$errs[3][]=$msg;
		}
	}

	return $errs;
}

//

function object_class($object) {
	return $object->class;
}

function object_superclass($object) {
	return class_superclass(object_class($object));
}

function object_assume($object, $class) {
	$object->class=$class;

	return $object;
}

function &object_attributes($object) {
	return $object->attributes;
}

function object_set_attributes($object, $data) {
	$object->attributes=$data;

	return $object;
}

//

function object_get($object, $attribute) {
	if (!class_find_instance_property(object_class($object), $attribute)) {
		return object_send_message($object, 'doesNotContain', array($attribute));
	}

	$attributes=object_attributes($object);

	return isset($attributes[$attribute]) ? $attributes[$attribute] : false;
}

function object_set($object, $attribute, $value) {
	if (!class_find_instance_property(object_class($object), $attribute)) {
		return object_send_message($object, 'doesNotContain', array($attribute));
	}

	$attributes=&object_attributes($object);

	$attributes[$attribute]=$value;

	return $object;
}

//

function object_copy($object) {
	return clone $object;
}

//

function class_find_class_property($class, $property) {
	$properties=class_class_properties($class);

	if (!is_null($properties) and isset($properties[$property])) {
		return $property;
	}

	$superclass=class_superclass($class);

	return $superclass ? class_find_class_property($superclass, $property) : false;
}

function class_find_instance_property($class, $property) {
	$properties=class_instance_properties($class);

	if (!is_null($properties) and isset($properties[$property])) {
		return $property;
	}

	$superclass=class_superclass($class);

	return $superclass ? class_find_instance_property($superclass, $property) : false;
}

function class_find_class_method_class($class, $message) {
	$messages=class_class_messages($class);

	if (!is_null($messages) and isset($messages[$message])) {
		return $class;
	}

	$superclass=class_superclass($class);

	return $superclass ? class_find_class_method_class($superclass, $message) : false;
}

function class_find_class_method($class, $message) {
	$class=class_find_class_method_class($class, $message);

	return $class ? class_class_method_symbol($class, $message) : false;
}

function class_find_instance_method_class($class, $message) {
	$messages=class_instance_messages($class);

	if (!is_null($messages) and isset($messages[$message])) {
		return $class;
	}

	$superclass=class_superclass($class);

	return $superclass ? class_find_instance_method_class($superclass, $message) : false;
}

function class_find_instance_method($class, $message) {
	$class=class_find_instance_method_class($class, $message);

	return $class ? class_instance_method_symbol($class, $message) : false;
}

//

function class_apply_method($class, $method, $arguments=false) {
	return call_user_func_array($method, $arguments ? array_merge(array($class), $arguments) : array($class));
}

function class_send_message($class, $message, $arguments=false) {
	$_class=class_find_class_method_class($class, $message);

	if (!$_class) {
		return class_send_message($class, 'doesNotRecognize', array($message));
	}

	$method=class_class_method_symbol($_class, $message);

	return class_apply_method($class, $method, $arguments);
}

function class_super_send_message($fromclass, $class, $message, $arguments=false) {
	$superclass=class_superclass($fromclass);

	$_class=class_find_class_method_class($superclass, $message);

	if (!$_class) {
		return class_super_send_message($class, $fromclass, 'doesNotRecognize', array($message));
	}

	$method=class_class_method_symbol($_class, $message);

	return class_apply_method($class, $method, $arguments);
}

function object_apply_method($object, $method, $arguments=false) {
	return call_user_func_array($method, $arguments ? array_merge(array($object), $arguments) : array($object));
}

function object_send_message($object, $message, $arguments=false) {
	$class=object_class($object);

	$_class=class_find_instance_method_class($class, $message);

	if (!$_class) {
		return object_send_message($object, 'doesNotRecognize', array($message));
	}

	$method=class_instance_method_symbol($_class, $message);

	return object_apply_method($object, $method, $arguments);
}

function object_super_send_message($fromclass, $object, $message, $arguments=false) {
	$superclass=class_superclass($fromclass);

	$_class=class_find_instance_method_class($superclass, $message);

	if (!$_class) {
		return object_super_send_message($object, $fromclass, 'doesNotRecognize', array($message));
	}

	$method=class_instance_method_symbol($_class, $message);

	return object_apply_method($object, $method, $arguments);
}

