<?php

require_once 'twitteroauth.php';
require_once 'keys.php';

class User {
	
	public $id;
	public $name;
	public $latest_tweet_id;
	public $latest_tweet_text;
	public $number_following;
	public $latest_mention_id;
	public $latest_mentioner;
	public $latest_mentioner_name;
	public $random_friend;
	
	function __construct() {

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
		$creds = $connection->get('account/verify_credentials');
		$tweets = $connection->get('statuses/user_timeline');
		$friends_list = $connection->get('friends/ids');
		$latest_tweet_id = $tweets[0]->{'id_str'};	
		$list_of_mentions = $connection->get('statuses/mentions'); // , array('since_id' => $latest_tweet_id)
		$latest_mentioner = $list_of_mentions[0]->{'user'};

		$this->id = $creds->{'id'};
		$this->name = $creds->{'screen_name'};
		$this->latest_tweet_id = $tweets[0]->{'id_str'};
		$this->latest_tweet_text = $tweets[0]->{'text'};
		$this->number_following = count($friends_list->{'ids'});
		$this->latest_mention_id = $list_of_mentions[0]->{'id_str'};
		$this->latest_mentioner_name = '@' . $latest_mentioner->{'screen_name'};
		$this->random_friend = "mrsjewkes";

	}

	function hasNewMention() {
		if (!$this->latest_mention_id) {
			return FALSE;
		} else if ($this->latest_mention_id) {
			return TRUE;
		}
	}

	function makePost($status_code, $message) {
		echo $status_code;
		echo "<br />";
		echo $message;

	}

	/*
	function getRandomFriend() {
		$friend_list_index = mt_rand(0, $this->number_following-1); 
		$friend_id = $friends_list->{'ids'}[$friend_list_index];
		$friend = $connection->get('users/lookup', array('user_id' => $friend_id));

		return $friend;
	}
	*/
	
}

?>