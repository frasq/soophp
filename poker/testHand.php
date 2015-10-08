<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(getcwd() . PATH_SEPARATOR . dirname(getcwd()));

require_once 'So-o.php';

require_once 'Hand.php';

$card1=sendmsg($Card, 'new', \Card\ACE, \Card\SPADES);
$card2=sendmsg($Card, 'new', \Card\THREE, \Card\CLUBS);
$card3=sendmsg($Card, 'new', \Card\ACE, \Card\DIAMONDS);
$card4=sendmsg($Card, 'new', \Card\JACK, \Card\HEARTS);
$card5=sendmsg($Card, 'new', \Card\SIX, \Card\SPADES);

$hand=sendmsg($Hand, 'new', array($card1, $card2, $card3, $card4, $card5));

sendmsg($hand, 'print', true);
sendmsg($hand, 'reorder');
sendmsg($hand, 'print', true);
sendmsg(sendmsg($hand, 'card', 1), 'print', true);
sendmsg($hand, 'setCard', 2, sendmsg($Card, 'new', \Card\ACE, \Card\HEARTS));
sendmsg($hand, 'print', true);

$testhands=array(
	array(array(\Card\JACK, \Card\SPADES), array(\Card\KING, \Card\HEARTS), array(\Card\ACE, \Card\DIAMONDS), array(\Card\TWO, \Card\CLUBS), array(\Card\FIVE, \Card\SPADES)),
	array(array(\Card\ACE, \Card\SPADES), array(\Card\THREE, \Card\CLUBS), array(\Card\FOUR, \Card\DIAMONDS), array(\Card\THREE, \Card\HEARTS), array(\Card\SIX, \Card\SPADES)),
	array(array(\Card\SEVEN, \Card\SPADES), array(\Card\KING, \Card\HEARTS), array(\Card\SEVEN, \Card\DIAMONDS), array(\Card\JACK, \Card\CLUBS), array(\Card\JACK, \Card\SPADES)),
	array(array(\Card\FOUR, \Card\SPADES), array(\Card\NINE, \Card\HEARTS), array(\Card\NINE, \Card\DIAMONDS), array(\Card\EIGHT, \Card\CLUBS), array(\Card\NINE, \Card\SPADES)),
	array(array(\Card\KING, \Card\HEARTS), array(\Card\JACK, \Card\DIAMONDS), array(\Card\QUEEN, \Card\CLUBS), array(\Card\TEN, \Card\SPADES), array(\Card\ACE, \Card\DIAMONDS)),
	array(array(\Card\FOUR, \Card\HEARTS), array(\Card\NINE, \Card\HEARTS), array(\Card\ACE, \Card\HEARTS), array(\Card\SEVEN, \Card\HEARTS), array(\Card\QUEEN, \Card\HEARTS)),
	array(array(\Card\FOUR, \Card\SPADES), array(\Card\TEN, \Card\HEARTS), array(\Card\TEN, \Card\DIAMONDS), array(\Card\FOUR, \Card\CLUBS), array(\Card\TEN, \Card\SPADES)),
	array(array(\Card\KING, \Card\DIAMONDS), array(\Card\JACK, \Card\DIAMONDS), array(\Card\QUEEN, \Card\DIAMONDS), array(\Card\TEN, \Card\DIAMONDS), array(\Card\ACE, \Card\DIAMONDS)),
);

foreach ($testhands as $h) {
	$cards=array();
	foreach ($h as $c) {
		$cards[]=sendmsg($Card, 'new', $c[0], $c[1]);
	}
	sendmsg(sendmsg($Hand, 'new', $cards), 'print', true);
}
