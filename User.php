<?php

require_once 'twitteroauth.php';
require_once 'keys.php';


class User {
	
	public $id;
	public $name;
	public $latest_tweet_id;
	public $latest_tweet_text;	
	public $latest_mention_id;
	public $latest_mentioner_name;
			
	function __construct() {

		//make connection
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);

		//establish identity
		$creds = $connection->get('account/verify_credentials');
		$this->id = $creds->{'id'};
		$this->name = $creds->{'screen_name'};

		//latest tweets and mentions
		$tweets = $connection->get('statuses/user_timeline');
		$this->latest_tweet_id = $tweets[0]->{'id_str'};
		$list_of_mentions = $connection->get('statuses/mentions', array('since_id' => $this->latest_tweet_id)); // 
		$latest_mentioner = $list_of_mentions[0]->{'user'};	
		$this->latest_tweet_text = $tweets[0]->{'text'};
		
		//get the latest mention and who made it
		$this->latest_mention_id = $list_of_mentions[0]->{'id_str'};
		$this->latest_mentioner_name = '@' . $latest_mentioner->{'screen_name'};

	}

	function hasNewMention() {
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
		$tweets = $connection->get('statuses/user_timeline');
		$latest_tweet_id = $tweets[0]->{'id_str'};
		$list_of_mentions = $connection->get('statuses/mentions', array('since_id' => $latest_tweet_id)); //
		$latest_mention_id = $list_of_mentions[0]->{'id_str'};

		if (!$latest_mention_id) {
			return FALSE;
		} else if ($latest_mention_id) {
			return TRUE;
		}
	}

	function makePost($status_code, $message) {
		//$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
		//$connection->post('statuses/update', array('status' => $message));
		echo $status_code;
		echo "<br />";
		echo $message;
	}

	function getRandomFriend() {
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
		$friends_list = $connection->get('friends/ids');
		$number_following = count($friends_list->{'ids'});
		$friend_list_index = mt_rand(0, $number_following-1);
		$friend_id = $friends_list->{'ids'}[$friend_list_index]; //"236992726";
		$friend = $connection->get('users/lookup', array('user_id' => $friend_id));
		$random_friend = "@" . $friend[0]->{'screen_name'};

		return $random_friend;

	}

}

?>