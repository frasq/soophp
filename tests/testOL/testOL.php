<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(getcwd() . PATH_SEPARATOR . dirname(dirname(getcwd())));

require_once 'So-o.php';

require_once 'Object.php';
require_once 'X.php';
require_once 'Y.php';

require_once 'dump.php';

echo $Object, PHP_EOL;

dump(\OL\class_name($Object));
dump(\OL\class_revision($Object));

dump(\OL\class_class_method_symbol($Object, 'name'));
dump(\OL\class_instance_method_symbol($Object, 'name'));

dump(\OL\class_superclass($Object));
dump(\OL\class_name(\OL\class_superclass($X)));

dump(\OL\class_class_properties($Object));
dump(\OL\class_class_messages($Object));
dump(\OL\class_instance_properties($X));
dump(\OL\class_instance_messages($Object));

\OL\class_add_class_message($Object, 'foobar');
dump(\OL\class_class_messages($Object));
\OL\class_remove_class_message($Object, 'foobar');
dump(\OL\class_class_messages($Object));

\OL\class_add_instance_message($Object, 'foobar');
dump(\OL\class_instance_messages($Object));
\OL\class_remove_instance_message($Object, 'foobar');
dump(\OL\class_instance_messages($Object));

\OL\class_add_class_property($Object, 'foobar');
dump(\OL\class_class_properties($Object));
\OL\class_remove_class_property($Object, 'foobar');
dump(\OL\class_class_properties($Object));

\OL\class_add_instance_property($Object, 'foobar');
dump(\OL\class_instance_properties($Object));
\OL\class_remove_instance_property($Object, 'foobar');
dump(\OL\class_instance_properties($Object));

dump(\OL\class_attributes($Object));

dump(\OL\class_is_kind_of($Object, $Object));
dump(\OL\class_is_kind_of($X, $Object));
dump(\OL\class_is_kind_of($Object, $X));
dump(\OL\class_is_kind_of($Y, $Object));

\OL\class_add_class_property($Object, 'debug');
dump(\OL\class_get($Object, 'debug'));
dump(\OL\class_get(\OL\class_set($Object, 'debug', true), 'debug'));
dump(\OL\class_get(\OL\class_set($Object, 'debug', false), 'debug'));

$obj=\OL\class_make($Object);
dump(\OL\class_name(\OL\object_class($obj)));

$x=\OL\class_make($X);
dump(\OL\class_name(\OL\object_class($x)));
dump(\OL\class_name(\OL\object_superclass($x)));

$y=\OL\class_make($Y);
dump(\OL\class_name(\OL\object_class($y)));
dump(\OL\class_name(\OL\object_superclass($y)));

\OL\object_assume($obj, $X);
dump(\OL\class_name(\OL\object_class($obj)));

$obj=\OL\class_make($Object);
$x=\OL\class_make($X);
$y=\OL\class_make($Y);

$x=\OL\class_make($X);
$y=\OL\class_make($Y);
dump(\OL\object_attributes($x));
dump(\OL\object_get($x, 'value'));
dump(\OL\object_get(\OL\object_set($x, 'value', 1), 'value'));
dump(\OL\object_get(\OL\object_set($y, 'value', 1), 'value'));

dump(\OL\class_find_class_property($Object, 'debug'));
dump(\OL\class_find_class_property($X, 'debug'));
dump(\OL\class_find_class_property($X, 'foobar'));
dump(\OL\class_find_instance_property($Y, 'value'));

dump(\OL\class_name(\OL\class_find_class_method_class($Object, 'make')));
dump(\OL\class_name(\OL\class_find_class_method_class($X, 'make')));

dump(\OL\class_find_class_method($Object, 'make'));
dump(\OL\class_find_class_method($X, 'make'));
dump(\OL\class_find_class_method($Y, 'make'));

dump(\OL\class_find_instance_method($Object, 'init'));
dump(\OL\class_find_instance_method($X, 'init'));
dump(\OL\class_find_instance_method($X, 'value'));
dump(\OL\class_find_instance_method($Y, 'value'));

// dump(\OL\class_apply_method($Object, '\Object\c_get', array('foobar')));
dump(\OL\class_apply_method($X, '\Object\c_get', array('debug')));
// \OL\class_apply_method($X, '\Object\c_set', array('foobar', true));
\OL\class_apply_method($X, '\Object\c_set', array('debug', true));
dump(\OL\class_apply_method($X, '\Object\c_get', array('debug')));

// dump(\OL\class_send_message($Object, 'get', array('foobar')));
dump(\OL\class_send_message($X, 'get', array('debug')));
// \OL\class_send_message($X, 'set', array('foobar', true));
\OL\class_send_message($X, 'set', array('debug', false));
dump(\OL\class_send_message($X, 'get', array('debug')));

$obj=\OL\class_make($Object);
$x=\OL\class_make($X);

// dump(\OL\object_apply_method($obj, '\Object\i_get', array('foobar')));
dump(\OL\object_apply_method($x, '\Object\i_get', array('value')));
// \OL\object_apply_method($obj, '\Object\i_set', array('foobar', true));
\OL\object_apply_method($x, '\Object\i_set', array('value', 1));
dump(\OL\object_send_message($x, 'get', array('value')));

// \OL\class_send_message($Object, 'doesNotRecognize', array('foobar'));
// \OL\object_send_message($obj, 'doesNotRecognize', array('foobar'));
// \OL\class_send_message($Object, 'doesNotContain', array('foobar'));
// \OL\object_send_message($obj, 'doesNotContain', array('foobar'));

dump(\OL\class_check($Object));
\OL\class_add_class_message($Object, 'foobar');
dump(\OL\class_check($Object));
\OL\class_remove_class_message($Object, 'foobar');
\OL\class_add_instance_message($Object, 'foobar');
dump(\OL\class_check($Object));
\OL\class_remove_instance_message($Object, 'foobar');
