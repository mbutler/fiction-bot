<?php
require_once 'User.php';
require_once 'functions.php';
require_once 'Message.php';

//set path to source document
$file = 'random.txt'; // if cron can't find this then make it an absolute path
//no reply by default
$reply_to = "";

$cuff = new User();

if ($cuff->hasNewMention() == TRUE && randomChance(50) == TRUE) {
	$status = 3;
	$reply_to = $cuff->latest_mentioner_name . " ";
} else if (randomChance(2) == TRUE && randomChance(50) == TRUE) {
	$status = 2;
} else if (randomChance(2) == TRUE) {
	$status = 1;
} else {
	$status = 0;
}

$message = new Message($file, $reply_to);

$cuff->makePost($status, $message->text);

?>