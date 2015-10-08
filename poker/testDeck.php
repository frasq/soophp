<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(getcwd() . PATH_SEPARATOR . dirname(getcwd()));

require_once 'So-o.php';

require_once 'Deck.php';

$deck=sendmsg($Deck, 'new', true);
sendmsg($deck, 'print', true);
sendmsg($deck, 'shuffle');
sendmsg($deck, 'print', true);

$card=sendmsg($deck, 'deal');
sendmsg($card, 'print', true);

for ($n=0; $n < 5; $n++) {
	sendmsg(sendmsg($deck, 'hand'), 'print', true);
}

$ndeals=10000;
$stats=array();
for ($i=0; $i < 9; $i++ ) {
	$stats[$i] = 0;
}
echo 'Dealing ', $ndeals, ' hands...';
$starttime=time();

$hand=sendmsg($deck, 'hand');
/*
for ($n=0; $n < $ndeals; $n++ ) {
	$stats[ sendmsg(sendmsg($deck, 'hand'), 'evaluate') ]++;
}
*/
for ($n=0; $n < $ndeals; $n++ ) {
	$stats[ sendmsg(sendmsg($deck, 'hand', $hand), 'evaluate') ]++;
}
echo ' in ', time()-$starttime, ' seconds.', PHP_EOL;

static $handnames=array(
	'NOTHING',
	'ONEPAIR',
	'TWOPAIRS',
	'THREEOFKIND',
	'STRAIGHT',
	'FLUSH',
	'FULLHOUSE',
	'FOUROFKIND',
	'STRAIGHTFLUSH',
);

// find longest header
$width = 0;
foreach ($handnames as $s) {
	$w = strlen($s);
	if ($w > $width) {
		$width=$w;
	}
}

for ($i=0; $i < 9; $i++ ) {
	echo str_repeat(' ', $width - strlen($handnames[$i])), $handnames[$i], '->', $stats[$i], "\t", sprintf('%5.2f%%', $stats[$i]/($ndeals/100.0)), PHP_EOL;
}
