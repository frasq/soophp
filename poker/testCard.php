<?php

/**
 *
 * @copyright  2012 so-o.org
 * @version    1
 * @link       http://www.so-o.org
 */

set_include_path(getcwd() . PATH_SEPARATOR . dirname(getcwd()));

require_once 'So-o.php';

require_once 'Card.php';

$card_2C=sendmsg($Card, 'new', \Card\TWO, \Card\CLUBS);
echo '2c (two of clubs) -> ';
sendmsg($card_2C, 'print', true);
$card_Kh=sendmsg($Card, 'new', \Card\KING, \Card\HEARTS);
echo 'Kh (king of hearts -> ';
sendmsg($card_Kh, 'print', true);
