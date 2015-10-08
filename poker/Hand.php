<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

namespace Hand;

use \InvalidArgumentException as InvalidArgumentException;

require_once 'So-o.php';

require_once 'Card.php';

define(__NAMESPACE__ . '\NOTHING',			0);
define(__NAMESPACE__ . '\ONEPAIR',			1);
define(__NAMESPACE__ . '\TWOPAIRS',			2);
define(__NAMESPACE__ . '\THREEOFKIND',		3);
define(__NAMESPACE__ . '\STRAIGHT',			4);
define(__NAMESPACE__ . '\FLUSH',			5);
define(__NAMESPACE__ . '\FULLHOUSE',		6);
define(__NAMESPACE__ . '\FOUROFKIND',		7);
define(__NAMESPACE__ . '\STRAIGHTFLUSH',	8);

defclass('Hand', null, 1, null, array('cards'), null, array('init', 'reorder', 'card', 'setCard', 'isOnePair', 'isTwoPairs', 'isThreeOfKind', 'isStraight', 'isFlush', 'isFullHouse', 'isFourOfKind', 'isStraightFlush', 'evaluate', 'toString'));

function i_init($self, $cards) {
	if (!is_array($cards) or count($cards) != 5) {
		throw new InvalidArgumentException();
	}

	supersend('init', func_get_args());

	sendmsg($self, 'set', 'cards', $cards);

	return $self;
}

function i_reorder($self) {
	$cards=sendmsg($self, 'get', 'cards');

	usort($cards, create_function('$c1, $c2', "return sendmsg(\$c1, 'compare', \$c2);"));

	sendmsg($self, 'set', 'cards', $cards);

	return $self;
}

function i_card($self, $n) {
	if (!(is_int($n) and $n >= 1 and $n <= 5)) {
		throw new InvalidArgumentException();
	}

	$cards=sendmsg($self, 'get', 'cards');

	return $cards[$n-1];
}

function i_setCard($self, $n, $card) {
	if (!(is_int($n) and $n >= 1 and $n <= 5)) {
		throw new InvalidArgumentException();
	}

	$cards=sendmsg($self, 'get', 'cards');

	$cards[$n-1]=$card;

	return sendmsg($self, 'set', 'cards', $cards);
}

function i_toString($self) {
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

	$cards=sendmsg($self, 'get', 'cards');
	$eval=sendmsg($self, 'evaluate');

	foreach ($cards as $c) {
		$s[]=sendmsg($c, 'toString');
	}

	return implode(',', $s) . ' -> ' . $handnames[$eval];
}

function i_isOnePair($self) {
	// aabcd abbcd abccd abcdd
	$cards=sendmsg($self, 'get', 'cards');

	$r1 = sendmsg($cards[0], 'rank');
	$r2 = sendmsg($cards[1], 'rank');
	$r3 = sendmsg($cards[2], 'rank');
	$r4 = sendmsg($cards[3], 'rank');
	$r5 = sendmsg($cards[4], 'rank');

	if ($r1 == $r2 && $r2 != $r3 && $r3 != $r4 && $r4 != $r5) {
		return true;
	}
	if ($r1 != $r2 && $r2 == $r3 && $r3 != $r4 && $r4 != $r5) {
		return true;
	}
	if ($r1 != $r2 && $r2 != $r3 && $r3 == $r4 && $r4 != $r5) {
		return true;
	}
	if ($r1 != $r2 && $r2 != $r3 && $r3 != $r4 && $r4 == $r5) {
		return true;
	}
	return false;
}

function i_isTwoPairs($self) {
	// aabbc aabcc abbcc
	$cards=sendmsg($self, 'get', 'cards');

	$r1 = sendmsg($cards[0], 'rank');
	$r2 = sendmsg($cards[1], 'rank');
	$r3 = sendmsg($cards[2], 'rank');
	$r4 = sendmsg($cards[3], 'rank');
	$r5 = sendmsg($cards[4], 'rank');

	if ($r1 == $r2 && $r2 != $r3 && $r3 == $r4 && $r4 != $r5) {
		return true;
	}
	if ($r1 == $r2 && $r2 != $r3 && $r3 != $r4 && $r4 == $r5) {
		return true;
	}
	if ($r1 != $r2 && $r2 == $r3 && $r3 != $r4 && $r4 == $r5) {
		return true;
	}

	return false;
}

