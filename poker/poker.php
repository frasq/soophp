<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(dirname(getcwd()) . PATH_SEPARATOR . getcwd());

require_once 'So-o.php';

require_once 'Deck.php';

$deck=sendmsg($Deck, 'new', true);
sendmsg($deck, 'shuffle');

$stdin = fopen('php://stdin', 'r');

do {
	$hand=sendmsg($deck, 'hand');
	sendmsg($hand, 'print', true);
	echo 'Keep (1-5...)? ';
	$line = fgets($stdin);
	if ($line === false) {
		break;
	}
	trim($line);
	$keep=array_fill(1, 5, false);
	preg_match_all('/\d/', $line, $r);
	foreach ($r[0] as $n) {
		if ($n >=1 and $n <= 5) {
			$keep[$n]=true;
		}
	}

	for ($i=1; $i <= 5; $i++) {
		if (!$keep[$i]) {
			sendmsg($hand, 'setCard', $i, sendmsg($deck, 'deal'));
		}
	}
	sendmsg($hand, 'print', true);

	echo 'Play or (q)uit? ';
	$line = fgets($stdin);
	if ($line === false) {
		break;
	}
	trim($line);
	if ($line[0] == 'q' or $line[0] == 'Q') {
		break;
	}
}
while (true);

fclose($stdin);
