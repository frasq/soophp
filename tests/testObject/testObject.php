<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(getcwd() . PATH_SEPARATOR . dirname(dirname(getcwd())));

require_once 'So-o.php';

require_once 'X.php';
require_once 'Y.php';
require_once 'Z.php';

require_once 'dump.php';

$z=sendmsg($Z, 'new');

dump(sendmsg($X, 'name'));
dump(sendmsg($X, 'revision'));

dump(sendmsg($Y, 'perform', 'name'));

$x=sendmsg($X, 'new');
dump(sendmsg(sendmsg($x, 'class'), 'name'));
dump(sendmsg($X, 'count'));
sendmsg($x, 'f', 4);

$y=sendmsg($Y, 'new');

dump(sendmsg(sendmsg($y, 'superclass'), 'name'));
dump(sendmsg($Y, 'revision'));
dump(sendmsg($X, 'count'));

dump(sendmsg($X, 'get', 'count'));
sendmsg($X, 'set', 'count', 10);
$data=sendmsg($X, 'write');
dump($data);
sendmsg($X, 'read', $data);
dump(sendmsg($X, 'get', 'count'));

sendmsg($y, 'perform', 'f', array(4));

dump(sendmsg($X, 'classMessages'));
dump(sendmsg($X, 'instanceMessages'));
dump(sendmsg($Y, 'classMessages'));
dump(sendmsg($X, 'classMessages', false));
dump(sendmsg($Y, 'instanceMessages', false));

dump(sendmsg($X, 'classProperties'));
dump(sendmsg($X, 'instanceProperties'));
dump(sendmsg($Y, 'classProperties'));
dump(sendmsg($X, 'classProperties', false));
dump(sendmsg($X, 'instanceProperties', false));

dump(sendmsg($X, 'classMethodFor', 'count'));
dump(sendmsg($Y, 'classMethodFor', 'count'));

dump(sendmsg($X, 'instanceMethodFor', 'f'));
dump(sendmsg($Y, 'instanceMethodFor', 'f'));

sendmsg($Y, 'addClassMessage', 'supercount');
dump(sendmsg($Y, 'classMessages', false));
dump(sendmsg($Y, 'supercount'));
sendmsg($Y, 'removeClassMessage', 'supercount');
dump(sendmsg($Y, 'classMessages', false));

sendmsg($y, 'g');
sendmsg($Y, 'addInstanceMessage', 'g');
dump(sendmsg($Y, 'instanceMessages', false));
sendmsg($y, 'g');
sendmsg($Y, 'removeInstanceMessage', 'g');
dump(sendmsg($Y, 'instanceMessages', false));
sendmsg($y, 'g');

sendmsg($Y, 'addClassProperty', 'foobar');
dump(sendmsg($Y, 'classProperties', false));
sendmsg($Y, 'removeClassProperty', 'foobar');
dump(sendmsg($Y, 'classProperties', false));

sendmsg($Y, 'addInstanceProperty', 'foobar');
dump(sendmsg($Y, 'instanceProperties', false));
sendmsg($Y, 'removeInstanceProperty', 'foobar');
dump(sendmsg($Y, 'instanceProperties', false));

// dump(sendmsg($X, 'error', '%s::%s', sendmsg($X, 'name'), 'foobar'));
// dump(sendmsg($x, 'error', '%s::%s', sendmsg($X, 'name'), 'foobar'));

// dump(sendmsg($X, 'doesNotRecognize', 'foobar'));
// dump(sendmsg($X, 'doesNotContain', 'foobar'));

// dump(sendmsg($x, 'doesNotRecognize', 'foobar'));
// dump(sendmsg($x, 'doesNotContain', 'foobar'));

// dump(sendmsg($x, 'notImplemented', 'foobar'));
// dump(sendmsg($x, 'subclassResponsibility', 'foobar'));

// sendmsg($X, 'foobar');
// sendmsg($x, 'foobar');

sendmsg($X, 'addClassMessage', 'foobar');
dump(sendmsg($X, 'check'));
sendmsg($X, 'removeClassMessage', 'foobar');
dump(sendmsg($X, 'check'));
sendmsg($X, 'addInstanceMessage', 'foobar');
dump(sendmsg($X, 'check'));
sendmsg($X, 'removeInstanceMessage', 'foobar');
dump(sendmsg($X, 'check'));

dump(sendmsg(sendmsg($y, 'class'), 'name'));
dump(sendmsg(sendmsg($y, 'superclass'), 'name'));

dump(sendmsg(sendmsg(sendmsg($y, 'assume', $X), 'class'), 'name'));
dump(sendmsg(sendmsg(sendmsg($y, 'assume', $Y), 'class'), 'name'));

dump(sendmsg($y, 'messages'));
dump(sendmsg($y, 'properties'));
dump(sendmsg($y, 'messages', true));
dump(sendmsg($y, 'properties', true));
dump(sendmsg($y, 'isKindOf', $Object));
dump(sendmsg($y, 'methodFor', 'perform'));
dump(sendmsg($y, 'methodFor', 'free'));
dump(sendmsg($y, 'respondsTo', 'free'));
dump(sendmsg($y, 'respondsTo', 'foobar'));

sendmsg($X, 'addInstanceMessage', 'init');
sendmsg($y, 'init');

$x=sendmsg($X, 'new');
sendmsg($x, 'set', 'value', 1);
dump(sendmsg($x, 'get', 'value'));
$data=sendmsg($x, 'write');
dump($data);
sendmsg($x, 'set', 'value', 0);
dump(sendmsg($x, 'get', 'value'));
sendmsg($x, 'read', $data);
dump(sendmsg($x, 'get', 'value'));
sendmsg($x, 'read', serialize(array()));
dump(sendmsg($x, 'get', 'value'));

dump(sendmsg($Y, 'perform', 'revision'));

sendmsg($X, 'addInstanceProperty', 'delegate');
dump(sendmsg($x, 'delegate'));
sendmsg($x, 'setDelegate', $y);
sendmsg($y, 'echo', 'Hello', ', ', 'world', '!');
sendmsg($x, 'delegate', 'echo', 'Hello', ', ', 'world', '!');
sendmsg($x, 'delegate', 'foobar');
sendmsg($y, 'delegate', 'echo', 'Hello', ', ', 'world', '!');
