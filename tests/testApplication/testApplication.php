<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(getcwd() . PATH_SEPARATOR . dirname(dirname(getcwd())));

require_once 'So-o.php';

require_once 'Application.php';

require_once 'Calculator.php';
require_once 'CalculatorHelper.php';

require_once 'dump.php';

$calc_helper=sendmsg($CalculatorHelper, 'new');

$calc=sendmsg($Calculator, 'new', $calc_helper);

$app=sendmsg($Application, 'new', 'Calculator', $calc);
dump(sendmsg($app, 'appName'));
dump(sendmsg($app, 'value'));

sendmsg($calc, 'clear');
sendmsg($calc, 'add', 5);
sendmsg($calc, 'sqrt');
sendmsg($calc, 'add', 1);
sendmsg($calc, 'div', 2);
$n=sendmsg($calc, 'value');

dump($n);

dump(sendmsg($app, 'value'));

sendmsg($calc, 'sto');
sendmsg($calc, 'clear');
sendmsg($calc, 'rcl');
dump(sendmsg($calc, 'value'));

sendmsg($calc, 'clear');
sendmsg($calc, 'add', 1);
sendmsg($calc, 'div', $n);
dump(sendmsg($calc, 'value'));

sendmsg($calc, 'clear');
sendmsg($calc, 'add', $n);
sendmsg($calc, 'mul', $n);
dump(sendmsg($calc, 'value'));