function i_isThreeOfKind($self) {
	// aaabc abbbc abccc
	$cards=sendmsg($self, 'get', 'cards');

	$r1 = sendmsg($cards[0], 'rank');
	$r2 = sendmsg($cards[1], 'rank');
	$r3 = sendmsg($cards[2], 'rank');
	$r4 = sendmsg($cards[3], 'rank');
	$r5 = sendmsg($cards[4], 'rank');

	if ($r1 == $r2 && $r2 == $r3 && $r3 != $r4 && $r4 != $r5) {
		return true;
	}
	if ($r1 != $r2 && $r2 == $r3 && $r3 == $r4 && $r4 != $r5) {
		return true;
	}
	if ($r1 != $r2 && $r2 != $r3 && $r3 == $r4 && $r4 == $r5) {
		return true;
	}

	return false;
}

function i_isStraight($self) {
	// a(a+1)(a+2)(a+3)(a+4)
	$cards=sendmsg($self, 'get', 'cards');

	$r1 = sendmsg($cards[0], 'rank');
	$r2 = sendmsg($cards[1], 'rank');
	$r3 = sendmsg($cards[2], 'rank');
	$r4 = sendmsg($cards[3], 'rank');
	$r5 = sendmsg($cards[4], 'rank');

	if ($r5 == $r4+1 && $r4 == $r3+1 && $r3 == $r2+1 && $r2 == $r1+1) {
		return true;	// could be a straight flush
	}

	return false;
}

function i_isFlush($self) {
	$cards=sendmsg($self, 'get', 'cards');

	$s1 = sendmsg($cards[0], 'suit');
	$s2 = sendmsg($cards[1], 'suit');
	$s3 = sendmsg($cards[2], 'suit');
	$s4 = sendmsg($cards[3], 'suit');
	$s5 = sendmsg($cards[4], 'suit');

	if ($s1 == $s2 && $s2 == $s3 && $s3 == $s4 && $s4 == $s5) {
		return true;	// could be a straight flush
	}

	return false;
}

function i_isFullHouse($self) {
	// aaabb aabbb
	$cards=sendmsg($self, 'get', 'cards');

	$r1 = sendmsg($cards[0], 'rank');
	$r2 = sendmsg($cards[1], 'rank');
	$r3 = sendmsg($cards[2], 'rank');
	$r4 = sendmsg($cards[3], 'rank');
	$r5 = sendmsg($cards[4], 'rank');

	if ($r1 == $r2 && $r2 == $r3 && $r3 != $r4 && $r4 == $r5) {
		return true;
	}
	if ($r1 == $r2 && $r2 != $r3 && $r3 == $r4 && $r4 == $r5) {
		return true;
	}

	return false;
}

function i_isFourOfKind($self) {
	// aaaab abbbb
	$cards=sendmsg($self, 'get', 'cards');

	$r1 = sendmsg($cards[0], 'rank');
	$r2 = sendmsg($cards[1], 'rank');
	$r3 = sendmsg($cards[2], 'rank');
	$r4 = sendmsg($cards[3], 'rank');
	$r5 = sendmsg($cards[4], 'rank');

	if ($r1 == $r2 && $r2 == $r3 && $r3 == $r4) {
		return true;
	}
	if ($r2 == $r3 && $r3 == $r4 && $r4 == $r5) {
		return true;
	}

	return false;
}

function i_isStraightFlush($self) {
	// a(a+1)(a+2)(a+3)(a+4)
	if (sendmsg($self, 'isStraight') and sendmsg($self, 'isFlush')) {
		return true;
	}

	return false;
}

function i_evaluate($self) {
	// sort or nothing works!
	$copy=sendmsg(sendmsg($self, 'copy'), 'reorder');
	// DON'T change order
	if (sendmsg($copy, 'isStraightFlush')) {
		return STRAIGHTFLUSH;
	}
	if (sendmsg($copy, 'isFourOfKind')) {
		return FOUROFKIND;
	}
	if (sendmsg($copy, 'isFullHouse')) {
		return FULLHOUSE;
	}
	if (sendmsg($copy, 'isFlush')) {
		return FLUSH;
	}
	if (sendmsg($copy, 'isStraight')) {
		return STRAIGHT;
	}
	if (sendmsg($copy, 'isThreeOfKind')) {
		return THREEOFKIND;
	}
	if (sendmsg($copy, 'isTwoPairs')) {
		return TWOPAIRS;
	}
	if (sendmsg($copy, 'isOnePair')) {
		return ONEPAIR;
	}

	return NOTHING;
}

