<?php
require_once 'User.php';
require_once 'functions.php';
require_once 'Message.php';

//set path to source document
$file = 'random.txt'; // if cron can't find this then make it an absolute path
//no reply by default
$reply_to = "";

$user = new User();
$percent = 2; //percent chance the bot will respond to another bot

//if the latest mentioner is a real person there is a 100% chance of responding
if (in_array($user->latest_mentioner_name, $user->friendList())) {
	$percent = 2;
} else {
	$percent = 100;
}

/* status codes
3 - there is a new mention and a possible response
2 - a chance there will be a random mention not in response
1 - a chance there will be a random post
0 - nothing happens
*/

if ($user->hasNewMention() == TRUE && randomChance($percent) == TRUE) {
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
