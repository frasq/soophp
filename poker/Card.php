<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Card;

require_once 'So-o.php';

define(__NAMESPACE__ . '\TWO',		0);
define(__NAMESPACE__ . '\THREE',	1);
define(__NAMESPACE__ . '\FOUR',		2);
define(__NAMESPACE__ . '\FIVE',		3);
define(__NAMESPACE__ . '\SIX',		4);
define(__NAMESPACE__ . '\SEVEN',	5);
define(__NAMESPACE__ . '\EIGHT',	6);
define(__NAMESPACE__ . '\NINE',		7);
define(__NAMESPACE__ . '\TEN',		8);
define(__NAMESPACE__ . '\JACK',		9);
define(__NAMESPACE__ . '\QUEEN',	10);
define(__NAMESPACE__ . '\KING',		11);
define(__NAMESPACE__ . '\ACE',		12);

define(__NAMESPACE__ . '\CLUBS',	0);
define(__NAMESPACE__ . '\DIAMONDS',	1);
define(__NAMESPACE__ . '\HEARTS',	2);
define(__NAMESPACE__ . '\SPADES',	3);

defclass('Card', null, 1, null, array('rank', 'suit'), null, array('init', 'rank', 'suit', 'compare', 'toString'));

function i_init($self, $rank, $suit) {
	supersend('init', func_get_args());

	sendmsg($self, 'set', 'rank', $rank);
	sendmsg($self, 'set', 'suit', $suit);

	return $self;
}

function i_rank($self) {
	return sendmsg($self, 'get', 'rank');
}

function i_suit($self) {
	return sendmsg($self, 'get', 'suit');
}

function i_compare($self, $aCard) {
	$rank1=sendmsg($self, 'get', 'rank');
	$rank2=sendmsg($aCard, 'get', 'rank');

	return $rank1 == $rank2 ? 0 : $rank1 > $rank2 ? 1 : -1;
}

function i_toString($self) {
	static $srank=array(TWO => '2', THREE => '3', FOUR => '4', FIVE => '5', SIX => '6', SEVEN => '7', EIGHT => '8', NINE => '9', TEN => '10', JACK => 'J', QUEEN => 'Q', KING => 'K', ACE => 'A');
	static $ssuit=array(CLUBS => 'c', DIAMONDS => 'd', HEARTS => 'h', SPADES => 's');

	$rank=sendmsg($self, 'get', 'rank');
	$suit=sendmsg($self, 'get', 'suit');

	return $srank[$rank] . $ssuit[$suit];
}
