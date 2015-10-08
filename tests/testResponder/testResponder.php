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

$x=sendmsg($X, 'new');
sendmsg($x, 'click');

$y=sendmsg($Y, 'new');
sendmsg($x, 'addNextResponder', $y);
sendmsg($x, 'click');

sendmsg($X, 'removeInstanceMessage', 'clicked');
sendmsg($x, 'click');

$z=sendmsg($Z, 'new');
sendmsg($x, 'addNextResponder', $z);
foreach (sendmsg($x, 'nextResponders') as $r) {
	echo sendmsg(sendmsg($r, 'class'), 'name'), PHP_EOL;
}
sendmsg($x, 'click');

sendmsg($x, 'removeNextResponder', $y);
sendmsg($x, 'click');

sendmsg($z, 'addNextResponder', $y);
sendmsg($x, 'click');
