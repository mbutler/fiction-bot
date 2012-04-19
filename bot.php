r<?php
require_once 'User.php';
require_once 'functions.php';
require_once 'Message.php';

//set path to source document
$file = 'random.txt'; // if cron can't find this then make it an absolute path
//no reply by default
$reply_to = "";

$user = new User();

if ($user->hasNewMention() == TRUE && randomChance(2) == TRUE) {
	$status = 3;
	$reply_to = $user->latest_mentioner_name . " ";
} else if (randomChance(1) == TRUE) {
	$status = 2;
	$reply_to = $user->getRandomFriend() . " ";
} else if (randomChance(2) == TRUE) {
	$status = 1;
} else {
	$status = 0;
}

//echo $status;
$message = new Message($file, $reply_to);

$user->makePost($status, $message->text, $user->latest_mention_id);


?>
