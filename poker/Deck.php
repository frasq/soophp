<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Deck;

require_once 'So-o.php';

require_once 'Card.php';
require_once 'Hand.php';

defclass('Deck', null, 1, null, array('cards', 'top', 'shuffleWhenEmpty'), null, array('init', 'deal', 'hand', 'shuffle', 'check', 'toString'));

function i_init($self, $swe=false) {
	global $Card;

	supersend('init', func_get_args());

	sendmsg($self, 'set', 'shuffleWhenEmpty', $swe ? true : false);

	$cards=array();
	for ($s = 0; $s < 4; $s++) {
		for ($r = 0; $r < 13; $r++) {
			$cards[ 13*$s+$r ] = sendmsg($Card, 'new', $r, $s);
		}
	}
	sendmsg($self, 'set', 'cards', $cards);
	sendmsg($self, 'set', 'top', 0);

	return $self;
}

function i_shuffle($self) {
	$cards=sendmsg($self, 'get', 'cards');

	shuffle($cards);

	sendmsg($self, 'set', 'cards', $cards);
	sendmsg($self, 'set', 'top', 0);

	return $self;
}

function i_check($self) {
	$top=sendmsg($self, 'get', 'top');

	if (++$top >= 52) {
		if (sendmsg($self, 'get', 'shuffleWhenEmpty')) {
			sendmsg($self, 'shuffle');
		}
		$top=0;
	}

	sendmsg($self, 'set', 'top', $top);

	return $self;
}

function i_deal($self) {
	$cards=sendmsg($self, 'get', 'cards');
	$top=sendmsg($self, 'get', 'top');

	$c = $cards[$top];

	sendmsg($self, 'check');

	return $c;
}

function i_hand($self, $hand=null) {
	global $Hand;

	$cards=array();

	for ($n=0; $n < 5; $n++) {
		$cards[]=sendmsg($self, 'deal');
	}

	return $hand ? sendmsg($hand, 'init', $cards) : sendmsg($Hand, 'new', $cards);
}

function i_toString($self) {
	$cards=sendmsg($self, 'get', 'cards');
	$top=sendmsg($self, 'get', 'top');

	foreach ($cards as $c) {
		$s[]=sendmsg($c, 'toString');
	}

	return implode(',', $s) . ' ' . $top;
}

